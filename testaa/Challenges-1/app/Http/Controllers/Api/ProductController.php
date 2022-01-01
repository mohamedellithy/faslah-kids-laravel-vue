<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Product;
use App\Http\Resources\ProductResource;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $products = Product::paginate(20);
        if($request->query('NoPaginate') == true) {
            $products = Product::all();
        }
        return ProductResource::collection($products);
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
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title'       => 'required',
            'description' => 'required',
            'image'       => 'mimes:jpeg,png,jpg,gif,svg'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ],401);
        }

        $Product = Product::create($request->all());

        if($Product){
            if($request->hasFile('image') ){
                ImagesController::store($request,$Product);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Products add successfully'
            ]);
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
        $product = Product::find($id);
        return new ProductResource($product);
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
        // return $request->all();
        $validator = Validator::make($request->all(),[
            'title'       => 'required',
            'description' => 'required',
            'image'       => 'mimes:jpeg,png,jpg,gif,svg'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],401);
        }

        $product = Product::where('id',$id)->update([
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
            'allow'       => $request->input('allow')
        ]);

        if($product){
            if($request->hasFile('image') ){
                $Product = Product::find($id);
                if($request->input('image_id') != "undefined"):
                    ImagesController::update($request,$Product);
                else:
                    ImagesController::store($request,$Product);
                endif;
            }
            return response()->json([
            'status' => 'success',
            'message' => 'Products updated successfully'
            ]);
        }
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
        $destroy = Product::destroy($id);
        if(!$destroy){
            return response()->json(array(
               'status' => 'error',
               'error'=> 'Product not deleted',
            ),401);
        }

        return response()->json(array(
            'status' => 'success',
            'message'=> 'Product deleted successfully',
        ));
    }
}
