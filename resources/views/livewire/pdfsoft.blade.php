<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$filename}}</title>
    {!! Html::style('css/pdf/bootstrap.min.css') !!}
    {!! Html::style('css/pdf/pdfStyles.css') !!}
</head>
<body>
<div class="container">
    <br>
    <br>
    <div class="row">
        <div class="col-xs-2">
            {!! Html::image('/dist/img/logoGrandVelas1.png', 'logovelas', array('class' => 'img-responsive logo')) !!}
        </div>
        <div class="col-xs-8">
            <h1>{{Auth::user()->properties->long_name}}</h1>
            <h1>TECNOLOGIAS DE LA INFORMACION</h1>
            <h1>RESGUARDO DE EQUIPO DE TRABAJO</h1>
        </div>
    </div>
    <div class="row">

        <div class="col-xs-12">
            <h2>Fecha: {{date('d/m/Y', timestamp: strtotime($fecha_entrega)) }}</h2>
            <h2>Folio de resguardo: {{$folio}}</h2>
        </div>
    </div>
    <div class="row">

        <div class="col-xs-2">

            {!! Html::image($img_url.'/colaboradores/'.$resguardo['colaborador'][0]->fotografia,'img-colaborador',array('class'=>'img-responsive')) !!}
        </div>
        <div class="col-xs-9">
            <h3 class="margen">NOMBRE COMPLETO: <b>{{$resguardo['colaborador'][0]->nombre}}&nbsp;{{$resguardo['colaborador'][0]->apellidos}}</b></h3>
