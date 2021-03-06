<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Token;
use App\User;
use Auth;
use Gate;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers\Web
 */
class UserController extends Controller
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
        if (Gate::denies('admin')) {
            return response()->view('errors.401', [], 401);
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
        $user = User::find($id);
        if (is_null($user)) {
            return response()->view('errors.404', [], 404);
        }

        return view('users.show', [
            'user' => $user
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
        $user = User::find($id);

        if (is_null($user)) {
            return response()->view('errors.404', [], 404);
        }

        /*
         * Make sure non-admin users can only edit themselves
         */
        if (Gate::denies('admin') && $user->id != Auth::user()->id) {
            return response()->view('errors.401', [], 401);
        }


        return view('users.edit', [
            'user'     => $user
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->view('errors.404', [], 404);
        }

        /*
         * Make sure non-admin users can only edit themselves
         */
        if (Gate::denies('admin') && $user->id != Auth::user()->id) {
            return response()->view('errors.401', [], 401);
        }

        return view('users.delete', [
            'user'     => $user
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setup_Telegram()
    {
        $user = Auth::user();

        $user->deleteSetting('notifications_telegram_chat_id');
        $user->setSetting('notifications_telegram_verification_code', Token::generate(6));

        return view('users.setup_telegram', [
            'user'  =>  $user,
            'token' =>  $user->setting('notifications_telegram_verification_code')
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create_personal_accesss_token(Request $request, $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->view('errors.404', [], 404);
        }

        /*
         * Make sure non-admin users can only edit themselves
         */
        if (Gate::denies('admin') && $user->id != Auth::user()->id) {
            return response()->view('errors.401', [], 401);
        }


        return view('users.personal_access_tokens.create', [
            'user'     => $user
        ]);
    }
}
