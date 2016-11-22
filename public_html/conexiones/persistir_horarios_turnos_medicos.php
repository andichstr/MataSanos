<?php

include_once 'configure.php';
include_once 'conexion.php';


$turnos_persistir=persistirTurnosMedicosHorarios();

persistir_turnos($turnos_persistir);


function persistirTurnosMedicosHorarios() {//retornara los id de los turnos nuevos
    if (isset($_POST['id_medico']) && isset($_POST['especialidades']) && isset($_POST['horarios'])) {
        $turnos_persistir = []; //array que guardara los id de los turnos que se generaros en la ultima alta.
        $id_medico = $_POST['id_medico'];
        $especialidades = $_POST['especialidades'];
        $horarios = $_POST['horarios'];
        $con = new Conexion();
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $con->prepare("INSERT INTO " . tabla_horarios_turnos_medicos . " (id_medico, id_especialidad, dia, horario_inicio, horario_fin, duracion_turno_minutos) VALUES (:id_medico, :id_especialidad, :dia, :horario_inicio, :horario_fin, :duracion)");
        $query->bindParam(':id_medico', $id_medico);
        for ($i = 0; $i < count($especialidades); $i++) {
            $query->bindParam(':id_especialidad', $especialidades[$i]);
            for ($a = 0; $a < count($horarios); $a++) {
                $query->bindParam(':dia', $horarios[$a]['dia']);
                $query->bindParam(':horario_inicio', $horarios[$a]['horarioInicio']);
                $query->bindParam(':horario_fin', $horarios[$a]['horarioFin']);
                $query->bindParam(':duracion', $horarios[$a]['duracion']);
                if ($query->execute()) {
                    $turnos_persistir[] = $con->lastInsertId();
                    $resp = 'Sisi';
                } else {
                    $resp = 'Nono';
                }
            }
        }// fin del for
        echo $resp;
        return $turnos_persistir;
    } else {
        echo 'Campos no seteados';
    }
    $con = NULL;
}

function persistir_turnos($turnos) {//le paso un array con las id de los turnos a persistir.
    $con = new Conexion();
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $con->prepare("SELECT * FROM ". tabla_horarios_turnos_medicos . " WHERE id_horarios_turnos_medicos = :id");
    for ($a = 0; $a < count($turnos); $a++) { //por cada turno nuevo para persistir..
        $query->bindParam(':id', $turnos[$a]);
        if ($query->execute()) {
            $turno = $query->fetchAll()[0];
            
            $fechas = calcular_fecha($turno['dia']);
            $con2 = new Conexion();
            $con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //insertar turno..
            $query2 = $con->prepare("INSERT INTO " . tabla_turnos . "(horario, fecha, id_medico, id_especialidad) VALUES (:horario, :fecha, :medico, :especialidad)");

            //paso id medico y id_especialidad
            $query2->bindParam(':medico', $turno['id_medico']);
            $query2->bindParam(':especialidad', $turno['id_especialidad']);
//          
            //
            for ($i = 0; $i < count($fechas); $i++) { //recorremos las fechas del turno
                $query2->bindParam(':fecha', $fechas[$i]);

                $horarios = calcular_horarios($turno['horario_inicio'], $turno['horario_fin'], $turno['duracion_turno_minutos']);

                for ($m = 0; $m < count($horarios); $m++) {
                    $query2->bindParam(':horario', $horarios[$m]);
                    if ($query2->execute()) {
                        echo"Turno persistido";
                    } else{
                        echo "<br>Problema al persistir horario.";
                    }
                }
            }
        } else {
            $resp = 'Nono';
        }
    }
}

function calcular_fecha($dia) {//retorna array con las cuatro fechas siguientes que coincidan con el dia (pasado por parametro)
    if ($dia == 'Lunes') {
        $dia = "MONDAY";
    } elseif ($dia == 'Martes') {
        $dia = "TUESDAY";
    } elseif ($dia == 'Miercoles') {
        $dia = "WEDNESDAY";
    } elseif ($dia == 'Jueves') {
        $dia = "THURSDAY";
    } elseif ($dia == 'Viernes') {
        $dia = "FRIDAY";
    } elseif ($dia == 'Sabado') {
        $dia = "SATURDAY";
    } elseif ($dia == 'Domingo') {
        $dia = "SUNDAY";
    } else {
        echo 'error';
    }

    $fechas = [];
    $primer_fecha = new DateTime((date('Y-m-d', strtotime("next $dia"))));
    $intervalo = new DateInterval('P7D');
    $repeticiones = 4;

    $periodo = new DatePeriod($primer_fecha, $intervalo, $repeticiones);

    foreach ($periodo as $fecha) {
        $str_fecha = $fecha->format('Y-m-d');
        $fechas[] = $str_fecha;
//        echo $str_fecha.'<br>';
    }

    return $fechas;

//    echo (date('Y-m-d',strtotime("next $dia")));
//            $inicio = new DateTime('2016-11-21');
//            $intervalo = new DateInterval('P7D');
//
//            $fin = new DateTime('2012-07-31');
//            $repeticiones = 4;
//            $iso = 'R4/2012-07-01T00:00:00Z/P7D';
//
//// Todos estos periodos son equivalentes.
//            $periodo = new DatePeriod($inicio, $intervalo, $repeticiones);
//            $periodo = new DatePeriod($inicio, $intervalo, $fin);
//            $periodo = new DatePeriod($iso);
// Al recorrer el objeto DatePeriod, se imprimen todas
// las fechas de repetición dentro del periodo.
//            foreach ($periodo as $fecha) {
//                echo $fecha->format('Y-m-d') . "\n";
//                }
//
}

function calcular_horarios(
$inicio, $fin, $intervalo
) {
    $horarios = [];
//    $hora_inicio=new DateTime(date('',strtotime('000408')));
    $hora_inicio = new DateTime($inicio);
    $hora_final = new DateTime($fin);

    $inter = new DateInterval('PT' . $intervalo . 'M');
//    $inter=new DateInterval('PT15M');

    $periodo = new DatePeriod($hora_inicio, $inter, $hora_final);

    foreach ($periodo as $hora) {
        $str_horario = $hora->format('H:i:s');
        $horarios[] = $str_horario;
    }

    return $horarios;
}

//print_r(persistirTurnosMedicosHorarios());

?>

