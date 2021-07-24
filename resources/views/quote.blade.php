<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cotizacion</title>
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
     <div class="grid">
         <div class='col col-6'><b>1. CLIENTE</b> </div>
         <div class='col col-6' style="text-align: right">FOLIO:<b>{{$data->folio}}</b>  </div>
     </div>
     <div class="grid">
         <div class='col col-4 pa-100'>
             <div class="back-green" style="padding:6px">
               <b>NOMBRE:</b>
             </div>
             <div class="border-black" style="text-align: center; padding:6px">
                  {{$data->client->name}}
             </div>
         </div>

         <div class='col col-3 pa-100'>
             <div class="back-green" style="padding:6px">
                <b>No. DE SERVICIO:</b>
             </div>
             <div class="border-black" style="text-align: center; padding:6px" >
                 {{$data->number_service}}
             </div>
         </div>
         <div class='col col-3'>
             <div class='grid grid-nogutter back-green'>
                 <div class='col' style="padding:6px">
                    <b>TARIFA:</b>
                 </div>
                 <div class='col'  style="text-align: right; padding:6px">
                    <b>FECHA ELAB:</b>
                 </div>
             </div>
             <div class='grid grid-nogutter border-black'>
                 <div class='col' style="padding:6px">
                     <b>{{$data->rate}}</b>
                 </div>
                 <div class='col' style="text-align: right; padding:6px">
                    <b>{{$data->created_at->format('d/m/Y')}}</b>
                 </div>
             </div>
         </div>
     </div>
     @if ($data->quotes->count() > 10 || $rows > 4)
         <br><br><br>
     @endif
     <div style="margin-top: 20px;font-size: 22px;"><b>2. ANÁLISIS DE FACTURACIÓN DEL CLIENTE</b></div>
     <div style="padding: 10px 50px 10px 20px">
         <span style="font-size: 22px; text-align: justify;">En la siguiente tabla se muestra el análisis y la facturación del usuario  <b>{{$data->client->name}}</b> del ultimo año comprendida en el
             periodo del <b>{{$data->consumptionFirstPeriod()->period}}</b> al  <b>{{$data->consumptionLastPeriod()->period}}</b>. De estos gastos el precio por kWh  de cada mes servirán como base para el análisis de
             los ahorros económicos para la generación de energía mediante el sistema fotovoltaico.
         </span>
     </div>
     @if ($data->quotes->count() > 10 || $rows > 4)
         <br><br><br>
     @endif
     <div style="display: block">
       <table style="width:50%; float: left" >
           <thead>
           <tr class="back-green">
               <th colspan="3">TABLA DE CONSUMO</th>
           </tr>
           </thead>
           <tr>
               <td><b>FACTURACION</b></td>
               <td><b>kWh</b></td>
               <td><b>FACTURACION</b></td>
           </tr>
           @foreach($data->consumptions as $consumption)
               <tr>
                   <td>{{$consumption->period}}</td>
                   <td>{{$consumption->kwh}}</td>
                   <td>$ {{number_format($consumption->consumption, 2, '.', ',')}}</td>
               </tr>
           @endforeach
           <tr>
               <td><b>TOTAL</b></td>
               <td><b>{{$data->annual_kilowatt}}</b></td>
               <td><b>$ {{number_format($data->annual_cost, 2, '.', ',')}}</b></td>
           </tr>
           <tr>
               <td><b>REDONDEO</b></td>
               <td><b>{{$data->annual_kilowatt_round}}</b></td>
               <td><b>$ {{number_format($data->annual_cost_round, 2, '.', ',')}}</b></td>
           </tr>
       </table>
       <table style="width:35%; float: right; margin-right: 10px">
             <thead>
             <tr class="back-green">
                 <th colspan="3">COSTOS</th>
             </tr>
             </thead>
             <tr>
                 <td><b>COSTO PROMEDIO POR kWh</b></td>
                 <td><b>{{$data->average_cost}}</b></td>
             </tr>
           <tr>
               <td><b>kWh ANUAL</b></td>
               <td><b>{{number_format($data->consumptionskWhTotal(), 0, '.', ',')}}</b></td>
           </tr>
           <tr>
               <td><b>FACTURACION ANUAL</b></td>
               <td><b>$ {{number_format($data->consumptionsTotal(), 2, '.', ',')}}</b></td>
           </tr>

         </table>
     </div>
     @if ($data->consumptions->count() == 6)
     <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      @else
         <br><br><br><br><br><br><br><br><br><br>
         <br><br><br><br><br><br><br><br><br>
         <br><br><br><br><br><br><br><br><br>
     @endif
     @if ($data->quotes->count() > 10 || $rows > 4)
         <br><br><br>
     @endif
     <div style="margin-top: 10px; font-size: 22px;"><b>3. REQUERIMIENTO</b></div>
     <div style="padding: 10px 50px 10px 20px">
         <span style="font-size: 22px; text-align: justify;">A continuación se realiza el calculo para cubrir la demanda energética actual  <b>{{$data->annual_kilowatt}} </b> kWh
             considerando módulos fotovoltáicos de <b>{{$data->panel_capacity}}</b> Wp con un F.I de <b>{{$data->irradiation}}</b>
         </span>
     </div>
     @if ($data->quotes->count() > 10 || $rows > 4)
         <br><br><br>
     @endif
     <div class="grid">
         <div class="col col-1"></div>
         <div class="col">
            <table style="width:100%">
                <tr>
                    <td class="back-green"><b>PRODUCCIÓN MÍNIMA REQUERIDA</b></td>
                    <td><b>{{number_format($data->annual_kilowatt_round, 0, '.', ',')}}</b> kWh</td>
                </tr>
                <tr>
                    <td class="back-green"><b>UNIDADES  REQUERIDAS PARA SATISFACER DEMANDA</b></td>
                    <td><b>{{number_format($data->required_units, 0, '.', ',')}}</b></td>
                </tr>
                <tr>
                    <td class="back-green"><b>PRODUCCIÓN GARANTIZADA PROMEDIO BIMESTRAL EN kWh </b></td>
                    <td><b>{{number_format($data->productionGuaranteed(), 0, '.', ',')}}</b> kWh</td>
                </tr>
            </table>
         </div>
         <div class="col col-1"></div>
     </div>
     @if ($data->quotes->count() > 10  || $rows > 4)
         <div class="page"></div>
         <div style="padding-top: 30px">
         </div>
         <img src="{{asset('asset/pv.png')}}" alt="" style="margin-top: 10px">
     @endif
     <div style="margin-top: 20px; margin-bottom:10px; font-size: 22px;"><b>4. INVERSIÓN REQUERIDA</b></div>
     <div class="grid ">

         <div class="col" style="text-align: right">
             <table style="width:100%">
                 <tr class="back-green">
                     <td  style="padding: 5px"><b>CANTIDAD</b></td>
                     <td><b>UNIDAD</b></td>
                     <td><b>DESCRIPCIÓN</b></td>
                     <td><b>P.U</b></td>
                     <td><b>IMPORTE</b></td>
                 </tr>
                 @foreach($data->quotes as $quotes)
                     <tr>
                         <td style="font-size: 19px;width:60px">{{$quotes->quantity}}</td>
                         <td style="font-size: 19px;width:60px">{{$quotes->measure->name}}</td>
                         <td style="font-size: 19px;text-align: left; padding-left: 10px">{{$quotes->description}}</td>
                         <td style="font-size: 19px;width: 120px ">$ {{number_format($quotes->price, 2, '.', ',')}}</td>
                         <td style="font-size: 19px;width: 120px "><b>$ {{number_format($quotes->amount, 2, '.', ',')}}</b></td>
                     </tr>
                 @endforeach
             </table>
         </div>
     </div>
     <div style="display: block; width: 100%; margin-top: 5px">

         <table style="width:30%; float: right; ">
             <tr>
                 <td class="back-green"><b>SUBTOTAL</b></td>
                 <td><b>$ {{number_format($data->subtotal(), 2, '.', ',')}}</b></td>
             </tr>
             <tr>
                 <td class="back-green"><b>IVA 16%</b></td>
                 <td><b>$ {{number_format($data->iva(), 2, '.', ',')}}</b></td>
             </tr>
             <tr>
                 <td class="back-green"><b>TOTAL DLLS</b></td>
                 <td><b>$ {{number_format($data->totalDls(), 2, '.', ',')}}</b></td>
             </tr>
             <tr>
                 <td class="back-green"><b>PESOS</b></td>
                 <td><b>$ {{number_format($data->total(), 2, '.', ',')}}</b></td>
             </tr>
         </table>
        {{-- <div style="width:66%; float: right; height: 50px; text-align: center;  ">
            <p style="margin-top: 30px">TIPO DE CAMBIO DEL DIA QUE SE EXPIDE LA COTIZACION  <b>{{number_format($data->dls_change, 4, '.', ',')}}</p></b>
         </div>--}}
     </div>

     <div class="page"></div>
     <div style="padding-top: 30px">
     </div>
     <img src="{{asset('asset/pv.png')}}" alt="" style="margin-top: 10px">
     <br><br>
     <div style="font-size: 22px; margin-top: 10px; margin-bottom: 10px"><b>5. APOYO AL MEDIO AMBIENTE</b></div>
    <p style="font-size: 22px;  text-align: justify">
        Cada módulo solar equivale a 32 árboles plantados al año. Con tu inversión estás a punto de producir el equivalente a <b>{{$data->trees()}}</b> plantados al año. Con esto contribuyes a reducir los efectos del cambio climático.

    </p>

     <div style="font-size: 22px; margin-top: 10px; margin-bottom: 10px"><b>6. GARANTIAS</b></div>
     <p style=" font-size: 22px; text-align: justify">
         Puerto verde utiliza materiales certificados y de la más alta calidad, por lo que ofrece una garantía de respaldo hasta por 3 años contra cualquier desperfecto en la instalación del
         sistema fotovoltaico. La cotización presente cuenta con una vigencia de 5 días naturales.
     </p>

     <div style="font-size: 22px; margin-top: 10px; margin-bottom: 10px"><b>7. POLITICAS DE COMPRA</b></div>
     <p style=" font-size: 22px; text-align: justify">
         LAS POLITICAS DE COMPRA SON DEL 70% PARA FIRMA DE CONTRATO, 30% AL FINAL DE LA
         INSTALACION .

     </p>
    <p style="font-size: 22px; text-align: justify">
        <b>NOTA:</b> <br><br>LOS EQUIPOS PUEDEN VARIAR EN SU MODELO Y CAPACIDAD SEGÚN LA DOSPONIBILIDAD
        SIN QUE ESTO AFECTE EN LA PRODUCCION O CALIDAD DE LOS PRODUCTOS. <br><br>
        LOS TIEMPOS DE INTERCONECCION CON CFE SON INDEPENDIENTES A LA EMPRESA.
        <br><br>
        LOS COSTOS NO INCLUYEN EXCAVACION, RANURAS, ACABADOS, UNIFICACION DE CARGAS
        NI MODIFICACION EN LA INSTALACION ELECTRICA INTERNA DEL CLIENTE.
        <br><br>
        LA EMPRESA SE COMPROMETE A INSTALAR SU PROYECTO EN UN LAPSO NO MAYOR A 15 DÍAS HABILES, SIEMPRE Y CUENDO LAS CONDICIONES DEL TIEMPO LO PERMITAN
         (EN DÍAS LLUVIOSOS NO ES POCIBLE TRABAJAR)

    </p><br>
     <div style="margin-top: 140px; display: block; width: 100%">
         <div style="width: 40%; float: left; text-align: center">
             <div style="border-top: 1px solid black;"> </div>

         </div>
         <div style="width: 20%; float: left; text-align: center; color:transparent">a
         </div>
         <div style="width: 40%; float: left;  text-align: center">
             <div style="border-top: 1px solid black"> </div>
         </div>
     </div>
     <br>
    <div style="display: block; width: 100%">
        <div style="font-size: 18px; width: 40%; float: left; text-align: center">
            ASESOR DE VENTAS PUERTO VERDE
        </div>
        <div style="width: 18%; float: left; text-align: center; color:transparent">a</div>
        <div style="font-size: 20px; width: 40%; float: left;  text-align: center; color:black">
            RECIBIDO
        </div>
    </div>
    </body>
</html>
