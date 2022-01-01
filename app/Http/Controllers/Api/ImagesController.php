<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Image;
class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store($request,object $model,$direct = null)
    {
        if(!empty($model)):
            if($direct == null):
                $image = $request->file('image');
            else:
                $image = $request;
            endif;
            $extension = $image->getClientOriginalExtension();
            $new_name = 'Image_'.time().rand(100,1000).'.'.$extension;
            $image->storeAs('public/dashboard/images',$new_name);
            $model->images()->create([
                'imageable_id'   => $model->id,
                'imageable_type' => 'App/'.$model->getTable(),
                'image_url'      => 'dashboard/images/'.$new_name,
            ]);
        endif;
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
    public static function update(Request $request,$model = null)
    {
        //
        if(!empty($model)):
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $new_name = 'Image_'.time().'.'.$extension;
            $image->storeAs('public/dashboard/images',$new_name);
            Image::where('id',$request->input('image_id'))->update([
                'image_url'      => 'dashboard/images/'.$new_name
            ]);
        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
