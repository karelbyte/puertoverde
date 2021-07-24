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
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ClientGalleryController extends Controller
{

    use SettingsTrait;

    public function generateMedias($client) {
        $medias = [];
        foreach ($client->getMedia('gallery') as $media) {
            $id = $media->id;
            $fileName = $media->file_name;
            $url = url('/');
            $medias[] = [
                'id' => $id,
                'name' => $media->name,
                'type' => $media->extension,
                'url' => "${url}/storage/${id}/${fileName}"
            ];
        }
        return $medias;
    }

    public function index(Request $request)
    {

        try {

            $client = Client::findOrFail($request->client_id);

            return  [
                'total' => 0,
                'data' => $this->generateMedias($client)
            ];

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function store(Request $request)
    {
        try {
           $client = Client::findOrFail($request->client_id);

           if ($request->has('totalfiles') && $request->input('totalfiles') > 0) {

               for ( $index = 0; $index < $request->input('totalfiles'); $index++) {
                   $client ->addMedia($request->file('file'. $index))
                       ->toMediaCollection('gallery');
               }

           }

           sleep(5);
            return  [
                'total' => 0,
                'data' => $this->generateMedias($client)
            ];

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {

        try {

             Media::destroy($id);

            return response()->json(['data' => 'Documento eliminado con exito!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


}
