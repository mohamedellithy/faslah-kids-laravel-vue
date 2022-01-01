<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductResource;
class BarcodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        $image_Qr_code = view('admin.QR-code')->with('Qrcode',$this->value)->render();
        return [
            'id'        => $this->id,
            'code'      => $this->value,
            'image'     => $image_Qr_code,
            'product'   => ($this->attach == false ? new ProductResource($this->Product) : ''),
            'Activated' => ($this->activated == 1 ? 'activated' : 'not activated'),
        ];
    }
}
