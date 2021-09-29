<?php

namespace App\Exports;

use App\Http\Resources\Product as ProductResource;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ClientsExport implements FromView
{
    use Exportable;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function view(): View
    {

        $items =  Client::filter($this->params['name'] ?? null)
            ->type($this->params['type'] ?? null)
            ->get();


        return view('exports.clients', [
            'items' => $items,
            'type' =>  $type = $this->params['type'] == 'lead' ? 'Prospectos' : 'Clientes'
        ]);
    }
}
