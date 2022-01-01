<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\StaticsResponse;
use App\Barcode;
use App\Product;
use App\Challenge;
use App\User;
class StaticsController extends Controller
{
    //
    public $Context = array();
    function index(Request $request){
        $type_statics = $request->query('section') ? $request->query('section') : 'barcodes';
        return $this->{$type_statics.'Statics'}();
    }

    public function barcodesStatics(){
       $this->Context['part_1']['count']              = Barcode::count();
       $this->Context['part_1']['title']              = 'barcodes';
       $this->Context['part_1']['icon']               = 'fas fa-qrcode';

       $this->Context['part_2']['count']              = Barcode::where('activated',1)->count();
       $this->Context['part_2']['title']              = 'Barcodes Activated';
       $this->Context['part_2']['icon']               = 'fas fa-qrcode';

       $this->Context['part_3']['count']              = Barcode::whereHas('Product')->count();
       $this->Context['part_3']['title']              = 'Barcodes attached to Products';
       $this->Context['part_3']['icon']               = 'fas fa-qrcode';

       $this->Context['part_4']['count']              = Product::count();;
       $this->Context['part_4']['title']              = 'Products';
       $this->Context['part_4']['icon']               = 'fas fa-boxes';

       return StaticsResponse::collection($this->Context);
    }

    public function productsStatics(){
       $this->Context['part_1']['count']              = Product::count();
       $this->Context['part_1']['title']              = 'Products';
       $this->Context['part_1']['icon']               = 'fas fa-boxes';

       $this->Context['part_2']['count']              = Product::whereHas('barcodes')->count();
       $this->Context['part_2']['title']              = 'Products have Barcodes';
       $this->Context['part_2']['icon']               = 'fas fa-boxes';

       $this->Context['part_3']['count']              = Barcode::count();
       $this->Context['part_3']['title']              = 'Barcodes';
       $this->Context['part_3']['icon']               = 'fas fa-qrcode';

       $this->Context['part_4']['count']              = Challenge::count();;
       $this->Context['part_4']['title']              = 'Challenges';
       $this->Context['part_4']['icon']               = 'fas fa-cube';

       return StaticsResponse::collection($this->Context);
    }

    public function challengesStatics(){
       $this->Context['part_1']['count']              = Challenge::count();
       $this->Context['part_1']['title']              = 'Challenges';
       $this->Context['part_1']['icon']               = 'fas fa-cube';

       $this->Context['part_2']['count']              = Challenge::whereHas('product')->count();
       $this->Context['part_2']['title']              = 'products activated';
       $this->Context['part_2']['icon']               = 'fas fa-cube';

       $this->Context['part_3']['count']              = Barcode::count();
       $this->Context['part_3']['title']              = 'Barcodes';
       $this->Context['part_3']['icon']               = 'fas fa-qrcode';

       $this->Context['part_4']['count']              = Product::count();;
       $this->Context['part_4']['title']              = 'Products';
       $this->Context['part_4']['icon']               = 'fas fa-boxes';

       return StaticsResponse::collection($this->Context);
    }

    public function kidsStatics(){
       $this->Context['part_1']['count']              = User::Kids()->count();
       $this->Context['part_1']['title']              = 'Kids';
       $this->Context['part_1']['icon']               = 'fas fa-child';

       $this->Context['part_2']['count']              =  User::Kids()->whereNotNull('email_verified_at')->count();
       $this->Context['part_2']['title']              = 'Kids Active';
       $this->Context['part_2']['icon']               = 'fas fa-child';

       $this->Context['part_3']['count']              = Barcode::whereHas('Product')->count();
       $this->Context['part_3']['title']              = 'Barcodes attached to challenges';
       $this->Context['part_3']['icon']               = 'fas fa-qrcode';

       $this->Context['part_4']['count']              = Product::count();;
       $this->Context['part_4']['title']              = 'products';
       $this->Context['part_4']['icon']               = 'fas fa-boxes';

       return StaticsResponse::collection($this->Context);
    }

}
