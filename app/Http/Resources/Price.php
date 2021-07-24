<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Price extends JsonResource
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
          'price' => $this->price,
          'sale_price' => $this->sale_price,
          'percent_apply' => $this->percent_apply,
          'created_at' => $this->created_at->format('Y-m-d'),
          'used' => $this->used,
          'default' => $this->default
        ];
    }
}
