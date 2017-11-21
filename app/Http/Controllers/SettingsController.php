<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use IGW\IsolProductList;

class SettingsController extends Controller {

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
     * Show the settings and modify options
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $this->breadcrumbs('Settings');

        return view('modules.settings.index')
            ->with('openingHours',          Settings::getContent('opening-hours'))
            ->with('footer',                Settings::getContent('footer'))
            ->with('emergencyNumber',       Settings::getContent('emergency-number'));

    }

    public function getProductListStoreName() {

        return md5('isol-product-list-csv');

    }

    public function storeProductList($request) {

        if( $request->hasFile('plist') ) {

            $ipl = new IsolProductList();

            $list = $request->file('plist');
            $list->storeAs($ipl->getDirectory(), $ipl->getStoreName());

            $ipl->storeLines();

        }

    }

    /**
    *   Save the settings to the database
    */
    public function save(Request $request) {

        $oh                     = $request->get('opening-hours');
        $footer                 = $request->get('footer');
        $emergencyNumber        = $request->get('emergency-number');

        $this->storeProductList($request);

        Settings::updateContent('opening-hours', $oh);
        Settings::updateContent('footer', $footer);
        Settings::updateContent('emergency-number', $emergencyNumber);

        return redirect()->route('settings')->with('success', 'Settings have been saved.');

    }
}
