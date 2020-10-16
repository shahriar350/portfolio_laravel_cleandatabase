<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\BlogCategorySet;
use App\Models\CvTitle;
use App\Models\User;
use App\Models\UserContact;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    function index(){
        $user = collect(User::first())->except(['id','created_at','updated_at']);
        $contacts = UserContact::select('icon','text','contact')->get();
        return view('frontend.index',compact(['user','contacts']));
    }
    function all_banner() {
        $banners = Banner::select('image','caption','text')->where('active',1)->get();
        return response()->json(['data' => $banners]);
    }
    function all_cvInfo() {
        $cvs = CvTitle::with('get_header','get_header.get_body')->get();
        return response()->json(['data' => $cvs]);
    }
    function blog(){
        $blogs = Blog::with('get_category.get_name')->paginate(10);
        return view('frontend.blog',compact('blogs'));
    }
    function blog_single($id){
        $blog = Blog::with('get_category.get_name')->findOrFail($id);
        return view('frontend.singleblog',compact('blog'));
    }
    function blog_by_cat($id){
        $cat = BlogCategorySet::where('category',$id)->select('blog')->get();
        $blogs = Blog::with('get_category.get_name')->whereIn('id',$cat)->paginate(10);
//        dd($blog);
        return view('frontend.blog_by_cat',compact('blogs'));
    }
}
