<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Historico-{{$data->product->name}}</title>
        <!-- Fonts -->
        <style>
            .grid{box-sizing:border-box;display:-webkit-flex;display:-ms-flexbox;display:-webkit-box;display:flex;-webkit-flex:0 1 auto;-ms-flex:0 1 auto;-webkit-box-flex:0;flex:0 1 auto;-webkit-flex-direction:row;-ms-flex-direction:row;-webkit-box-orient:horizontal;-webkit-box-direction:normal;flex-direction:row;-webkit-flex-wrap:wrap;-ms-flex-wrap:wrap;flex-wrap:wrap;margin:0 -8px 0 -8px}.grid.grid-nogutter{margin:0}.grid.grid-nogutter>.col{padding:0}.col{box-sizing:border-box;-webkit-flex:0 0 auto;-ms-flex:0 0 auto;flex:0 0 auto;-webkit-flex-grow:1;-ms-flex-positive:1;-webkit-box-flex:1;flex-grow:1;-ms-flex-preferred-size:0;-webkit-flex-basis:0;flex-basis:0;max-width:100%;min-width:0;padding:0 8px 0 8px}.col-align-top{-webkit-align-self:flex-start;-ms-flex-item-align:start;align-self:flex-start}.col-align-bottom{align-self:flex-end}.col-align-middle{-webkit-align-self:center;-ms-flex-item-align:center;align-self:center}.col-top{justify-content:flex-start !important;flex-direction:column;display:flex}.col-bottom{justify-content:flex-end !important;flex-direction:column;display:flex}.col-middle{justify-content:center;flex-direction:column;display:flex}.grid-start{-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start}.grid-center{-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.grid-end{-webkit-box-pack:end;-ms-flex-pack:end;justify-content:flex-end}.grid-around{justify-content:space-around}.grid-between{-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.col-first{-webkit-box-ordinal-group:0;-ms-flex-order:-1;order:-1}.col-last{-webkit-box-ordinal-group:2;-ms-flex-order:1;order:1}.grid-reverse{-webkit-box-orient:horizontal;-webkit-box-direction:reverse;-ms-flex-direction:row-reverse;flex-direction:row-reverse}.col-fixed{flex:initial}.col-grow-2{flex-grow:2}.col-grow-3{flex-grow:3}.col-grow-4{flex-grow:4}.col-grow-5{flex-grow:5}.col-grow-6{flex-grow:6}.col-grow-7{flex-grow:7}.col-grow-8{flex-grow:8}.col-grow-9{flex-grow:9}.col-grow-10{flex-grow:10}.col-grow-11{flex-grow:11}.col-1{-ms-flex-preferred-size:8.33333%;-webkit-flex-basis:8.33333%;flex-basis:8.33333%;max-width:8.33333%}.col-2{-ms-flex-preferred-size:16.66667%;-webkit-flex-basis:16.66667%;flex-basis:16.66667%;max-width:16.66667%}.col-3{-ms-flex-preferred-size:25%;-webkit-flex-basis:25%;flex-basis:25%;max-width:25%}.col-4{-ms-flex-preferred-size:33.33333%;-webkit-flex-basis:33.33333%;flex-basis:33.33333%;max-width:33.33333%}.col-5{-ms-flex-preferred-size:41.66667%;-webkit-flex-basis:41.66667%;flex-basis:41.66667%;max-width:41.66667%}.col-6{-ms-flex-preferred-size:50%;-webkit-flex-basis:50%;flex-basis:50%;max-width:50%}.col-7{-ms-flex-preferred-size:58.33333%;-webkit-flex-basis:58.33333%;flex-basis:58.33333%;max-width:58.33333%}.col-8{-ms-flex-preferred-size:66.66667%;-webkit-flex-basis:66.66667%;flex-basis:66.66667%;max-width:66.66667%}.col-9{-ms-flex-preferred-size:75%;-webkit-flex-basis:75%;flex-basis:75%;max-width:75%}.col-10{-ms-flex-preferred-size:83.33333%;-webkit-flex-basis:83.33333%;flex-basis:83.33333%;max-width:83.33333%}.col-11{-ms-flex-preferred-size:91.66667%;-webkit-flex-basis:91.66667%;flex-basis:91.66667%;max-width:91.66667%}.col-12{-ms-flex-preferred-size:100%;-webkit-flex-basis:100%;flex-basis:100%;max-width:100%}@media only screen and (max-width: 480px){.col-sm{flex:100%;max-width:100%}}@media only screen and (max-width: 624px){.col-md{flex:100%;max-width:100%}}@media only screen and (max-width: 744px){.col-lg{flex:100%;max-width:100%}}
            body {
                font-family: 'Nunito', sans-serif;
                font-size: 18px;
            }
            .mb-5 {
                margin-bottom: 10px;
            }
            .back-green{
                background-color: rgb(146, 200, 80);
            }

            .border-black {
                border: 1px solid black !important;
            }

            .pa-100{
                padding: 0 20px 0 10px;
            }

           table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }

            th, td {
                padding: 6px;
            }
            tr {
                text-align: center;
            }

            .page {
                overflow: hidden;
                page-break-after: always;
            }

        </style>
    </head>
    <body>
     <img src="{{asset('asset/pv.png')}}" alt="" style="margin-top: 20px">
     <br><br>
     <h2>HISTORICO MOVIMIENTOS</h2>
     <div class="grid">
         <div class='col col-4 pa-100'>
             <div class="back-green" style="padding:6px; font-size: 22px;">
                 <b>PRODUCTO :</b>
             </div>
             <div class="border-black" style="text-align: center; padding:6px; font-size: 22px;">
                 {{$data->product->name}}
             </div>
         </div>
         <div class='col col-3'>
             <div class='grid grid-nogutter back-green'>
                 <div class='col'  style="text-align: right; padding:6px; font-size: 22px;">
                    <b>FECHA ELAB:</b>
                 </div>
             </div>
             <div class='grid grid-nogutter border-black'>
                 <div class='col' style="text-align: right; padding:6px; font-size: 22px;">
                    <b>{{now()->format('d/m/Y')}}</b>
                 </div>
             </div>
         </div>
     </div>
     <br>
     <div style="margin-top: 20px; font-size: 22px;"><b>DETALLES</b></div>
     <div class="grid ">
         <div class="col" style="text-align: right">
             <table style="width:100%">
                 <tr class="back-green">
                     <td style="padding: 5px; font-size: 22px; text-align: left;"><b>FECHA</b></td>
                     <td style="padding: 5px; font-size: 22px; text-align: left;"><b>CREADO</b></td>
                     <td  style="padding: 5px; font-size: 22px;"><b>DOCUMENTO</b></td>
                     <td  style="padding: 5px; font-size: 22px;"><b>TIPO</b></td>
                     <td  style="padding: 5px; font-size: 22px;"><b>CANTIDAD</b></td>
                     <td  style="padding: 5px; font-size: 22px;"><b>TOTAL</b></td>
                 </tr>
                 @foreach($data->details as $key => $item)
                     <tr>
                         <td style="font-size: 19px;text-align: left; padding-left: 10px">{{$item->created_at->format('d/m/Y H:i')}}</td>
                         <td style="font-size: 19px;text-align: left; padding-left: 10px">{{$item->documentable->user->name}}</td>
                         @if ($item->documentable->document)
                         <td style="font-size: 19px;">{{$item->documentable->document}}</td>
                         @else
                             <td style="font-size: 19px;">{{$item->documentable->folio}}</td>
                         @endif
                         <td style="font-size: 19px;">{{$item->type}}</td>
                         <td style="font-size: 19px;">{{$item->quantity}}</td>
                         @if ($key == 0)
                         <td style="font-size: 19px;"><b>{{$item->total}}</b></td>
                         @else
                             <td style="font-size: 19px;">{{$item->total}} </td>
                             @endif
                     </tr>
                 @endforeach
             </table>
         </div>
     </div>

    </body>
</html>
