<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\PagesTrait;
use App\Http\Resources\MeasureCollection;
use App\Models\Measure;
use Illuminate\Http\Request;
use App\Http\Resources\Measure as MeasureResource;
use Exception;

class MeasureController extends Controller
{
    use PagesTrait;

    public function index(Request $request)
    {
        try {

            $data = Measure::filter($request->name);

            if ($request->paging == 'on') {
                list($take, $skip) = $this->getPagesConfig($request);
                $total = $data->select('*')->count();
                $list = $data->skip($skip)->take($take)->get();
            } else {
                $total = 0;
                $list = $data->get();
            }

            return  [
                'total' => $total,
                'data' =>  new MeasureCollection($list),
            ];

        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $measure = Measure::create($request->all());

            return new MeasureResource($measure);

        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $measure = Measure::find($id);

            $measure->fill($request->all())->save();

            return new MeasureResource( $measure);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $measure = Measure::where('id', $id)->first();

            $measure->delete();

            return response()->json(['data' => 'Medida eliminada con exito!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
