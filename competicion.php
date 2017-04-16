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
        <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1><?php echo date("l, Y-m-d"); ?></h1>
            </div>
            <?php
                try {
                    $api = new FootballData();
                    $hoy = date("Y-m-d");
                    $horaActual = date("H-i-s");
                    $competiciones = ['426', '430', '434', '436', '438', '439', '440'];
                    $partidosHoy = $api -> getFixturesForDateRange($hoy,$hoy);
                    $nPartidos = $partidosHoy -> count;
                    echo "<table class='table table-striped'>";
                    for ($i = 0; $i < $nPartidos; $i++) {
                        $urlCompeticion = explode("/", $partidosHoy -> fixtures[$i] -> _links -> competition -> href);
                        $idCompeticion = end($urlCompeticion);
                        $urlPartido = explode("/", $partidosHoy -> fixtures[$i] -> _links -> self -> href);
                        $idPartido = end($urlPartido);
                        $estadoPartido = $partidosHoy -> fixtures[$i] -> status;
                        $horaPartido = date("H:i", strtotime("+0 hour", strtotime($partidosHoy -> fixtures[$i] -> date)));
                        $nombreLocal = $partidosHoy -> fixtures[$i] -> homeTeamName;
                        $nombreVisitante = $partidosHoy -> fixtures[$i] -> awayTeamName;
                        $golesLocal = $partidosHoy -> fixtures[$i] -> result -> goalsHomeTeam;
                        $golesVisitante = $partidosHoy -> fixtures[$i] -> result -> goalsAwayTeam;
                        if (in_array($idCompeticion, $competiciones)) {
                            echo "<tr onclick=\"document.location = 'partido.php?idPartido=$idPartido';\">";
                            if ($estadoPartido == "TIMED") {
                                echo "<td>" . $horaPartido . "</td>";
                            }
                            if ($estadoPartido == "IN_PLAY") {
                                echo "<td style='color: red;'>" . calcularMinuto($horaPartido, $horaActual) . "</td>";
                            }
                            if ($estadoPartido == "FINISHED") {
                                echo "<td>" . "Finalizado" . "</td>";
                            }
                            if ($estadoPartido == "POSTPONED") {
                                echo "<td>" . "Aplazado" . "</td>";
                            }
                            echo "<td>" . $nombreLocal . "</td>";
                            if ($estadoPartido == "TIMED") {
                                echo "<td>" . "-" . "</td>";
                            }
                            if ($estadoPartido == "IN_PLAY") {
                                echo "<td style='color: red;'>" . $golesLocal . " - " . $golesVisitante . "</td>";
                            }
                            if ($estadoPartido == "FINISHED") {
                                echo "<td>" . $golesLocal . " - " . $golesVisitante . "</td>";
                            }
                            if ($estadoPartido == "POSTPONED") {
                                echo "<td>" . "-" . "</td>";
                            }
                            echo "<td>" . $nombreVisitante . "</td>";
                            echo "</tr>";
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
