<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Client extends JsonResource
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
          'owner' => $this->user->name,
          'company' => $this->company,
          'name' => $this->name,
          'email' => $this->email,
        //  'type' => $this->type,
          'address' => $this->address,
          'phones' => $this->phones,
          'created_at' => $this->created_at->format('d-m-Y'),
          'note' => $this->note
        ];
    }
}
