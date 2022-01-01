<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Challenge;
use App\Http\Resources\ChallengeResource;
class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $challenges = Challenge::paginate(20);
        if($request->query('NoPaginate') == true) {
            $challenges = Challenge::all();
        }
        return ChallengeResource::collection($challenges);
    }

    public function challenges_of_product($id){
       $challenge  = Challenge::where('product_id', $id)->orderBy('number')->get();
       return ChallengeResource::collection($challenge);
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
        //
        $validator = Validator::make($request->all(), [
            'title'       => 'required|unique:challenges',
            'description' => 'required',
            'product_id'  => 'required',
            'image'       => 'mimes:jpeg,png,jpg,gif,svg'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ],401);
        }

        $Challenge = Challenge::create($request->all());
        if($Challenge):
            ImagesController::store($request,$Challenge);
            return response()->json([
                'status' => 'success',
                'message' => 'Products add successfully'
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
        $challenge = Challenge::find($id);
        return new ChallengeResource($challenge);
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
        $challenge = Challenge::find($id);
        return new ChallengeResource($challenge);
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
        $validator = Validator::make($request->input(), [
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

        $Challenge = Challenge::where('id',$id)->update([
            'title'            => $request->input('title'),
            'description'      => $request->input('description'),
            'allow'            => $request->input('allow'),
            'product_id'       => $request->input('product_id'),
            'number'           => $request->input('number')
        ]);

        if($Challenge){
            if($request->file('image')){
                if($request->input('image_id')):
                    ImagesController::update($request,$challenge);
                elseif(empty($request->input('image_id'))):
                    ImagesController::store($request,$challenge);
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
        $destroy = Challenge::destroy($id);
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
