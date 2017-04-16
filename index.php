<?php
    include 'FootballData.php';
    include 'functions.php';

    set_error_handler("my_warning_handler", E_ALL);
    function my_warning_handler($errno, $errstr, $errfile, $errline, $errcontext) {
        throw new Exception("No se ha podido enviar la solicitud :(");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Inicio</title>
        <link href="css/estilos-inicio.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="container">
            <?php
                try {
                    $api = new FootballData();
                    $hoy = date("Y-m-d");
                    $horaActual = date("H:i:s");
                    $competiciones = ['426', '430', '434', '436', '438', '439', '440'];

                    echo "<table class='tabla-resultados'>";
                        foreach ($competiciones as $idCompeticion) {
                            $competicion = $api -> getSoccerseasonById($idCompeticion);
                            $partidos = $competicion -> getFixturesForDateRange($hoy,$hoy);
                            $nPartidos = count($partidos);
                            $equipos = $competicion -> getTeams();
                            $nEquipos = count($equipos);
                            if ($nPartidos > 0) {
                                echo "<tr class='tabla-caption'>";
                                    echo "<td colspan='10'>" . "<a href='clasificacion.php?idCompeticion=$idCompeticion'>" . nombreOficialCompeticion($competicion -> payload -> caption) . "</a>" . "</td>";
                                echo "</tr>";
                                for ($i = 0; $i < $nPartidos; $i++) {
                                    $urlPartido = explode("/", $partidos[$i] -> _links -> self -> href);;
                                    $idPartido = end($urlPartido);
                                    $nombreLocal = $partidos[$i] -> homeTeamName;
                                    $nombreVisitante = $partidos[$i] -> awayTeamName;
                                    $horaPartido = date("H:i", strtotime("+0 hour", strtotime($partidos[$i] -> date)));
                                    $estadoPartido = $partidos[$i] -> status;
                                    $golesLocal = $partidos[$i] -> result -> goalsHomeTeam;
                                    $golesVisitante = $partidos[$i] -> result -> goalsAwayTeam;
                                    for ($j = 0; $j < $nEquipos; $j++) {
                                        if ($equipos[$j] -> name == $partidos[$i] -> homeTeamName) {
                                            $urlEquipoLocal = explode("/", $equipos[$j] -> _links -> self -> href);
                                            $idEquipoLocal = end($urlEquipoLocal);
                                        }
                                        if ($equipos[$j] -> name == $partidos[$i] -> awayTeamName) {
                                            $urlEquipoVisitante = explode("/", $equipos[$j] -> _links -> self -> href);
                                            $idEquipoVisitante = end($urlEquipoVisitante);
                                        }
                                    }
                                    echo "<tr class='partido' onclick=\"document.location = 'partido.php?idPartido=$idPartido';\" style='cursor: pointer;'>";
                                        if ($estadoPartido == "TIMED" || $estadoPartido == "SCHEDULED") {
                                            echo "<td class='goles'>" . $horaPartido . "</td>";                        
                                        }
                                        if ($estadoPartido == "IN_PLAY") {
                                            echo "<td class='goles' style='color: red;'>" . calcularMinuto($horaPartido, $horaActual) . "</td>";
                                        }
                                        if ($estadoPartido == "FINISHED") {
                                            echo "<td class='goles'>" . "Finalizado" . "</td>";
                                        }
                                        if ($estadoPartido == "POSTPONED") {
                                            echo "<td class='goles'>" . "Aplazado" . "</td>";
                                        }
                                        echo "<td class='nombre-local'>" . "<a href='equipo.php?idEquipo=$idEquipoLocal'>" . $nombreLocal . "</a>" . "</td>";
                                        if ($estadoPartido == "TIMED" || $estadoPartido == "SCHEDULED") {
                                            echo "<td class='goles'>" . " - " . "</td>";
                                        }
                                        if ($estadoPartido == "IN_PLAY") {
                                            echo "<td class='goles' style='color: red;'>" . $golesLocal . " - " . $golesVisitante . "</td>";
                                        }
                                        if ($estadoPartido == "FINISHED") {
                                            echo "<td class='goles'>" . $golesLocal . " - " . $golesVisitante . "</td>";
                                        }
                                        echo "<td class='nombre-visitante'>" . "<a href='equipo.php?idEquipo=$idEquipoVisitante'>" . $nombreVisitante . "</a>" . "</td>";
                                    echo "</tr>";
                                }
                            }   
                        }
                    echo "</table>";
                } catch(Exception $e) {
                    print_r($e->getMessage());
                }
            ?>
        </div>
    </body>
</html>
