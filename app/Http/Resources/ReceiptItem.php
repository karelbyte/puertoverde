<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\AdvancedResourceTrait;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Facades\Log;

class ReceiptItem extends JsonResource
{
    use AdvancedResourceTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

          return [
              'id' => $this->id,
              'product_id' => $this->product_id,
              'quantity' => $this->quantity,
              'description' => $this->product->name,
              'measure' => $this->product->measure->name,
              'price' =>  $this->product->price->sale_price,
              'amount' =>  $this->product->price->sale_price * $this->quantity
        ];
    }
}
