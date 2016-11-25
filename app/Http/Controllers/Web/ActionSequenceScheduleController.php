<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\ActionSequenceSchedule;
use Illuminate\Http\Request;

use App\Http\Requests;

/**
 * Class ActionSequenceScheduleController
 * @package App\Http\Controllers\Web
 */
class ActionSequenceScheduleController extends Controller
{

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('action_sequence_schedules.index', [
            'action_sequence_schedules' => ActionSequenceSchedule::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sequences = ActionSequence::all();

        return view('action_sequence_schedules.create', [
            'sequences'        => $sequences
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $action_sequence_schedule = ActionSequenceSchedule::find($id);
        if (is_null($action_sequence_schedule)) {
            return view('errors.404');
        }

        return view('action_sequence_schedules.show', [
            'action_sequence_schedule' => $action_sequence_schedule
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $action_sequence_schedule = ActionSequenceSchedule::find($id);

        if (is_null($action_sequence_schedule)) {
            return view('errors.404');
        }

        return view('action_sequence_schedules.edit', [
            'action_sequence_schedule'     => $action_sequence_schedule
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $action_sequence_schedule = ActionSequenceSchedule::find($id);

        if (is_null($action_sequence_schedule)) {
            return view('errors.404');
        }

        return view('action_sequence_schedules.delete', [
            'action_sequence_schedule'     => $action_sequence_schedule
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}