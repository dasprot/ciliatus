<?php

namespace App\Http\Controllers\Api;

use App\Events\ReadFlagSet;
use App\Property;
use Gate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;


/**
 * Class PropertyController
 * @package App\Http\Controllers
 */
class PropertyController extends ApiController
{

    /**
     * PropertyController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->errorCodeNamespace = '27';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return parent::default_index($request);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        return parent::default_show($request, $id);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        if (Gate::denies('api-write:property')) {
            return $this->respondUnauthorized();
        }

        /**
         * @var Property $property
         */
        $property = Property::find($id);
        if (is_null($property)) {
            return $this->respondNotFound();
        }

        $property->delete();

        return $this->respondWithData([]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (Gate::denies('api-write:property')) {
            return $this->respondUnauthorized();
        }

        $required_fields = ['belongsTo_type', 'belongsTo_id', 'type', 'name'];
        if (!$this->checkInput($required_fields, $request)) {
            return $this->setStatusCode(422)
                        ->setErrorCode('104')
                        ->respondWithErrorDefaultMessage([
                            'missing_fields' => implode(',', $required_fields)
                        ]);
        }

        $belongsTo_type = $request->input('belongsTo_type');
        $belongsTo_id = $request->input('belongsTo_id');

        $class_name = "App\\$belongsTo_type";
        if (!class_exists($class_name)) {
            return $this->setStatusCode(422)
                        ->setErrorCode('105')
                        ->respondWithErrorDefaultMessage();
        }

        $belongs_to = $class_name::find($belongsTo_id);
        if (is_null($belongs_to)) {
            return $this->respondRelatedModelNotFound($class_name);
        }

        /**
         * @var Property $property
         */
        $p = Property::create([
            'belongsTo_type' => $belongsTo_type,
            'belongsTo_id' => $belongs_to->id,
            'type' => $request->input('type'),
            'name' => $request->input('name'),
            'value' => $request->input('value') ? $request->input('value') : null
        ]);

        $p->save();

        if ($request->filled('update_belongs_to')) {
            $belongs_to->save();
        }

        return $this->respondWithData([
            'id' => $p->id
        ]);

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        if (Gate::denies('api-write:property')) {
            return $this->respondUnauthorized();
        }

        $property = Property::find($id);
        if (is_null($property)) {
            return $this->respondNotFound('Property not found');
        }

        if ($request->filled('belongsTo_type') && $request->filled('belongsTo_id')) {
            $belongsTo_type = $request->input('belongsTo_type');
            $belongsTo_id = $request->input('belongsTo_id');

            $class_name = "App\\$belongsTo_type";
            if (!class_exists($class_name)) {
                return $this->setStatusCode(422)
                            ->setErrorCode('105')
                            ->respondWithErrorDefaultMessage();
            }

            $belongs_to = $class_name::find($belongsTo_id);
            if (is_null($belongs_to)) {
                return $this->respondRelatedModelNotFound($class_name);
            }

            $property->belongsTo_type = $belongsTo_type;
            $property->belongsTo_id = $belongs_to->id;
        }

        $this->updateModelProperties($property, $request, [
            'name', 'value', 'type'
        ]);
        $property->save();

        return $this->setStatusCode(200)->respondWithData([]);

    }

    /**
     * @param $target_type
     * @param $target_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function setReadFlag($target_type, $target_id)
    {
        if (Gate::denies('api-write:property')) {
            return $this->respondUnauthorized();
        }

        try {
            $target = ('App\\' . $target_type)::find($target_id);
        }
        catch (ModelNotFoundException $ex) {
            return $this->respondNotFound();
        }

        Property::create([
            'belongsTo_type' => $target_type,
            'belongsTo_id' => $target_id,
            'type' => 'ReadFlag'
        ]);

        broadcast(new ReadFlagSet($target_type, $target_id));

        return $this->respondWithData([]);

    }

}
