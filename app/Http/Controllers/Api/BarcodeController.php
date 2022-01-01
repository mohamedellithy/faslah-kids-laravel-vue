<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Barcode;
use App\Http\Resources\BarcodeResource;
use Illuminate\Support\Facades\Crypt;
use Yajra\Datatables\Datatables;
class BarcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $barcode = Barcode::paginate(10);
        if($request->query('NoPaginate') == true) {
            $barcode = Barcode::all();
        }
        if($request->query('attached')  == 1 ) {
            $barcode = Barcode::doesntHave('challenges')->get();
        }
        // BarcodeResource::collection($barcode)
        return BarcodeResource::collection($barcode);
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
            'count'       => 'required',
            'item_id'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ],401);
        }

        if(self::generate_Qr_codes($request)){
            return response()->json([
                'status' => 'success',
                'message' => 'Barcodes generated successfully count ( '.$request->count.' )'
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
        $Barcode = Barcode::find($id);
        return new BarcodeResource($Barcode);
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
        $Barcode = Barcode::find($id);
        return new BarcodeResource($Barcode);
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
            'Activated'       => 'required',
            'item_id'         => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],401);
        }

        $product = Barcode::where('id',$id)->update([
            'item_id'       => $request->input('item_id'),
            'Activated'     => $request->input('Activated')
        ]);

        if($product){
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
        $destroy = Barcode::destroy($id);
        if(!$destroy){
            return response()->json(array(
               'status' => 'error',
               'error'=> 'Barcode not deleted',
            ),401);
        }

        return response()->json(array(
            'status' => 'success',
            'message'=> 'Barcode deleted successfully',
        ));
    }

    public static function generate_Qr_codes($request){
        $Qr_codes = array();
        for($qr = 0;$qr < $request->count;$qr++ ){
            $Qr_codes[$qr] =array(
                "value"      =>sha1(strtotime(date("Y-m-d H:i:s")).rand(100,10000)),
                "item_id"    =>$request->item_id,
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            );
        }

        $insert = Barcode::insert($Qr_codes);
        if($insert){
            return true;
        }
        return false;
    }

    public static function activate_barcode($barcode,$kid_id){
        Barcode::where('value',$barcode)->update([
            'kid_id'        => $kid_id,
            'Activated'     => 1
        ]);
    }
}
