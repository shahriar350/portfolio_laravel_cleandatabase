<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.components.banner');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $activebanners = Banner::where('active',1)->get();
        $deactivatebanners = Banner::where('active',0)->get();
        return response()->json(['active' => $activebanners,'deactive' => $deactivatebanners]);
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
            'banner' => 'required|image|max:2048',
            'caption' => 'nullable|string',
            'text' => 'nullable|string',
        ]);
        $bannerImg = $request->banner;
        $banner = new Banner();
        $banner->caption = $request->caption;
        $banner->active = 0;
        $banner->text = $request->text;
        $banner->image = rand().uniqid().time().'.'.$bannerImg->extension();
        $banner->save();
        $bannerImg->move('images',$banner->image);
        return response()->json(['data' => $banner]);

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
        $banner = Banner::findOrFail($id);
        if ($banner) {
            if($banner->delete()){
                if (file_exists(public_path().'/images/'.$banner->image)) {
                    unlink(public_path().'/images/'.$banner->image);
                }
            }
        }
        return response('',200);
    }
    public function bannerActive($id)
    {
        $banner = Banner::findOrFail($id);
        if ($banner) {
            $banner->active = 1;
            $banner->save();
        }
        return response()->json(['data' => $banner]);
    }
    public function bannerDeactivate($id)
    {
        $banner = Banner::findOrFail($id);
        if ($banner) {
            $banner->active = 0;
            $banner->save();
        }
        return response()->json(['data' => $banner]);
    }
}
