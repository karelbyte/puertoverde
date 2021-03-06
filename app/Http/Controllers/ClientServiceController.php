<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\SettingsTrait;
use App\Http\Resources\ClientServiceCollection;
use App\Models\ClientService;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\ServiceQuote;
use Illuminate\Http\Request;
use App\Http\Resources\ClientService as ClientServiceResource;
use Exception;


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

            return [
                'total' => 0,
                'data' => new ClientServiceCollection($data),
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
                'folio' => $this->nextFolio('folio'),
                'dls_change' => $request->dls_change,
                'status' => 'active_client',
                'note' => $request->note
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

            $clientService = ClientService::find($id);

            $clientService->fill([
                'dls_change' => $request->dls_change,
                'note' => $request->note
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

            $view = view('page-pay')->render();

            $footer = view('footer')->render();

            $pdf = \PDF::loadHTML($view)
                ->setOption('footer-html', $footer);

            return $pdf->inline('cuentas.pdf');

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function quoteDoc($id)
    {
        try {

            $data = ClientService::where('id', $id)->first();

            if ($data->number_service) {
                return $this->quoteProspect($data);
            }

            $data->load('client');
            $data->load('quotes');
            $data->load('quotes.measure');

            $view = view('single-quote', compact('data'))->render();

            $footer = view('footer', compact('data'))->render();

            $pdf = \PDF::loadHTML($view)
                ->setOption('footer-html', $footer);


            return $pdf->inline('cotizacion - ' . $data->folio . '.pdf');

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function quoteProspect($data)
    {

        $data->load('client');
        $data->load('consumptions');
        $data->load('quotes');
        $data->load('quotes.measure');

        $rows = 0;

        foreach ($data->quotes as $quote) {
            if (strlen($quote->description) > 135) {
                $rows++;
            }
        }

        $view = view('quote', compact('data', 'rows'))->render();

        $footer = view('footer', compact('data'))->render();

        $pdf = \PDF::loadHTML($view)
            ->setOption('footer-html', $footer);

        return $pdf->inline('cotizacion.pdf');
    }

    public function setToInventories($id)
    {
        try {

            $service = ClientService::with([
                'consumptions',
                'sellers',
                'quotes',
                'quotes.measure'
            ])->where('id', $id)->first();

            foreach ($service->quotes as $item) {

                $inventory = Inventory::where('product_id', $item->product_id)->first();
                $inventory->quantity = $inventory->quantity - $item->quantity;
                $inventory->save();

                $inventory->details()->create([
                    'documentable_type' => ClientService::class,
                    'documentable_id' => $service->id,
                    'type' => 'Servicio',
                    'quantity' => -$item->quantity,
                    'total' => $inventory->quantity
                ]);
            }

            $service->fill([
                'apply_inventory' => 1
            ])->save();


            return new ClientServiceResource($service);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function clone(Request $request)
    {

        try {

            $clientService = ClientService::find($request->id);

            $clientService = $clientService->replicateRow();

            return new ClientServiceResource($clientService);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function combined(Request $request)
    {

        try {

            $order = Order::create([
                'user_id' => auth()->user()->id,
                'moment' => now(),// Carbon::parse($request->moment),
                'document' => $this->nextFolio('order'),
                'note' => '',
                'amount' => 0,
                'status' => 'in-progress'
            ]);

            $services = ServiceQuote::whereIn('client_service_id', $request->ids)->get();

            $items = $services->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                ];
            });

            $order->items()->createMany($items->toArray());

            return response()->json(['data' => 'Pedido creado con exito!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

}
