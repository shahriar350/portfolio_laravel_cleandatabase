<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogCategorySet;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.components.blog');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $blog = Blog::with('get_category','get_category.get_name')->latest()->paginate(10);
        return response()->json(['data' => $blog]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'blog' => 'required',
            'blog.title' => 'required',
            'blog.blog' => 'required',
            'blog.categories' => 'required',
        ]);
        if (isset($request->blog['id'])) {
            $blog = Blog::findOrFail($request->blog['id']);
            $blog->title = $request->blog['title'];
            $blog->blog = $request->blog['blog'];
            $blog->save();
            foreach($blog->get_category as $category) {
                $category->delete();
            }
        } else {
            $blog = Blog::create([
                'title' => $request->blog['title'],
                'blog' => $request->blog['blog'],
            ]);
        }
        foreach ($request->blog['categories'] as $category){
            BlogCategorySet::create([
                'category' => $category['id'],
                'blog' => $blog->id,
            ]);
        }
        return response()->json(['data' => Blog::with('get_category.get_name')->findOrFail($blog->id)]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Blog::onlyTrashed()->findOrFail($id)->forceDelete()){
            return response('',200);
        }
    }
    function blog_deactivate($id) {
        if(Blog::findOrFail($id)->delete()){
            return response()->json(['data' => Blog::onlyTrashed()->with('get_category.get_name')->findOrFail($id)]);
        }
    }
    function blog_activate($id) {
        if(Blog::onlyTrashed()->findOrFail($id)->restore()){
            return response()->json(['data' => Blog::with('get_category.get_name')->findOrFail($id)]);
        }
    }
    function blog_cat_create(Request $request) {
        $request->validate([
            'blog_cat_name' => 'required'
        ]);
        $data = BlogCategory::create([
            'name' =>  $request->blog_cat_name,
        ]);
        return response()->json(['data' => $data]);
    }
    function blog_cat() {
        $data = BlogCategory::latest()->get();
        $trashes = BlogCategory::onlyTrashed()->latest()->get();
        return response()->json(['data' => $data,'trashes' => $trashes],200);
    }
    function blog_cat_delete($id) {
        if (BlogCategory::findOrFail($id)->delete()) {
            $all_blog_related_cat = BlogCategorySet::where('category',$id)->get();
            foreach ($all_blog_related_cat as $item){
                $item->delete();
            }
            $data = BlogCategory::onlyTrashed()->findOrFail($id);

            return response()->json(['data' => $data]);
        };

    }
    function blog_cat_force_delete($id) {
        $data = BlogCategory::onlyTrashed()->findOrFail($id)->forceDelete();
        $all_blog_related_cat = BlogCategorySet::where('category',$id)->get();
        foreach ($all_blog_related_cat as $item){
            $item->forceDelete();
        }
        return response('',200);
    }
    function blog_cat_recover($id){
        BlogCategory::onlyTrashed()->findOrFail($id)->restore();
        $all_blog_related_cat = BlogCategorySet::onlyTrashed()->where('category',$id)->get();
        foreach ($all_blog_related_cat as $item){
            $item->restore();
        }
        $data = BlogCategory::findOrFail($id);
        return response()->json(['data' => $data]);
    }
    function all_deleted_items(){
        $data = Blog::onlyTrashed()->with('get_category.get_name')->latest()->get();
        return response()->json(['data' => $data]);
    }
}
