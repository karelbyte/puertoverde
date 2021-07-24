<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
          'name' => $this->name,
          'email' => $this->email,
          'status' => $this->status,
          'admin' => $this->admin,
          'seller' => $this->seller,
          'manager_percentage' => $this->manager_percentage,
          'manager_price' => $this->manager_price,
          'free_for_all' => $this->free_for_all,
          'permissions' => Permission::collection($this->permissions)
        ];
    }
}
