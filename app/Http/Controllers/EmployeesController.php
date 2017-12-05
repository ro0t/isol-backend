<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Employee;

class EmployeesController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->middleware('auth');

    }

    public function index() {

        $this->breadcrumbs('Employees');

        $employees = Employee::where('active', 1)->orderBy('id', 'ASC')->get();

        return view('modules.employees.list')
            ->with('data', $employees);

    }

    public function create() {

        $this->breadcrumbs('Employees', 'Add');

        return view('modules.employees.form')
            ->with('data', null);

    }

    public function edit($id) {

        $employee = Employee::find($id);

        if(!$employee) \App::abort(404);

        $this->breadcrumbs('Employees', $employee->name, 'Edit');

        return view('modules.employees.form')
            ->with('data', $employee);

    }

    public function createNew(Request $request) {

        $name = $request->get('name');
        $email = $request->get('email');
        $phone = $request->get('phone');

        if( $request->hasFile('image') ) {

            $ext = $request->image->extension();
            $ext = ($ext == 'jpeg') ? 'jpg' : $ext;
            $fileName = str_slug($name) . '-' . mt_rand() . '.' . $ext;

            $request->image->storeAs('article-images', $fileName);
            $image = '/article-images/' . $fileName;

        }

        $employee = Employee::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'image' => (isset($image)) ? $image : null,
            'active' => 1
        ]);

        if( $employee ) {
            return redirect()->route('employees')->with('success', 'Succesfully created ' . $employee->name);
        }

        return redirect()->route('employees.new')->withInpt()->with('error', 'Something went wrong with creating this employee, please try again.');

    }

    public function change(Request $request, $id) {

        $employee = Employee::find($id);

        if(!$employee) \App::abort(404);

        $employee->name = $request->get('name');
        $employee->email = $request->get('email');
        $employee->phone = $request->get('phone');

        if( $request->hasFile('image') ) {

            $ext = $request->image->extension();
            $ext = ($ext == 'jpeg') ? 'jpg' : $ext;
            $fileName = str_slug($employee->name) . '-' . mt_rand() . '.' . $ext;

            $request->image->storeAs('article-images', $fileName);
            $employee->image = '/article-images/' . $fileName;

        }

        if( $employee->save() ) {
            return redirect()->route('employees')->with('success', 'Succesfully changed ' . $employee->name);
        }

        return redirect()->route('employees.edit', $id)->withInpt()->with('error', 'Something went wrong with editing this employee, please try again.');

    }

    public function delete($id) {

        $employee = Employee::find($id);

        if(!$employee) \App::abort(404);

        $employee->active = 0;

        if( $employee->save() ) {
            return redirect()->route('employees')->with('success', 'Successfully removed ' . $employee->name);
        }

        return redirect()->route('employees')->with('error', 'Couldn\'t remove ' . $employee->name . ' please try again.');

    }

}
