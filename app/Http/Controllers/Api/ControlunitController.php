<?php

namespace App\Http\Controllers\Api;

use App\Controlunit;
use App\Http\Transformers\ControlunitTransformer;
use Gate;
use Illuminate\Http\Request;

/**
 * Class ControlunitController
 * @package App\Http\Controllers
 */
class ControlunitController extends ApiController
{
    /**
     * @var ControlunitTransformer
     */
    protected $controlunitTransformer;

    /**
     * ControlunitController constructor.
     * @param ControlunitTransformer $_controlunitTransformer
     */
    public function __construct(ControlunitTransformer $_controlunitTransformer)
    {
        parent::__construct();
        $this->controlunitTransformer = $_controlunitTransformer;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (Gate::denies('api-list')) {
            return $this->respondUnauthorized();
        }

        $controlunits = Controlunit::query();
        $controlunits = $this->filter($request, $controlunits);

        return $this->respondTransformedAndPaginated(
            $request,
            $controlunits,
            $this->controlunitTransformer
        );
        
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {

        if (Gate::denies('api-read')) {
            return $this->respondUnauthorized();
        }

        $cu = Controlunit::query();
        $cu = $this->filter($request, $cu);
        $cu = $cu->find($id);

        if (!$cu) {
            return $this->respondNotFound('Controlunit not found');
        }

        return $this->setStatusCode(200)->respondWithData(
            $this->controlunitTransformer->transform(
                $cu->toArray()
            )
        );
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {

        if (Gate::denies('api-write:controlunit')) {
            return $this->respondUnauthorized();
        }

        $controlunit = Controlunit::find($id);
        if (is_null($controlunit)) {
            return $this->setStatusCode(422)->respondWithError('Controlunit not found');
        }

        $controlunit->delete();

        return $this->setStatusCode(200)->respondWithData([], [
            'redirect' => [
                'uri'   => url('controlunits'),
                'delay' => 2000
            ]
        ]);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        if (Gate::denies('api-write:controlunit')) {
            return $this->respondUnauthorized();
        }

        $controlunit = Controlunit::create([
            'name' => $request->input('name')
        ]);

        return $this->setStatusCode(200)->respondWithData(
            [
                'id'    =>  $controlunit->id
            ],
            [
                'redirect' => [
                    'uri'   => url('controlunits/' . $controlunit->id . '/edit'),
                    'delay' => 100
                ]
            ]
        );

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        if (Gate::denies('api-write:controlunit')) {
            return $this->respondUnauthorized();
        }

        $controlunit = Controlunit::find($id);
        if (is_null($controlunit)) {
            return $this->setStatusCode(422)->respondWithError('Controlunit not found');
        }

        $this->updateModelProperties($controlunit, $request, [
            'name'
        ]);

        $this->updateExternalProperties($controlunit, $request, [
            'ControlunitConnectivity' => [
                'i2c_bus_num'
            ]
        ]);

        $controlunit->save();

        return $this->setStatusCode(200)->respondWithData([], [
            'redirect' => [
                'uri'   => url('controlunits'),
                'delay' => 1000
            ]
        ]);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchDesiredStates($id)
    {
        if (Gate::denies('api-fetch:desired_states')) {
            return $this->respondUnauthorized();
        }

        $controlunit = Controlunit::find($id);
        if (is_null($controlunit)) {
            return $this->setStatusCode(422)->respondWithError('Controlunit not found');
        }

        return $this->respondWithData($controlunit->fetchAndAckDesiredStates());
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function check_in(Request $request, $id)
    {
        if (Gate::denies('api-write:controlunit')) {
            return $this->respondUnauthorized();
        }

        $controlunit = Controlunit::find($id);
        if (is_null($controlunit)) {
            return $this->setStatusCode(422)->respondWithError('Controlunit not found');
        }

        if ($request->has('software_version')) {
            $controlunit->software_version = $request->input('software_version');
        }

        $controlunit->save();

        return $this->respondWithData([]);
    }

}