<!-- <h3 class="margen">ÁREA: <b>{{$resguardo['colaborador'][0]->nombre_departamento}}</b> </h3> -->
<!-- <h3 class="margen">PUESTO: <b>{{$resguardo['colaborador'][0]->nombre_asignacion}}</b> </h3> -->
            <h3 class="margen">#COLABORADOR: <b>{{$resguardo['colaborador'][0]->num_colaborador}}</b> </h3>
            <br>
            <p class="margen">El presente resguardo ampara la responsabilidad del colaborador para con la empresa <b>Grand Velas Riviera Maya.</b>Para el uso que para su fin existe y el cuidado del equipo de operación que obra en su poder, mismo que se rige bajo las siguientes condiciones: </p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-2">
            <span><b>CONDICIONES</b></span>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-9">
            <ol>
                <li>La empresa otorga bajo custodia el siguiente equipo de operación, mismo que se detalla a continuación:</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <?php $total=null; ?>
        @for($i=0; $i<=count($resguardo['articulos'])-1; $i++)
                <?php $total=$total+$resguardo['articulos'][$i][0]->costo;?>
            @if($i%2==0)
                <div class="col-xs-2">
                    {!! Html::image($img_url.'/img/'.$resguardo['name_table'][$i].'/'.$resguardo['articulos'][$i][0]->imagen,'img-equipo',array('class'=>'img-responsive')) !!}
                </div>
                <div class="col-xs-3">
                    @if($resguardo['name_table'][$i]=='moviles')
                        <ul>
                            <li>TIPO DE DISPOSITIVO: <b>{{$resguardo['articulos'][$i][0]->nombre_tipo}}</b></li>
                            <li>NUMERO: <b>{{$resguardo['articulos'][$i][0]->num_tel}}</b></li>
                            <li>IMEI: <b>{{$resguardo['articulos'][$i][0]->imei}}</b></li>
                            <li>SERIE: <b>{{$resguardo['articulos'][$i][0]->num_serie}}</b></li>
                            <li>MODELO: <b>{{$resguardo['articulos'][$i][0]->modelo}}</b></li>
                            <li>ESTADO: <b>{{$resguardo['articulos'][$i][0]->condiciones}}</b></li>
                            <!--<li>ACCESORIOS: <b>{{$resguardo['accesorios'][$i]}}</b></li>-->
                            <!--<li>CUENTA VINCULADA: <b>{{$resguardo['colaborador'][0]->email_coorporativo}}</b></li>-->
                            <li>COSTO: <b>$ {{$resguardo['articulos'][$i][0]->costo}}</b></li>
                        </ul>
                    @endif
                    @if($resguardo['name_table'][$i]=='computadoras' || $resguardo['name_table'][$i]=='dispositivos')
                        <ul>
                            <li>TIPO DE DISPOSITIVO:  <b>{{$resguardo['articulos'][$i][0]->nombre_tipo}}</b></li>
                            <li>SERVICE TAG PC:  <b>{{$resguardo['articulos'][$i][0]->service_tag}}</b></li>
                            <li>SERIE:  <b>{{$resguardo['articulos'][$i][0]->num_serie}}</b></li>
                            <li>MODELO:  <b>{{$resguardo['articulos'][$i][0]->modelo}}</b></li>
                           <!--<li>ESTADO:  <b>{{$resguardo['articulos'][$i][0]->condiciones}}</b></li>-->
                           <!-- <li>ACCESORIOS: <b>{{$resguardo['accesorios'][$i]}}</b></li>-->
                            <li>COSTO: <b>$ {{$resguardo['articulos'][$i][0]->costo}} </b></li>
                        </ul>
                    @endif
                    @if($resguardo['name_table'][$i]=='accesorios')
                        <ul>
                            <li>TIPO DE DISPOSITIVO:  <b>{{$resguardo['articulos'][$i][0]->nombre_accesorio}}</b></li>
                            <li>SERIE:  <b>{{$resguardo['articulos'][$i][0]->num_serie}}</b></li>
                            <li>MODELO:  <b>{{$resguardo['articulos'][$i][0]->modelo}}</b></li>
                            <!--<li>ESTADO:  <b>{{$resguardo['articulos'][$i][0]->condiciones}}</b></li>-->
                            <!--<li>ACCESORIOS: <b>{{$resguardo['accesorios'][$i]}}</b></li>-->
                            <li>COSTO: <b>$ {{$resguardo['articulos'][$i][0]->costo}} </b></li>
                        </ul>
                    @endif
                </div>
            @else
                <div class="row">
                    <div class="col-xs-2">
                        {!! Html::image($img_url.'/img/'.$resguardo['name_table'][$i].'/'.$resguardo['articulos'][$i][0]->imagen,'img-equipo',array('class'=>'img-responsive')) !!}
                    </div>
                    <div class="col-xs-3">
                        @if($resguardo['name_table'][$i]=='moviles')
                            <ul>
                                <li>TIPO DE DISPOSITIVO: <b>{{$resguardo['articulos'][$i][0]->nombre_tipo}}</b></li>
                                <li>NUMERO: <b>{{$resguardo['articulos'][$i][0]->num_tel}}</b></li>
                                <li>IMEI: <b>{{$resguardo['articulos'][$i][0]->imei}}</b></li>
                                <li>SERIE: <b>{{$resguardo['articulos'][$i][0]->num_serie}}</b></li>
                                <li>MODELO: <b>{{$resguardo['articulos'][$i][0]->modelo}}</b></li>
                                <li>ESTADO: <b>{{$resguardo['articulos'][$i][0]->condiciones}}</b></li>
                                <li>ACCESORIOS: <b>{{$resguardo['accesorios'][$i]}}</b></li>
                                <li>CUENTA VINCULADA: <b>{{$resguardo['colaborador'][0]->email_coorporativo}}</b></li>
                                <li>COSTO: <b>$ {{$resguardo['articulos'][$i][0]->costo}}</b></li>
                            </ul>
                        @endif
                        @if($resguardo['name_table'][$i]=='computadoras' || $resguardo['name_table'][$i]=='dispositivos')
                            <ul>
                                <li>TIPO DE DISPOSITIVO:  <b>{{$resguardo['articulos'][$i][0]->nombre_tipo}}</b></li>
                                <li>SERVICE TAG PC:  <b>{{$resguardo['articulos'][$i][0]->service_tag}}</b></li>
                                <li>SERIE:  <b>{{$resguardo['articulos'][$i][0]->num_serie}}</b></li>
                                <li>MODELO:  <b>{{$resguardo['articulos'][$i][0]->modelo}}</b></li>
                               <!-- <li>ESTADO:  <b>{{$resguardo['articulos'][$i][0]->condiciones}}</b></li>-->
                                <!--<li>ACCESORIOS: <b>{{$resguardo['accesorios'][$i]}}</b></li>-->
                                <li>COSTO: <b>$ {{$resguardo['articulos'][$i][0]->costo}} </b></li>
                            </ul>
                        @endif
                        @if($resguardo['name_table'][$i]=='accesorios')
                            <ul>
                                <li>TIPO DE DISPOSITIVO:  <b>{{$resguardo['articulos'][$i][0]->nombre_accesorio}}</b></li>
                                <li>SERIE:  <b>{{$resguardo['articulos'][$i][0]->num_serie}}</b></li>
                                <li>MODELO:  <b>{{$resguardo['articulos'][$i][0]->modelo}}</b></li>
                                <li>ESTADO:  <b>{{$resguardo['articulos'][$i][0]->condiciones}}</b></li>
                                <li>ACCESORIOS: <b>{{$resguardo['accesorios'][$i]}}</b></li>
                                <li>COSTO: <b>$ {{$resguardo['articulos'][$i][0]->costo}} </b></li>
                            </ul>
                        @endif
                    </div>
                </div>
            @endif
        @endfor
    </div>
    <div class="row">
        <div class="col-xs-12 text-right">
            <span>COSTO TOTAL DE RESGUARDO: <b>$ {{$total}} pesos</b></span>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <ol start="2" style="text-align: justify;">
                <li>El firmante recibe este Equipo y se responsabiliza de su guarda, custodia y movimiento y se obliga a entregarlo en su totalidad cuando deje de prestar sus servicios en el Hotel o en cualquier momento que se requiera en las mismas condiciones.</li>
                <li>El colaborador tiene la responsabilidad de reportar cualquier tipo de daño de este equipo inmediato y presentarlo al Area de TI.</li>
                <li>El Responsable del equipo obliga a permitir en cualquier momento  la revisión física por parte del responsable del área con los conocimientos básicos que el equipo requiere para el mismo y cualquier daño, será cubierta con cargo a éste ya sea reduciéndolo de su sueldo quincenal o aplicando el criterio que el departamento de  Contraloría del Hotel en común acuerdo con el jefe de área señalen.</li>
                <li>El colaborador se obliga a cumplir con el presente resguardo. Para el uso del equipo y cualquier violación a los mismos por parte del colaborador, se hará acreedor y así lo acepta desde la firma de este Convenio a la aplicación de las sanciones laborales del caso.</li>
                <li>Por motivos de seguridad no se podrán instalar y/o desinstalar aplicaciones en el equipo proporcionado sin previa autorización del departamento de Tecnologías de la información.</li>
                <li>Los datos contenidos en el equipo podrán ser sometidos a auditoría por parte del área de Tecnologías de la información a través de la cuenta de correo del trabajo en el momento que así se requiera.</li>
                <li>El colaborador acepta las políticas del departamento de TI y el acuerdo de confidencialidad de la empresa.</li>
                <li><b>EL COLABORADOR ES RESPONSABLE DE NOTIFICAR AL DEPARTAMENTO DE TI CUALQUIER CAMBIO DE POSICION INTERDEPARTAMENTAL Y POR CONSIGUIENTE REALIZAR LA REASIGNACION DE RESGUARDO DEL EQUIPO, DE LO CONTRARIO EL EQUIPO SEGUIRÁ SIENDO RESPONSIBILIDAD DEL PRESENTE FIRMANTE</li></b>
            
            </ol>

        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <p class="margen-final">El presente resguardo dejará de surtir efecto a la entrega del equipo o en su caso a la firma de un nuevo en el cual se señala fecha posterior al mismo, debidamente comprobado con las firmas de entrega recepción, siendo firmado con fecha de {{date('d/m/Y', strtotime($fecha_entrega)) }}</p>
        </div>
    </div>


    
    <div class="row">
        @if(count($resguardo['articulos'])>=3)
            <div class="page-break"></div>
        @endif
        <div class="col-xs-12">
            <br>
            <table class="table table-responsive table-bordered">
                <tr>
                    <th>RECIBIO</th>
                    <th>ENTREGA</th>
                    <th>Vo. Bo.</th>
                </tr>
                <tr>
                    <td><br><br><br>{{$resguardo['colaborador'][0]->nombre}}&nbsp;{{$resguardo['colaborador'][0]->apellidos}} <!-- <p>{{$resguardo['colaborador'][0]->nombre_asignacion}}</p></td> -->
                    <td><br><br><br>Ivan Nerey Ochoa <p>Gerente de Tecnologías de la Información</p></td>
                    <td><br><br><br>{{Auth::user()->properties->general_director}} <p>Director General</p></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h4>C.c.p Contralor</h4>
            <h4>C.c.p Gerente de Recursos Humanos</h4>
            <h4>C.c.p Gerente de Tecnologías de la Información</h4>
        </div>
    </div>
</div>
</body>
</html>