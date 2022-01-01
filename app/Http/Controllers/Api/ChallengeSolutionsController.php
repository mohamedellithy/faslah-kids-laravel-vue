<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Challenge;
use App\Http\resources\SolutionsResource;
use App\Http\resources\SingleSolutionsResource;
use App\Http\resources\ChallengesSolutionsResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use App\ChallengeSolutions;
use App\User;
class ChallengeSolutionsController extends Controller
{
    //

    public function kids_solutions(){
         $challenge = Challenge::with('kids')->whereHas('kids')->inRandomOrder()->limit(3)->get();
         return SolutionsResource::collection($challenge);
    }

    public function attach_solution(Request $request){
        $validate = Validator::make($request->all(),[
            'images.*' => 'required|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'required',
            'kid_id'  => 'required|exists:users,id',
            'challenge_id' => 'required|exists:challenges,id'
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors()
            ],401);
        }

        $solution = ChallengeSolutions::create([
            'kid_id'       => $request->input('kid_id'),
            'challenge_id' => $request->input('challenge_id'),
            'description'  => $request->input('description'),
        ]);

        if($solution){
            if($request->hasFile('images')){
                foreach($request->file('images') as $file){
                   ImagesController::store($file,$solution,true);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'solutions added successfully thank you'
            ],200);
        }
    }

    public function get_solution_of_kid($id){
        $challenge = ChallengeSolutions::find($id);
        return new ChallengesSolutionsResource($challenge);
    }

    public function all_solutions(){
        $challenge = ChallengeSolutions::paginate(10);
        return ChallengesSolutionsResource::collection($challenge);
    }
}
