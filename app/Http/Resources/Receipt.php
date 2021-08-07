<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\AdvancedResourceTrait;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Facades\Log;

class Receipt extends JsonResource
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
              'owner' => $this->user->name,
              'moment_show' => Carbon::parse($this->moment)->format('d-m-Y'),
              'moment' => $this->moment,
              'document' => $this->document,
              'status' => $this->status,
              'status_show' => $this->status == 'in-progress' ? 'Edicion' : 'Aplicada',
              'items' => new ReceiptItemCollection($this->items)
        ];
    }
}
