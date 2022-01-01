<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\KidResource;
use App\User;
use Yajra\Datatables\Datatables;
use App\Challenge;
use App\Http\Resources\ChallengeResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class KidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $kids = User::kids()->paginate(10);
        if($request->query('NoPaginate') == true) {
            $kids = User::kids()->get();
        }
        return KidResource::collection($kids);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function challenges_activities($kid_id){
        $Context['challenges_finished'] = Challenge::whereHas('kids', function($query) use ($kid_id){
            return $query->where('challenge_solutions.kid_id',$kid_id);
        })->pluck('id')->toArray();

        $Context['next_challenge'] = Challenge::whereDoesntHave('kids',function(Builder $query) use ($kid_id){
            return $query->where('challenge_solutions.kid_id',$kid_id);
        })->select('id')->orderBy('number')->first();

        return response()->json($Context);
    }

    public function get_my_challenges($kid_id){
        $Context = User::with('challenges')->where('users.id',$kid_id)->get();
        return KidResource::collection($Context);
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
        $kid = User::find($id);
        return new KidResource($kid);

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
        $kid = User::find($id);
        return new KidResource($kid);
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
        $validate = Validator::make($request->all(),[
            'image'       => 'sometimes|mimes:jpeg,png,jpg,gif,svg',
            'firstname'   => 'required',
            'lastname'    => 'required',
            'age'         => 'required',
            'email'       => 'sometimes|email|unique:users,email',
            'old_password'=> 'sometimes|password:api',
            'password'    => 'sometimes|min:6|max:20',
            'password_confirmation'=> 'sometimes|same:password'

        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ]);
        }

        if($request->has('password')){
            $request->merge([
                'password' => Hash::make($request->input('password')),
            ]);
        }

        $updated =  User::where('id',$id)->update($request->except([
            'old_password',
            'password_confirmation',
            'image',
            'image_id'
        ]));

        if($updated){
            $kid = User::find($id);
            if($request->hasFile('image')){
                if($request->input('image_id')):
                    ImagesController::update($request,$kid);
                elseif(empty($request->input('image_id'))):
                    ImagesController::store($request,$kid);
                endif;
            }
            return response()->json([
                'status' =>'success',
                'message'=>'your information has been successfully updated'
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
        $destroy = User::destroy($id);
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
