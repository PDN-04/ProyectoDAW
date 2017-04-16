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
        <title>Clasificación</title>
        <link href="css/estilos-clasificacion.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="container">
            <?php
                try {
                    if (isset($_GET['idCompeticion'])) {
                        $idCompeticion = $_GET['idCompeticion'];
                        $api = new FootballData();
                        $competicion = $api -> getSoccerseasonById($idCompeticion);
                        $clasificacion = $competicion -> getLeagueTable();
                        $nombreCompeticion = $clasificacion -> leagueCaption;
                        $jornada = $competicion -> payload -> currentMatchday;
                        $nEquipos = count($clasificacion -> standing);
                        $equipos = $competicion -> getTeams();

                        echo "<table class='tabla-clasificacion'>";
                            echo "<tr class='tabla-header'>";
                                echo "<td colspan='10'>" . $nombreCompeticion . "</td>";
                            echo "</tr>";
                            echo "<tr class='tabla-caption'>";
                                echo "<td colspan='10'>" . "Clasificación - Jornada " . $jornada . "</td>";
                            echo "</tr>";
                            echo "<tr class='tabla-datos'>";
                                echo "<td colspan='3'>" . "" . "</td>";
                                echo "<td>" . "Ptos" . "</td>";
                                echo "<td>" . "PJ" . "</td>";
                                echo "<td>" . "PG" . "</td>";
                                echo "<td>" . "PE" . "</td>";
                                echo "<td>" . "PP" . "</td>";
                                echo "<td>" . "GF" . "</td>";
                                echo "<td>" . "GC" . "</td>";
                            echo "</tr>";
                            for ($i = 0; $i < $nEquipos; $i++) {
                                $posicion = $clasificacion -> standing[$i] -> position;
                                $color = calcularColor($idCompeticion, $posicion);
                                for ($j = 0; $j < $nEquipos; $j++) {
                                    if ($equipos[$j] -> name == $clasificacion -> standing[$i] -> teamName) {
                                        $urlEquipo = explode("/", $equipos[$j] -> _links -> self -> href);
                                        $idEquipo = end($urlEquipo);
                                    }
                                }
                                echo "<tr>";
                                    echo "<td class='$color'>" . $posicion . "</td>";
                                    echo "<td>" . "<img style='height: 20px;' src='" . $clasificacion -> standing[$i] -> crestURI . "'>" . "</td>";
                                    echo "<td class='nombre-equipo'>" . "<a href='equipo.php?idEquipo=$idEquipo'>" . $clasificacion -> standing[$i] -> teamName . "</a>" . "</td>";
                                    echo "<td class='puntos-equipo'>" . $clasificacion -> standing[$i] -> points . "</td>";
                                    echo "<td class='partidos-jugados'>" . $clasificacion -> standing[$i] -> playedGames . "</td>";
                                    echo "<td>" . $clasificacion -> standing[$i] -> wins . "</td>";
                                    echo "<td>" . $clasificacion -> standing[$i] -> draws . "</td>";
                                    echo "<td class='partidos-perdidos'>" . $clasificacion -> standing[$i] -> losses . "</td>";
                                    echo "<td>" . $clasificacion -> standing[$i] -> goals . "</td>";
                                    echo "<td>" . $clasificacion -> standing[$i] -> goalsAgainst . "</td>";
                                echo "</tr>";
                            }
                        echo "</table>";

                        echo "<table class='tabla-leyenda'>";
                            echo "<tr>";
                                echo "<td class='champions-league'>" . "" . "</td>";
                                echo "<td>" . "Champions League" . "</td>";
                            echo "</tr>";
                            echo "<tr>";
                                echo "<td class='europa-league'>" . "" . "</td>";
                                echo "<td>" . "Europa League" . "</td>";
                            echo "</tr>";
                            echo "<tr>";
                                echo "<td class='descenso'>" . "" . "</td>";
                                echo "<td>" . "Descenso" . "</td>";
                            echo "</tr>";
                        echo "</table>";

                        $resultados = $competicion -> getFixturesByMatchday($jornada - 1);
                        $nPartidos = count($resultados);

                        if ($jornada != 1) {
                            echo "<table class='tabla-resultados'>";
                                echo "<tr class='tabla-caption'>";
                                    echo "<td colspan='4'>" . "Resultados - Jornada " . ($jornada - 1) . "</td>";
                                echo "</tr>";
                                for ($i = 0; $i < $nPartidos; $i++) {
                                    $urlPartido = explode("/", $resultados[$i] -> _links -> self -> href);;
                                    $idPartido = end($urlPartido);
                                    $nombreLocal = $resultados[$i] -> homeTeamName;
                                    $nombreVisitante = $resultados[$i] -> awayTeamName;
                                    $golesLocal = $resultados[$i] -> result -> goalsHomeTeam;
                                    $golesVisitante = $resultados[$i] -> result -> goalsAwayTeam;
                                    for ($j = 0; $j < $nEquipos; $j++) {
                                        if ($equipos[$j] -> name == $resultados[$i] -> homeTeamName) {
                                            $urlEquipoLocal = explode("/", $equipos[$j] -> _links -> self -> href);
                                            $idEquipoLocal = end($urlEquipoLocal);
                                        }
                                        if ($equipos[$j] -> name == $resultados[$i] -> awayTeamName) {
                                            $urlEquipoVisitante = explode("/", $equipos[$j] -> _links -> self -> href);
                                            $idEquipoVisitante = end($urlEquipoVisitante);
                                        }
                                    }
                                    echo "<tr class='partido' onclick=\"document.location = 'partido.php?idPartido=$idPartido';\" style='cursor: pointer;'>";
                                        echo "<td class='nombre-local'>" . "<a href='equipo.php?idEquipo=$idEquipoLocal'>" . $nombreLocal . "</a>" . "</td>";
                                        echo "<td class='goles'>" . $golesLocal . " - " . $golesVisitante . "</td>";
                                        echo "<td class='nombre-visitante'>" . "<a href='equipo.php?idEquipo=$idEquipoVisitante'>" . $nombreVisitante . "</a>" . "</td>";
                                    echo "</tr>";
                                }
                            echo "</table>";
                        }

                        if ($jornada != $competicion -> payload -> numberOfMatchdays) {
                            $resultados = $competicion -> getFixturesByMatchday($jornada);
                            $nPartidos = count($resultados);

                            echo "<table class='tabla-resultados'>";
                                echo "<tr class='tabla-caption'>";
                                    echo "<td colspan='4'>" . "Próximos - Jornada " . $jornada . "</td>";
                                echo "</tr>";
                                for ($i = 0; $i < $nPartidos; $i++) {
                                    $urlPartido = explode("/", $resultados[$i] -> _links -> self -> href);;
                                    $idPartido = end($urlPartido);
                                    $nombreLocal = $resultados[$i] -> homeTeamName;
                                    $nombreVisitante = $resultados[$i] -> awayTeamName;
                                    $diaPartido = date("d/m", strtotime("+0 hour", strtotime($resultados[$i] -> date)));
                                    $horaPartido = date("H:i", strtotime("+0 hour", strtotime($resultados[$i] -> date)));
                                    $estadoPartido = $resultados[$i] -> status;
                                    $golesLocal = $resultados[$i] -> result -> goalsHomeTeam;
                                    $golesVisitante = $resultados[$i] -> result -> goalsAwayTeam;
                                    for ($j = 0; $j < $nEquipos; $j++) {
                                        if ($equipos[$j] -> name == $resultados[$i] -> homeTeamName) {
                                            $urlEquipoLocal = explode("/", $equipos[$j] -> _links -> self -> href);
                                            $idEquipoLocal = end($urlEquipoLocal);
                                        }
                                        if ($equipos[$j] -> name == $resultados[$i] -> awayTeamName) {
                                            $urlEquipoVisitante = explode("/", $equipos[$j] -> _links -> self -> href);
                                            $idEquipoVisitante = end($urlEquipoVisitante);
                                        }
                                    }
                                    echo "<tr class='partido' onclick=\"document.location = 'partido.php?idPartido=$idPartido';\" style='cursor: pointer;'>";
                                        echo "<td class='nombre-local'>" . "<a href='equipo.php?idEquipo=$idEquipoLocal'>" . $nombreLocal . "</a>" . "</td>";
                                        if ($estadoPartido == "TIMED" || $estadoPartido == "SCHEDULED") {
                                            if (date("d/m") == $diaPartido) {
                                                echo "<td class='goles'>" . $horaPartido . "</td>";
                                            }
                                            else {
                                                echo "<td class='goles'>" . $diaPartido . "</td>";
                                            }                             
                                        }
                                        if ($estadoPartido == "IN_PLAY") {
                                            echo "<td class='goles' style='color: red;'>" . $golesLocal . " - " . $golesVisitante . "</td>";
                                        }
                                        if ($estadoPartido == "FINISHED") {
                                            echo "<td class='goles'>" . $golesLocal . " - " . $golesVisitante . "</td>";
                                        }
                                        if ($estadoPartido == "POSTPONED") {
                                            echo "<td class='goles'>" . "Aplazado" . "</td>";
                                        }
                                        if ($estadoPartido == "CANCELED") {
                                            echo "<td class='goles'>" . "Cancelado" . "</td>";
                                        }
                                        echo "<td class='nombre-visitante'>" . "<a href='equipo.php?idEquipo=$idEquipoVisitante'>" . $nombreVisitante . "</a>" . "</td>";
                                    echo "</tr>";
                                }
                            echo "</table>";
                        }
                    }
                } catch(Exception $e) {
                    print_r($e->getMessage());
                }
            ?>
        </div>
    </body>
</html>
