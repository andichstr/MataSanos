<?php
$dia="MONDAY";
//$primer_fecha = new DateTime((date('Y-m-d', strtotime("next $dia"))));
//echo $primer_fecha->format('Y-m-d');

    $fechas = [];
    $primer_fecha = new DateTime((date('Y-m-d', strtotime("next $dia"))));
    $intervalo = new DateInterval('P7D');
    $repeticiones = 4;

    $periodo = new DatePeriod($primer_fecha, $intervalo, $repeticiones);

    foreach ($periodo as $fecha) {
        $str_fecha = $fecha->format('Y-m-d');
        $fechas[] = $str_fecha;
    }
    
    print_r($fechas);
//        echo $str_fecha.'<br>';
    
