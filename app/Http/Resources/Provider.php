<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Provider extends JsonResource
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
          'company' => $this->company,
          'name' => $this->name,
          'email1' => $this->email1,
          'email2' => $this->email2,
          'phones' => $this->phones,
          'address1' => $this->address1,
          'address2' => $this->address2,
        ];
    }
}
