<?php

namespace App\Http\Controllers\Api;

use App\Controlunit;
use App\Http\Transformers\PhysicalSensorTransformer;
use App\LogicalSensor;
use App\PhysicalSensor;
use Cache;
use Gate;
use Illuminate\Http\Request;


/**
 * Class TerrariumController
 * @package App\Http\Controllers
 */
class PhysicalSensorController extends ApiController
{
    /**
     * @var PhysicalSensorTransformer
     */
    protected $physicalSensorTransformer;


    /**
     * PhysicalSensorController constructor.
     * @param PhysicalSensorTransformer $_physicalSensorTransformer
     */
    public function __construct(PhysicalSensorTransformer $_physicalSensorTransformer)
    {
        parent::__construct();
        $this->physicalSensorTransformer = $_physicalSensorTransformer;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (Gate::denies('api-list')) {
            return $this->respondUnauthorized();
        }

        $physical_sensors = PhysicalSensor::with('logical_sensors');

        $physical_sensors = $this->filter($request, $physical_sensors)->get();

        return $this->setStatusCode(200)->respondWithData(
            $this->physicalSensorTransformer->transformCollection(
                $physical_sensors->toArray()
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

        $physical_sensor = PhysicalSensor::with('logical_sensors')->find($id);

        if (!$physical_sensor) {
            return $this->respondNotFound('PhysicalSensor not found');
        }

        return $this->setStatusCode(200)->respondWithData(
            $this->physicalSensorTransformer->transform(
                $physical_sensor->toArray()
            )
        );
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {

        if (Gate::denies('api-write:physical_sensor')) {
            return $this->respondUnauthorized();
        }

        $physical_sensor = PhysicalSensor::find($id);
        if (is_null($physical_sensor)) {
            return $this->respondNotFound('PhysicalSensor not found');
        }

        $logical_sensors = LogicalSensor::where('physical_sensor_id', $physical_sensor->id)->get();
        foreach ($logical_sensors as $ls) {
            $ls->physical_sensor_id = null;
            $ls->save();
        }

        $physical_sensor->delete();

        return $this->setStatusCode(200)->respondWithData([], [
            'redirect' => [
                'uri'   => url('physical_sensors'),
                'delay' => 2000
            ]
        ]);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        if (Gate::denies('api-write:physical_sensor')) {
            return $this->respondUnauthorized();
        }

        $physical_sensor = PhysicalSensor::create();
        $physical_sensor->name = $request->input('name');
        $physical_sensor->save();

        return $this->setStatusCode(200)->respondWithData(
            [
                'id'    =>  $physical_sensor->id
            ],
            [
                'redirect' => [
                    'uri'   => url('physical_sensors/' . $physical_sensor->id . '/edit'),
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

        if (Gate::denies('api-write:physical_sensor')) {
            return $this->respondUnauthorized();
        }

        $physical_sensor = PhysicalSensor::find($request->input('id'));
        if (is_null($physical_sensor)) {
            return $this->respondNotFound('PhysicalSensor not found');
        }

        if ($request->has('controlunit') && strlen($request->input('controlunit')) > 0) {
            $controlunit = Controlunit::find($request->input('controlunit'));
            if (is_null($controlunit)) {
                return $this->setStatusCode(422)->respondWithError('Controlunit not found');
            }
            $controlunit_id = $controlunit->id;
        }
        else {
            $controlunit_id = null;
        }

        $physical_sensor->name = $request->input('name');
        $physical_sensor->model = $request->input('model');
        $physical_sensor->belongsTo_type = 'terrarium';
        $physical_sensor->belongsTo_id = $request->input('terrarium');
        $physical_sensor->controlunit_id = $controlunit_id;
        $physical_sensor = $this->addBelongsTo($request, $physical_sensor);

        $physical_sensor->save();

        return $this->setStatusCode(200)->respondWithData([], [
            'redirect' => [
                'uri'   => url('physical_sensors'),
                'delay' => 1000
            ]
        ]);

    }

}
