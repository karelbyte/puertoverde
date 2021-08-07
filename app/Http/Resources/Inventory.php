<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\AdvancedResourceTrait;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Facades\Log;

class Inventory extends JsonResource
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
              'name' => $this->product->name,
              'code' => $this->product->code,
              'description' =>  $this->product->description,
              'quantity' => $this->quantity,
              'min' => $this->min
        ];
    }
}
