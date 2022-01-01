<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Http\Resources\KidResource;
use Illuminate\Validation\Rule;
class AuthController extends Controller
{
    //
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'=>'required|email',
            'barcode'=>['sometimes',Rule::exists('barcodes', 'value')->where('activated',0)],
            'password'=>'required|min:6|max:50',
        ]);

        if( $validator->fails() ){
            return response()->json([
                'error' => 'Failed to login Please Try again or barcode not allowed to use  ',
                'message' => $validator->errors()
            ],401);
        }

        $credentials = request(['email', 'password']);


        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Failed to login Please Try again'], 401);
        }
        if($request->has('barcode')){
            \App\Http\Controllers\Api\BarcodeController::activate_barcode($request->input('barcode'),auth()->user()->id);
        }
        return $this->respondWithToken($token);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'firstname'=>'required',
            'lastname'=>'required',
            'age'=>'required',
            'barcode'=>['required',Rule::exists('barcodes','value')->where('activated',0)],
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|max:50',
            'password_confirmation' =>'required|min:6|max:50|same:password'
        ]);

        if( $validator->fails() ){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ]);
        }

        $create_new_kids = new User();
        $create_new_kids->firstname = $request->input('firstname');
        $create_new_kids->lastname  = $request->input('lastname');
        $create_new_kids->age       = $request->input('age');
        $create_new_kids->email     = $request->input('email');
        $create_new_kids->password  = Hash::make($request->input('password'));
        $create_new_kids->save();

        if($create_new_kids){
            \App\Http\Controllers\Api\BarcodeController::activate_barcode($request->input('barcode'),$create_new_kids->id);
            return response()->json([
                'status'  => 'success',
                'message' => 'Account created successfully'
            ]);
        }

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return new KidResource(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
