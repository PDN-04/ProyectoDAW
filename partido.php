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
        <title>Partido</title>
        <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="container">
            <?php
                try {
                    if (isset($_GET['idPartido'])) {
                        $idPartido = $_GET['idPartido'];
                        $api = new FootballData();
                        $hoy = date("Y-m-d");
                        $estadoPartido = $api -> getFixtureById($idPartido) -> fixture -> status;
                        $horaActual = date("H-i-s");
                        $horaPartido = date("H:i", strtotime("+0 hour", strtotime($api -> getFixtureById($idPartido) -> fixture -> date)));
                        $urlCompeticion = explode("/", $api -> getFixtureById($idPartido) -> fixture -> _links -> competition -> href);
                        $idCompeticion = end($urlCompeticion);
                        $urlLocal = explode("/", $api -> getFixtureById($idPartido) -> fixture -> _links -> homeTeam -> href);
                        $idLocal = end($urlLocal);
                        $urlVisitante = explode("/", $api -> getFixtureById($idPartido) -> fixture -> _links -> awayTeam -> href);
                        $idVisitante = end($urlVisitante);

                        echo "<table width='100%' style='text-align: center;'>";
                        echo "<tr>";
                        echo "<td colspan=2>" . "<h1>" . $api -> getSoccerseasonById($idCompeticion) -> payload -> caption . "</h1>" . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td colspan=2>" . "Jornada " . $api -> getFixtureById($idPartido) -> fixture -> matchday . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        if ($estadoPartido == "TIMED") {
                            echo "<td colspan=2>" . "<h2>" . $horaPartido . "</h2>" . "</td>";
                        }
                        if ($estadoPartido == "IN_PLAY") {
                            echo "<td colspan=2>" . "<h2 style='color: red'>" . calcularMinuto($horaPartido, $horaActual) . "</h2>" . "</td>";
                        }
                        if ($estadoPartido == "FINISHED") {
                            echo "<td colspan=2>" . "<h2>" . "Finalizado" . "</h2>" . "</td>";
                        }
                        if ($estadoPartido == "POSTPONED") {
                            echo "<td colspan=2>" . "<h2>" . "Aplazado" . "</h2>" . "</td>";
                        }
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td>" . "<img src='" . $api -> getTeamById($idLocal) -> _payload -> crestUrl . "' style='height: 50px'>" . "</td>";
                        echo "<td>" . "<img src='" . $api -> getTeamById($idVisitante) -> _payload -> crestUrl . "' style='height: 50px'>" . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td>" . $api -> getFixtureById($idPartido) -> fixture -> homeTeamName . "</td>";
                        echo "<td>" . $api -> getFixtureById($idPartido) -> fixture -> awayTeamName . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td>" . "<h1>" . $api -> getFixtureById($idPartido) -> fixture -> result -> goalsHomeTeam . "</h1>" . "</td>";
                        echo "<td>" . "<h1>" . $api -> getFixtureById($idPartido) -> fixture -> result -> goalsAwayTeam . "</h1>" . "</td>";
                        echo "</tr>";
                        echo "</table>";

                        if (!empty($api -> getFixtureById($idPartido) -> fixture -> odds)) {
                            echo "<table width='100%' style='text-align: center;'>";
                            echo "<tr>";
                            echo "<td>" . "1" . "</td>";
                            echo "<td>" . "X" . "</td>";
                            echo "<td>" . "2" . "</td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td>" . $api -> getFixtureById($idPartido) -> fixture -> odds -> homeWin . "</td>";
                            echo "<td>" . $api -> getFixtureById($idPartido) -> fixture -> odds -> draw . "</td>";
                            echo "<td>" . $api -> getFixtureById($idPartido) -> fixture -> odds -> awayWin . "</td>";
                            echo "</tr>";
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
