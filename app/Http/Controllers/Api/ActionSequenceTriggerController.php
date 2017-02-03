<?php

namespace App\Http\Controllers\Api;

use App\Action;
use App\ActionSequence;
use App\ActionSequenceTrigger;
use App\Http\Transformers\ActionSequenceTriggerTransformer;
use App\LogicalSensor;
use App\Repositories\ActionSequenceTriggerRepository;
use App\Terrarium;
use Carbon\Carbon;
use DB;
use Gate;
use Illuminate\Http\Request;

use App\Http\Requests;

/**
 * Clast ActionSequenceTriggerController
 * @package App\Http\Controllers
 */
class ActionSequenceTriggerController extends ApiController
{
    /**
     * @var ActionSequenceTriggerTransformer
     */
    protected $actionSequenceTriggerTransformer;

    /**
     * ActionSequenceTriggerController constructor.
     * @param ActionSequenceTriggerTransformer $_actionSequenceTriggerTransformer
     */
    public function __construct(ActionSequenceTriggerTransformer $_actionSequenceTriggerTransformer)
    {
        parent::__construct();
        $this->actionSequenceTriggerTransformer = $_actionSequenceTriggerTransformer;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (Gate::denies('api-list')) {
            return $this->respondUnauthorized();
        }


        $action_sequence_triggers = ActionSequenceTrigger::with('sequence');

        $action_sequence_triggers = $this->filter($request, $action_sequence_triggers);


        /*
         * If raw is pasted, pagination will be ignored
         * Permission api-list:raw is required
         */
        if ($request->has('raw') && Gate::allows('api-list:raw')) {
            $action_sequence_triggers = $action_sequence_triggers->get();
            foreach ($action_sequence_triggers as &$t) {
                $t = (new ActionSequenceTriggerRepository($t))->show();
            }

            return $this->setStatusCode(200)->respondWithData(
                $this->actionSequenceTriggerTransformer->transformCollection(
                    $action_sequence_triggers->toArray()
                )
            );

        }

        $action_sequence_triggers = $action_sequence_triggers->paginate(env('PAGINATION_PER_PAGE', 20));

        foreach ($action_sequence_triggers->items() as &$t) {
            $t = (new ActionSequenceTriggerRepository($t))->show();
        }

        return $this->setStatusCode(200)->respondWithPagination(
            $this->actionSequenceTriggerTransformer->transformCollection(
                $action_sequence_triggers->toArray()['data']
            ),
            $action_sequence_triggers
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

        $action = ActionSequenceTrigger::with('sequence')
                                        ->find($id);

        if (!$action) {
            return $this->respondNotFound('ActionSequenceTrigger not found');
        }

        return $this->setStatusCode(200)->respondWithData(
            $this->actionSequenceTriggerTransformer->transform(
                $action->toArray()
            )
        );
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {

        if (Gate::denies('api-write:action_sequence_trigger')) {
            return $this->respondUnauthorized();
        }

        $ast = ActionSequenceTrigger::find($id);
        if (is_null($ast)) {
            return $this->setStatusCode(422)->respondWithError('ActionSequenceTrigger not found');
        }

        $asid = $ast->sequence->id;

        $ast->delete();

        return $this->setStatusCode(200)->respondWithData([], [
            'redirect' => [
                'uri'   => url('action_sequences/' . $asid . '/edit'),
                'delay' => 1000
            ]
        ]);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        if (Gate::denies('api-write:action_sequence_trigger')) {
            return $this->respondUnauthorized();
        }

        $a = ActionSequence::find($request->input('action_sequence'));
        if (is_null($a)) {
            return $this->setStatusCode(422)->respondWithError('ActionSequence not found');
        }

        $ls = LogicalSensor::find($request->input('logical_sensor'));
        if (is_null($ls)) {
            return $this->setStatusCode(422)->respondWithError('LogicalSensor not found');
        }

        if (!in_array($request->input('reference_value_comparison_type'), ['equal', 'lesser', 'greater'])) {
            return $this->setStatusCode(422)->respondWithError('Unknown reference value comparison type');
        }

        $ast = ActionSequenceTrigger::create([
            'name' => 'AST_' . $a->name . '_' . Carbon::parse($request->input('starts_at'))->format('H:i:s'),
            'logical_sensor_id' => $ls->id,
            'reference_value' => $request->input('reference_value'),
            'reference_value_comparison_type' => $request->input('reference_value_comparison_type'),
            'reference_value_duration_threshold_minutes' => $request->input('reference_value_duration_threshold_minutes'),
            'minimum_timeout_minutes' => $request->input('minimum_timeout_minutes'),
            'timeframe_start' => Carbon::parse($request->input('timeframe_start'))->format('H:i:s'),
            'timeframe_end' => Carbon::parse($request->input('timeframe_end'))->format('H:i:s'),
            'action_sequence_id' => $request->input('action_sequence')
        ]);

        return $this->setStatusCode(200)->respondWithData(
            [
                'id'    =>  $ast->id
            ],
            [
                'redirect' => [
                    'uri'   => url('action_sequences/' . $ast->sequence->id . '/edit'),
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

        if (Gate::denies('api-write:action_sequence_trigger')) {
            return $this->respondUnauthorized();
        }

        $trigger = ActionSequenceTrigger::find($id);
        if (is_null($trigger)) {
            return $this->setStatusCode(404)->respondWithError('ActionSequenceTrigger not found');
        }

        if ($request->has('action_sequence_id')) {
            $a = ActionSequence::find($request->input('action_sequence_id'));
            if (is_null($a)) {
                return $this->setStatusCode(422)->respondWithError('ActionSequence not found');
            }
        }

        if ($request->has('name')) {
            $trigger->name = $request->input('name');
        }

        if ($request->has('action_sequence')) {
            $trigger->action_sequence_id = $request->input('action_sequence');
        }


        if ($request->has('logical_sensor')) {
            $ls = LogicalSensor::find($request->input('logical_sensor'));
            if (is_null($ls)) {
                return $this->setStatusCode(422)->respondWithError('LogicalSensor not found');
            }
            $trigger->logical_sensor_id = $ls->id;
        }

        if ($request->has('reference_value_comparison_type')) {
            if (!in_array($request->input('reference_value_comparison_type'), ['equal', 'lesser', 'greater'])) {
                return $this->setStatusCode(422)->respondWithError('Unknown reference value comparison type');
            }
            $trigger->reference_value_comparison_type = $request->input('reference_value_comparison_type');
        }

        if ($request->has('reference_value')) {
            $trigger->reference_value = $request->input('reference_value');
        }

        if ($request->has('minimum_timeout_minutes')) {
            $trigger->minimum_timeout_minutes = $request->input('minimum_timeout_minutes');
        }

        if ($request->has('reference_value_duration_threshold_minutes')) {
            $trigger->reference_value_duration_threshold_minutes = $request->input('reference_value_duration_threshold_minutes');
        }

        if ($request->has('timeframe_start')) {
            $trigger->timeframe_start = Carbon::parse($request->input('timeframe_start'))->format('H:i:s');
        }

        if ($request->has('timeframe_end')) {
            $trigger->timeframe_end = Carbon::parse($request->input('timeframe_end'))->format('H:i:s');
        }

        $trigger->save();

        return $this->setStatusCode(200)->respondWithData([], [
            'redirect' => [
                'uri'   => url('action_sequences/' . $trigger->sequence->id . '/edit'),
                'delay' => 100
            ]
        ]);

    }
}