<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\AdvancedResourceTrait;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Facades\Log;

class Product extends JsonResource
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
          $defaultPrice = null;
          if ($this->prices) {
              $defaultPrice =  $this->prices->firstWhere('default', 1);
          }

          $media = $this->getFirstMedia('products');

        $mediaResource = [
            'id' => null,
            'name' => 'Ficha tecnica',
            'type' => null,
            'url' => null
        ];

          if ($media) {
              $id = $media->id;
              $fileName = $media->file_name;
              $url = url('/');
              $mediaResource = [
                  'id' => $id,
                  'name' => $media->name,
                  'type' => $media->extension,
                  'url' => "${url}/storage/${id}/${fileName}"
              ];
          }

          return [
              'id' => $this->id,
              'name' => $this->name,
              'code' => $this->code,
              'description' => $this->hasAttribute('description'),
              'type' => $this->hasAttribute('type'),
              'provider' => $this->provider,
              'price' => $this->price,
              'type_description' => $this->type == 'inventory' ? 'Producto' : 'Servicio',
              'measure_id' => $this->measure_id,
              'measure' => new Measure($this->measure) ,
              'created_at' => $this->created_at->format('d-m-Y'),
              'prices' => Price::collection($this->prices),
              'providers' => Provider::collection($this->providers),
              'default_price' => $defaultPrice,
              'relates' => $this->relates,
              'media' => $mediaResource,
              'status' => $this->status,
              'status_str' => $this->status ? 'Activo' : 'Desactivado',
              'inventory' => $this->inventory
        ];
    }
}
