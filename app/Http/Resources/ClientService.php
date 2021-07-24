<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientService extends JsonResource
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
            'folio' => $this->folio,
            'rate' => $this->rate,
            'client_id' => $this->client_id,
            'created_at' => $this->created_at->format('Y/m/d'),
            'number_service'=> $this->number_service,
            'average_cost'=> $this->average_cost,
            'annual_kilowatt'=> $this->annual_kilowatt,
            'annual_cost'=> $this->annual_cost,
            'required_units'=> $this->required_units,
            'panel_capacity'=> $this->panel_capacity,
            'irradiation'=> $this->irradiation,
            'annual_kilowatt_round'=> $this->annual_kilowatt_round,
            'annual_cost_round'=> $this->annual_cost_round,
            'dls_change' => $this->dls_change,
            'consumptions' => $this->consumptions,
            'total' => $this->total(),
            'total_dls' => $this->totalDls(),
            'sellers' => User::collection($this->sellers),
            'quotes' => Quote::collection($this->quotes),
            'status' => $this->status,
            'note' => $this->note
        ];
    }
}
