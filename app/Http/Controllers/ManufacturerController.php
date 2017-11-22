<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manufacturer;

class ManufacturerController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->breadcrumbs('Manufacturers');

        $data = Manufacturer::getList();

        return view('modules.manufacturers.list')
            ->with('data', $data);
    }

    public function create() {

        $this->breadcrumbs('Manufacturers', 'Create');

        return view('modules.manufacturers.form')
            ->with('data', null);

    }

    public function edit($id) {

        $mf = Manufacturer::find($id);

        if($mf != null) {

            $this->breadcrumbs('Manufacturers', $mf->name);

            return view('modules.manufacturers.form')
                ->with('data', $mf);

        }

        \App::abort(404);

    }

    public function change(Request $request, $id) {

        $mf = Manufacturer::find($id);

        if($mf != null) {

            if( $request->hasFile('image') ) {

                $ext = $request->image->extension();
                $ext = ($ext == 'jpeg') ? 'jpg' : $ext;
                $fileName = md5($request->image->path() . time() . mt_rand()) . '.' . $ext;

                $request->image->storeAs('mf-images', $fileName);
                $mf->image = '/mf-images/' . $fileName;

            }

            $mf->name = $request->get('name');
            $mf->slug = str_slug($request->get('name'));
            $mf->website = $request->get('website');
            $mf->save();

            return redirect()->route('manufacturers')->with('success', 'Manufacturer ' . $mf->name . ' has been saved!');

        }

        \App::abort(500);

    }

    public function createNew(Request $request) {

        if( !$request->has('name') || empty($request->get('name')) ) {
            return redirect()->route('manufacturers.new')->withInput()->with('error', 'You have to enter a name for this manufacturer.');
        }

        if( !$request->has('website') || empty($request->get('website')) ) {
            return redirect()->route('manufacturers.new')->with('error', 'You have to enter a website for this manufacturer.');
        }

        $image = null;

        if( $request->hasFile('image') ) {

            $ext = $request->image->extension();
            $ext = ($ext == 'jpeg') ? 'jpg' : $ext;
            $fileName = md5($request->image->path() . time() . mt_rand()) . '.' . $ext;

            $request->image->storeAs('mf-images', $fileName);
            $image = '/mf-images/' . $fileName;

        }

        $mf = Manufacturer::create([
            'name' => $request->get('name'),
            'slug' => str_slug($request->get('name')),
            'website' => $request->get('website'),
            'image' => $image
        ]);

        if( $mf ) {
            return redirect()->route('manufacturers')->with('success', 'New manufacturer has been created.');
        }

        return redirect()->route('manufacturers.new')->withInput()->with('error', 'Something went wrong with creating a new manufacturer, please try again.');


    }

    public function setActive(Request $request, $id) {

        $manufacturer = Manufacturer::find($id);

        if($manufacturer != null) {

            $manufacturer->active = $request->get('checked');
            $manufacturer->save();

            return $this->success('Manufacturer updated successfully');

        }

        return $this->error('Could not find manufacturer with id ' . $id);

    }

}
