<?php

namespace App\Http\Controllers\Api;

use App\Controlunit;
use App\Http\Transformers\LogicalSensorTransformer;
use App\LogicalSensor;
use App\LogicalSensorThreshold;
use App\PhysicalSensor;
use Cache;
use Gate;
use Illuminate\Http\Request;


/**
 * Class TerrariumController
 * @package App\Http\Controllers
 */
class LogicalSensorController extends ApiController
{
    /**
     * @var LogicalSensorTransformer
     */
    protected $logicalSensorTransformer;


    /**
     * LogicalSensorController constructor.
     * @param LogicalSensorTransformer $_logicalSensorTransformer
     */
    public function __construct(LogicalSensorTransformer $_logicalSensorTransformer)
    {
        parent::__construct();
        $this->logicalSensorTransformer = $_logicalSensorTransformer;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (Gate::denies('api-list')) {
            return $this->respondUnauthorized();
        }

        $logical_sensors = LogicalSensor::with('thresholds')
                                        ->with('physical_sensor');

        $logical_sensors = $this->filter($request, $logical_sensors)->get();

        foreach ($logical_sensors as $ls) {
            $ls->current_threshold_id = is_null($ls->current_threshold()) ? null : $ls->current_threshold()->id;
        }

        return $this->respondWithData(
            $this->logicalSensorTransformer->transformCollection(
                $logical_sensors->toArray()
            )
        );
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

        if (Gate::denies('api-read')) {
            return $this->respondUnauthorized();
        }

        $logical_sensor = LogicalSensor::with('thresholds')
                                        ->with('physical_sensor')
                                        ->find($id);

        if (!$logical_sensor) {
            return $this->respondNotFound('LogicalSensor not found');
        }

        return $this->respondWithData(
            $this->logicalSensorTransformer->transform(
                $logical_sensor->toArray()
            )
        );
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {

        if (Gate::denies('api-write:logical_sensor')) {
            return $this->respondUnauthorized();
        }

        $logical_sensor = LogicalSensor::find($id);
        if (is_null($logical_sensor)) {
            return $this->respondNotFound('LogicalSensor not found');
        }

        $ths = LogicalSensorThreshold::where('logical_sensor_id', $logical_sensor->id)->get();
        foreach ($ths as $th) {
            $th->delete();
        }

        $logical_sensor->delete();

        return $this->setStatusCode(200)->respondWithData([], [
            'redirect' => [
                'uri'   => url('logical_sensors'),
                'delay' => 2000
            ]
        ]);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        if (Gate::denies('api-write:logical_sensor')) {
            return $this->respondUnauthorized();
        }

        $logical_sensor = LogicalSensor::create();
        $logical_sensor->name = $request->input('name');
        $logical_sensor->save();

        return $this->setStatusCode(200)->respondWithData(
            [
                'id'    =>  $logical_sensor->id
            ],
            [
                'redirect' => [
                    'uri'   => url('logical_sensors/' . $logical_sensor->id . '/edit'),
                    'delay' => 100
                ]
            ]
        );

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {

        if (Gate::denies('api-write:logical_sensor')) {
            return $this->respondUnauthorized();
        }

        $logical_sensor = LogicalSensor::find($request->input('id'));
        if (is_null($logical_sensor)) {
            return $this->respondNotFound('LogicalSensor not found');
        }

        if ($request->has('physical_sensor') && strlen($request->input('physical_sensor')) > 0) {
            $physical_sensor = PhysicalSensor::find($request->input('physical_sensor'));
            if (is_null($physical_sensor)) {
                return $this->setStatusCode(422)->respondWithError('Controlunit not found');
            }
            $physical_sensor_id = $physical_sensor->id;
        }
        else {
            $physical_sensor_id = null;
        }

        $logical_sensor->name = $request->input('name');
        $logical_sensor->type = $request->input('type');
        $logical_sensor->rawvalue_lowerlimit = $request->input('lowerlimit');
        $logical_sensor->rawvalue_upperlimit = $request->input('upperlimit');
        $logical_sensor->physical_sensor_id = $physical_sensor_id;

        $logical_sensor->save();

        return $this->setStatusCode(200)->respondWithData([], [
            'redirect' => [
                'uri'   => url('logical_sensors'),
                'delay' => 1000
            ]
        ]);

    }

}
