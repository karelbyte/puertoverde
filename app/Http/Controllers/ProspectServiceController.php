<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\SettingsTrait;
use App\Http\Resources\ClientService as ClientServiceResource;
use App\Http\Resources\ClientServiceCollection;
use App\Models\Client;
use App\Models\ClientService;
use App\Models\Setting;
use Illuminate\Http\Request;
use Exception;

class ProspectServiceController extends Controller
{
    use SettingsTrait;

    public function index(Request $request)
    {

        try {

            $data = ClientService::with([
                'consumptions',
                'sellers',
                'quotes',
                'quotes.measure'
            ])
                ->freeForAll()
                ->where('client_id', $request->client_id)
                ->orderBy('created_at', 'asc')
                ->get();

            return  [
                'total' => 0,
                'data' =>  new ClientServiceCollection($data),
            ];

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function store(Request $request)
    {
        try {

            $service = ClientService::with('client')
                ->where('number_service', $request->number_service)
                ->where('client_id', '<>', $request->client_id)
                ->first();

            if ($service) {
                return response()->json(['error' => 'El client <b>'. $service->client->name.  '</b> tiene una cotización con ese número <b>'. $request->number_service . '</b>' ], 500);
            }

            $clientService = ClientService::create([
                'user_id' => auth()->user()->id,
                'folio' => $this->nextFolio(),
                'rate' =>  $request->rate,
                'client_id' => $request->client_id,
                'created_at' => now(),
                'number_service'=> $request->number_service,
                'average_cost'=> $request->average_cost,
                'annual_kilowatt'=> $request->annual_kilowatt,
                'annual_cost'=> $request->annual_cost,
                'required_units'=> $request->required_units,
                'units'=> $request->units,
                'combined' => $request->combined,
                'panel_capacity'=> $request->panel_capacity,
                'irradiation'=> $request->irradiation,
                'annual_kilowatt_round'=> $request->annual_kilowatt_round,
                'annual_cost_round'=> $request->annual_cost_round,
                'dls_change' => $request->dls_change,
                'total_annual' => $request->total_annual,
                'total_kwh' =>  $request->total_kwh,
                'status' => 'prospect',
                'periods' =>  $request->periods,
            ]);

            $clientService->consumptions()->createMany($request->consumptions);

            foreach ($request->sellers as $seller ) {
                $clientService->sellers()->attach($seller['id']);
            }

            $clientService->quotes()->createMany($request->quotes);

            return new ClientServiceResource($clientService);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $clientService =  ClientService::find($id);

            $clientService->fill([
                'user_id' => auth()->user()->id,
                'rate' =>  $request->rate,
                'client_id' => $request->client_id,
                'number_service'=> $request->number_service,
                'average_cost'=> $request->average_cost,
                'annual_kilowatt'=> $request->annual_kilowatt,
                'annual_cost'=> $request->annual_cost,
                'required_units'=> $request->required_units,
                'combined' => $request->combined,
                'units'=> $request->units,
                'panel_capacity'=> $request->panel_capacity,
                'irradiation'=> $request->irradiation,
                'annual_kilowatt_round'=> $request->annual_kilowatt_round,
                'annual_cost_round'=> $request->annual_cost_round,
                'dls_change' => $request->dls_change,
                'total_annual' => $request->total_annual,
                'total_kwh' =>  $request->total_kwh,
                'periods' =>  $request->periods,
            ])->save();

            $clientService->consumptions()->delete();
            $clientService->consumptions()->createMany($request->consumptions);

            $clientService->sellers()->sync([]);
            foreach ($request->sellers as $seller ) {
                $clientService->sellers()->attach($seller['id']);
            }

            $clientService->quotes()->delete();
            $clientService->quotes()->createMany($request->quotes);

            return new ClientServiceResource($clientService);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {

        try {

            $clientService = ClientService::where('id', $id)->first();

            $clientService->sellers()->sync([]);

            $clientService->consumptions()->delete();

            $clientService->quotes()->delete();

            $clientService->delete();

            return response()->json(['data' => 'Prospecto eliminado con exito!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function quoteDoc($id)
    {

        try {

            $data = ClientService::with([
                'client',
                'consumptions',
                'sellers',
                'quotes',
                'quotes.measure'
            ])
                ->where('id', $id)
                ->first();

            $rows = 0;
            foreach ($data->quotes as $quote) {
              if ( strlen($quote->description) > 135) {
                  $rows++;
              }
            }

            $view  = view('quote', compact('data', 'rows'))->render();

            $footer = view('footer', compact('data'))->render();

            //   $header = view('header', compact('data'))->render();

            $pdf = \PDF::loadHTML( $view )
                ->setOption('footer-html', $footer);
            //  ->setOption('header-html', $header);

            return $pdf->inline('cotizacion - '.$data->folio .'.pdf');

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function createClient(Request $request) {

        try {

            $client = Client::find($request->client_id);
            $client->type = 'client';
            $client->save();

            $service = ClientService::find($request->quote_id);
            $service->status = 'new_client';
            $service->save();

            return http_response_code(200);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function combined(Request $request) {

        try {

            $clientService = ClientService::create([
                'user_id' => auth()->user()->id,
                'folio' => $this->nextFolio(),
                'rate' =>  '',
                'client_id' => $request->client_id,
                'created_at' => now(),
                'number_service'=> 'Combinada',
                'average_cost'=> 0,
                'annual_kilowatt'=> 0,
                'annual_cost'=> 0,
                'required_units'=> 0,
                'units'=> 0,
                'combined' => 1,
                'panel_capacity'=> 0,
                'irradiation'=> 4.5,
                'annual_kilowatt_round'=> 0,
                'annual_cost_round'=> 0,
                'dls_change' => 0,
                'status' => 'prospect',
                'total_annual' => 0,
                'total_kwh' =>  0,
            ]);

            $services  = ClientService::whereIn('id', $request->ids)->get();

            $consumptions  =  $services->map(function ($item) {
                return [
                    'period' =>  $item->number_service,
                    'kwh' =>  $item->annual_kilowatt,
                    'consumption' =>  $item->annual_cost,
                ];
            });

            $clientService->consumptions()->createMany($consumptions);

            return new ClientServiceResource($clientService);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }


    }
}
