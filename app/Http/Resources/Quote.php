<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Quote extends JsonResource
{
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
          'client_service_id'=> $this->client_service_id,
          'product_id'=> $this->product_id,
          'quantity'=> $this->quantity,
          'measure_id'=> $this->measure_id,
          'measure' => $this->measure->name,
          'description'=> $this->description,
          'price'=> $this->price,
          'amount'=> $this->amount,
        ];
    }
}
