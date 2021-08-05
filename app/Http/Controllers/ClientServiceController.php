<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\SettingsTrait;
use App\Http\Resources\ClientServiceCollection;
use App\Models\Client;
use App\Models\ClientService;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Resources\ClientService as ClientServiceResource;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Knp\Snappy\Pdf;

class ClientServiceController extends Controller
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
             ->orderBy('created_at', 'desc')
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

            $clientService = ClientService::create([
                'client_id' => $request->client_id,
                'user_id' => auth()->user()->id,
                'folio' => $this->nextFolio(),
                'dls_change' =>  $request->dls_change,
                'status' => 'active_client',
                'note' =>  $request->note
            ]);


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
                'dls_change' =>  $request->dls_change,
                'note' =>  $request->note
            ])->save();

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

            $clientService->quotes()->delete();

            $clientService->delete();

            return response()->json(['data' => 'Cotizacion eliminada con exito!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function pagePay()
    {
        try {

            $view  = view('page-pay')->render();

            $footer = view('footer')->render();

            $pdf = \PDF::loadHTML( $view )
                ->setOption('footer-html', $footer);

            return $pdf->inline('cuentas.pdf');

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function quoteDoc($id)
    {
        try {

            $data =  ClientService::where('id', $id)->first();

           /* if ($data->status == 'new_client') {
                return $this->quoteProspect($data);
            }*/

            if ($data->number_service) {
                return $this->quoteProspect($data);
            }

            $data->load('client');
            $data->load('quotes');
            $data->load('quotes.measure');

            $view  = view('single-quote', compact('data'))->render();

            $footer = view('footer', compact('data'))->render();

            $pdf = \PDF::loadHTML( $view )
                ->setOption('footer-html', $footer);


            return $pdf->inline('cotizacion.pdf');

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function quoteProspect ($data) {

        $data->load('client');
        $data->load('consumptions');
        $data->load('quotes');
        $data->load('quotes.measure');

        $rows = 0;

        foreach ($data->quotes as $quote) {
            if ( strlen($quote->description) > 135) {
                $rows++;
            }
        }

        $view  = view('quote', compact('data', 'rows'))->render();

        $footer = view('footer', compact('data'))->render();

        $pdf = \PDF::loadHTML( $view )
            ->setOption('footer-html', $footer);

        return $pdf->inline('cotizacion.pdf');
    }



}
