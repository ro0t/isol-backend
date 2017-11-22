<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->middleware('auth');
        $this->middleware('auth.super');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->breadcrumbs('Users');

        $users = \App\User::orderBy('name', 'ASC')->where('active', 1)->get();

        return view('modules.users.list')
            ->with('users', $users);
    }

    public function create() {

        $this->breadcrumbs('Users', 'Create');

        return view('modules.users.form')
            ->with('data', null);

    }

    public function edit($id) {

        $user = User::find($id);

        if(!$user) \App::abort(404);

        return view('modules.users.form')
            ->with('data', $user);

    }

    public function delete($id) {

        $user = User::find($id);

        if(!$user) \App::abort(404);

        $user->active = 0;

        if( $user->save() ) {
            return redirect()->route('users')->with('success', $user->name . ' was successfully deleted.');
        }

        return redirect()->route('users')->with('error', 'Could not delete this user.');

    }

    public function validator($request, $isEditing = false, $email = false) {

        $passwordValidation = 'required|string|min:6';
        $emailValidation = 'required|string|email|max:255|unique:users';

        if( $isEditing ) {

            if( empty($request->get('password')) ) {

                $passwordValidation = '';

            }

            if( $email ) {
                $emailValidation = 'required|string|email|max:255';
            }

        }

        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => $emailValidation,
            'password' => $passwordValidation,
        ]);

    }

    public function createNew(Request $request) {

        $validator = $this->validator($request);

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'super_admin' => $request->get('level')
        ]);

        if( $user ) {
            return redirect()->route('users')->with('success', $user->name . ' has been created.');
        }

        return redirect()->route('users')->with('error', 'Sorry something went wrong, please try again.');

    }

    public function change(Request $request, $id) {

        $user = User::find($id);

        if(!empty($request->get('password'))) {
            $user->password = bcrypt($request->get('password'));
        }

        // Check if the mail has changed.
        $newMail = $request->get('email');
        if( $newMail != $user->email ) {
            $user->email = $request->get('email');
        }

        $user->name = $request->get('name');
        $user->super_admin = $request->get('level');

        $validator = $this->validator($request, true, ($newMail == $user->email));

        if($user->save()) {
            return redirect()->route('users')->with('success', $user->name . ' was successfully edited.');
        }

        return redirect()->route('users.edit', $user->id)->withInput()->with('error', 'Could not save this user.');

    }


}
