<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\News;

class NewsController extends Controller {

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

        $this->breadcrumbs('News');

        $news = News::where('active', 1)->orderBy('id', 'desc')->get();

        return view('modules.news.list')
            ->with('news', $news);
    }

    public function create() {

        $this->breadcrumbs('News', 'Write');

        return view('modules.news.form')
            ->with('data', null);

    }

    public function edit($id) {

        $post = News::find($id);

        if(!$post) \App::abort(404);

        $this->breadcrumbs('News', $post->title, 'Edit');

        return view('modules.news.form')
            ->with('data', $post);

    }

    private function validator($request) {

        return $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

    }

    public function createNew(Request $request) {

        $this->validator($request);

        $image = null;

        if( $request->hasFile('image') ) {

            $extension = $request->image->extension();
            $fileName = md5($request->image->path()) . '.' . (($extension == 'jpeg' || $extension == 'jpg') ? 'jpg' : 'png');
            $request->image->storeAs('article-images', $fileName);
            $image = '/article-images/' . $fileName;

        }

        $post = News::create([
            'title' => $request->get('title'),
            'slug' => str_slug($request->get('title')) . '-' . date('Y-m-d'),
            'image' => $image == null ? '' : $image,
            'content' => $request->get('content'),
            'written_by' => \Auth::user()->id
        ]);

        if( $post ) {
            return redirect()->to('news')->with('success', 'News post was created successfully!');
        }

        return redirect()->back()->withInput()->with('error', 'Could not create news, please try again.');

    }

    public function change(Request $request, $id) {

        $this->validator($request);
        $post = News::find($id);

        if(!$post) return redirect()->route('news')->with('error', 'Could not edit news with id ' . $id);

        if( $request->hasFile('image') ) {

            $extension = $request->image->extension();
            $fileName = md5($request->image->path()) . '.' . (($extension == 'jpeg' || $extension == 'jpg') ? 'jpg' : 'png');
            $request->image->storeAs('article-images', $fileName);
            $post->image = '/article-images/' . $fileName;

        }

        $post->title = $request->get('title');
        $post->slug = str_slug($post->title) . '-' . date('Y-m-d');
        $post->content = $request->get('content');

        if( $post->save() ) {
            return redirect()->route('news')->with('success', 'Successfully edited news post.');
        }

        return redirect()->back()->withInput()->with('error', 'Could not edit news, please try again.');

    }


}
