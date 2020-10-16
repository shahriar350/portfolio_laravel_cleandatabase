<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CvBody;
use App\Models\CvHeader;
use App\Models\CvTitle;
use Illuminate\Http\Request;

class CvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.components.cv_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $cv_items = CvTitle::with('get_header','get_header.get_body')->latest()->get();
        return response()->json(['data' => $cv_items]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->cv['id'] === null) {
            $request->validate([
                'cv.cv_title' => 'required',
                'cv.header.*.name' => 'required',
                'cv.header.*.body.*.name' => 'required',
            ]);
        } else {
            $request->validate([
                'cv.cv_title' => 'required',
            ]);
        }

        if (isset($request->cv['id'])) {
            $cv_title = CvTitle::findOrFail($request->cv['id']);

        } else {
            $cv_title = new CvTitle();
        }
        $cv_title->name = $request->cv['cv_title'];
        $cv_title->color = $request->cv['title_color'];
        $cv_title->size = (int)$request->cv['title_fontsize'];
        $cv_title->save();
        if(count($request->cv['header']) > 0){
            foreach ($request->cv['header'] as $head){
                if (isset($head['name'])) {
                    if (isset($head['id'])) {
                        $header = CvHeader::findOrFail($head['id']);
                    } else {
                        $header = new CvHeader();
                    }

                    $header->title_id = $cv_title->id;
                    $header->name = $head['name'];
                    $header->color = $head['color'];
                    $header->size = $head['font'];
                    $header->save();
                    if (count($head['body']) > 0) {
                        foreach ($head['body'] as $body){
                            if (isset($body['name'])) {
                                if (isset($body['id'])) {
                                    $bodyitem = CvBody::findOrFail($body['id']);
                                } else {
                                    $bodyitem = new CvBody();
                                }
                                $bodyitem->header_id= $header->id;
                                $bodyitem->name= $body['name'];
                                $bodyitem->color= $body['color'];
                                $bodyitem->size= $body['font'];
                                $bodyitem->save();
                            }
                        }
                    }
                }

            }
            return response()->json(['data' => CvTitle::with('get_header','get_header.get_body')->findOrFail($cv_title->id)]);
        }
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
    public function destroy($id,$type)
    {

        if (is_numeric($id)) {
            if ((int)$type === 1) {
                $val = CvTitle::findOrFail($id)->delete();
            } elseif ((int)$type === 2) {
                $val = CvHeader::findOrFail($id)->delete();
            } elseif ((int)$type === 3) {
                $val = CvBody::findOrFail($id)->delete();
            }
            return response('',200);
        }
    }
}
