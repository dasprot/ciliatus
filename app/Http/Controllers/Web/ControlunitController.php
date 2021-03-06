<?php

namespace App\Http\Controllers\Web;

use App\Controlunit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class ControlunitController
 * @package App\Http\Controllers\Web
 */
class ControlunitController extends Controller
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
        return view('controlunits.index', [
            'controlunits' => Controlunit::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('controlunits.create', [
            'preset' => $request->input('preset')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cu = Controlunit::find($id);
        if (is_null($cu)) {
            return response()->view('errors.404', [], 404);
        }

        return view('controlunits.show', [
            'controlunit' => $cu
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $controlunit = Controlunit::find($id);

        if (is_null($controlunit)) {
            return response()->view('errors.404', [], 404);
        }

        return view('controlunits.edit', [
            'controlunit'     => $controlunit
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param string $id
     * @return void
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
        $controlunit = Controlunit::find($id);

        if (is_null($controlunit)) {
            return response()->view('errors.404', [], 404);
        }

        return view('controlunits.delete', [
            'controlunit'     => $controlunit
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
