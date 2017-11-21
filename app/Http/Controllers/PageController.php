<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PageContent;
use App\Models\PageSEO;

class PageController extends Controller {

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

        $this->breadcrumbs('Pages');

        $pages = Page::all();

        return view('modules.pages.list')
            ->with('data', $pages);
    }

    /**
    *   Load the SEO page options for this page
    *
    * @return \Illuminate\Http\Response
    */
    public function seo($id) {

        $page = Page::find($id);

        if($page == null) { return \App::abort(404); }

        $this->breadcrumbs('Pages', $page->name, 'SEO');
        $seo = PageSEO::getContent($page->id);

        return view('modules.pages.seo')
            ->with('page', $page)
            ->with('seo', $seo);

    }

    public function edit($id) {

        $page = Page::find($id);

        if($page == null) { return \App::abort(404); }

        $pageContent = PageContent::getContent($page->id);

        $this->breadcrumbs('Pages', $page->name, 'Edit');

        return view('modules.pages.form')
            ->with('page', $page)
            ->with('pageContent', $pageContent);

    }

    public function change(Request $request, $id) {

        $page = Page::find($id);

        if($page == null) { return \App::abort(404); }

        $pageContent = PageContent::where('page_id', $page->id)->firstOrCreate(['page_id' => $page->id], ['content' => '']);

        $pageContent->content = $request->get('content');

        if( $pageContent->save() ) {
            return redirect()->route('home')->with('success', 'Page ' . $page->name . ' has been updated');
        }

        return redirect()->route('page.edit')->with('error', 'Couldn\'t update page ' . $page->name . ' please try again.');

    }

    public function changeSeo(Request $request, $id) {

        $page = Page::find($id);

        if($page == null) { return \App::abort(404); }

        $ps = PageSEO::getContent($page->id);

        $ps->keywords           = $request->get('keywords');
        $ps->og_title           = $request->get('og_title');
        $ps->og_description     = $request->get('og_description');
        $ps->og_type            = $request->get('og_type');

        if($ps->save()) {
            return redirect()->route('home')->with('success', 'Page SEO for ' . $page->name . ' has been saved');
        } else {
            return redirect()->route('page.seo', $page->id)->withInput()->with('error', 'Something went wrong when saving SEO, please try again.');
        }

    }

}
