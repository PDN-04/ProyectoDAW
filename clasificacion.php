<?php
    include 'FootballData.php';
    include 'functions.php';

    set_error_handler("my_warning_handler", E_ALL);
    function my_warning_handler($errno, $errstr, $errfile, $errline, $errcontext) {
        throw new Exception($errstr);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Clasificación</title>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="js/main.js"></script>
        <link href="images/favicon.png" type="image/png" rel="icon" />
        <link href="css/estilos-menu.css" type="text/css" rel="stylesheet" />
        <link href="css/estilos-clasificacion.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
                <header class="menu">
            <div class="logo-cabecera">
                <a href="index.php"><img src="images/Logo.png"></a>
            </div>
            <div class="menu-cabecera">
                <div class="enlace" onclick="document.location = 'clasificacion.php?idCompeticion=436'">
                  <div class="icono-liga">
                      <img src="images/LaLiga-logoLarge.png" alt="">
                  </div>
                  <span>LaLiga</span>
                </div>
                <div class="enlace" onclick="document.location = 'clasificacion.php?idCompeticion=426'">
                  <div class="icono-liga">
                      <img src="images/PremierLeague-logoLarge.png" alt="">
                  </div>
                  <span>Premier League</span>
                </div>
                <div class="enlace" onclick="document.location = 'clasificacion.php?idCompeticion=438'">
                  <div class="icono-liga">
                      <img src="images/SerieA-logoLarge.png" alt="">
                  </div>
                  <span>Serie A</span>
                </div>
                <div class="enlace" onclick="document.location = 'clasificacion.php?idCompeticion=430'">
                  <div class="icono-liga">
                      <img src="images/Bundesliga-logoLarge.png" alt="">
                  </div>
                  <span>Bundesliga</span>
                </div>
                <div class="enlace" onclick="document.location = 'clasificacion.php?idCompeticion=434'">
                  <div class="icono-liga">
                      <img src="images/Ligue1-logoLarge.png" alt="">
                  </div>
                  <span>Ligue 1</span>
                </div>
                <div class="enlace" onclick="document.location = 'clasificacion.php?idCompeticion=439'">
                  <div class="icono-liga">
                      <img src="images/LigaNOS-logoLarge.png" alt="">
                  </div>
                  <span>Liga NOS</span>
                </div>
            </div>
        </header>
        <header class="menu-responsive">
            <div class="logo-cabecera-responsive">
                <a href="index.php"><img src="images/Logo.png"></a>
            </div>
            <div class="boton">
                  <img src="images/menu.png" alt="">
            </div>
            <div class="menu-cabecera-responsive">
                <div class="enlace-responsive" onclick="document.location = 'clasificacion.php?idCompeticion=436'">
                  <div class="icono-liga-responsive">
                      <img src="images/LaLiga-logoLarge.png" alt="">
                  </div>
                  <span>LaLiga</span>
                </div>
                <div class="enlace-responsive" onclick="document.location = 'clasificacion.php?idCompeticion=426'">
                  <div class="icono-liga-responsive">
                      <img src="images/PremierLeague-logoLarge.png" alt="">
                  </div>
                  <span>Premier League</span>
                </div>
                <div class="enlace-responsive" onclick="document.location = 'clasificacion.php?idCompeticion=438'">
                  <div class="icono-liga-responsive">
                      <img src="images/SerieA-logoLarge.png" alt="">
                  </div>
                  <span>Serie A</span>
                </div>
                <div class="enlace-responsive" onclick="document.location = 'clasificacion.php?idCompeticion=430'">
                  <div class="icono-liga-responsive">
                      <img src="images/Bundesliga-logoLarge.png" alt="">
                  </div>
                  <span>Bundesliga</span>
                </div>
                <div class="enlace-responsive" onclick="document.location = 'clasificacion.php?idCompeticion=434'">
                  <div class="icono-liga-responsive">
                      <img src="images/Ligue1-logoLarge.png" alt="">
                  </div>
                  <span>Ligue 1</span>
                </div>
                <div class="enlace-responsive" onclick="document.location = 'clasificacion.php?idCompeticion=439'">
                  <div class="icono-liga-responsive">
                      <img src="images/LigaNOS-logoLarge.png" alt="">
                  </div>
                  <span>Liga NOS</span>
                </div>
            </div>
        </header>
        <div class="container">
            <?php
                try {
                    if (isset($_GET['idCompeticion'])) {
                        $idCompeticion = $_GET['idCompeticion'];
                        $api = new FootballData();
                        $competiciones = ['426', '430', '434', '436', '438', '439'];
                        if (!in_array($idCompeticion, $competiciones)) {
                          header("Location: error.php");
                        }
                        $competicion = $api -> getSoccerseasonById($idCompeticion);
                        $clasificacion = $competicion -> getLeagueTable();
                        $nombreCompeticion = $clasificacion -> leagueCaption;
                        $datosOficiales = datosOficialCompeticion($nombreCompeticion);
                        $jornada = $competicion -> payload -> currentMatchday;
                        $nEquipos = count($clasificacion -> standing);
                        $equipos = $competicion -> getTeams();

                        echo "<table class='tabla-clasificacion'>";
                            echo "<tr class='tabla-header'>";
                                echo "<td colspan='10'>" . "<img src='images/" . $datosOficiales["logoLargo"] . "'>" . "<span>" . $datosOficiales["nombreOficial"] . "<span>" . "</td>";
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
                                    echo "<td>" . "<img style='height: 20px;' src='" . $clasificacion -> standing[$i] -> crestURI . "' onerror='cambiarImagen(\"" . $clasificacion -> standing[$i] -> teamName . "\")' class='" . $clasificacion -> standing[$i] -> teamName . "'>" . "</td>";
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
                                    echo "<td colspan='5'>" . "Resultados - Jornada " . ($jornada - 1) . "</td>";
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
                                            $escudoLocal = $equipos[$j] -> crestUrl;
                                        }
                                        if ($equipos[$j] -> name == $resultados[$i] -> awayTeamName) {
                                            $urlEquipoVisitante = explode("/", $equipos[$j] -> _links -> self -> href);
                                            $idEquipoVisitante = end($urlEquipoVisitante);
                                            $escudoVisitante = $equipos[$j] -> crestUrl;
                                        }
                                    }
                                    echo "<tr class='partido' onclick=\"document.location = 'partido.php?idPartido=$idPartido';\" style='cursor: pointer;'>";
                                        echo "<td class='nombre-local'>" . "<a href='equipo.php?idEquipo=$idEquipoLocal'>" . $nombreLocal . "</a>" . "</td>";
                                        echo "<td class='escudo-local'>" . "<a href='equipo.php?idEquipo=$idEquipoLocal'>" . "<img height='20px' src='" . $escudoLocal . "' onerror='cambiarImagen(\"" . $nombreLocal . "\")' class='" . $nombreLocal . "'>" . "</a>" . "</td>";
                                        echo "<td class='goles'>" . $golesLocal . " - " . $golesVisitante . "</td>";
                                        echo "<td class='escudo-visitante'>" . "<a href='equipo.php?idEquipo=$idEquipoVisitante'>" . "<img height='20px' src='" . $escudoVisitante . "' onerror='cambiarImagen(\"" . $nombreVisitante . "\")' class='" . $nombreVisitante . "'>" . "</a>" . "</td>";
                                        echo "<td class='nombre-visitante'>" . "<a href='equipo.php?idEquipo=$idEquipoVisitante'>" . $nombreVisitante . "</a>" . "</td>";
                                    echo "</tr>";
                                }
                            echo "</table>";
                        }

                        if ($jornada <= $competicion -> payload -> numberOfMatchdays) {
                            $resultados = $competicion -> getFixturesByMatchday($jornada);
                            $nPartidos = count($resultados);

                            echo "<table class='tabla-resultados'>";
                                echo "<tr class='tabla-caption'>";
                                    echo "<td colspan='5'>" . "Próximos - Jornada " . $jornada . "</td>";
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
                                            $escudoLocal = $equipos[$j] -> crestUrl;
                                        }
                                        if ($equipos[$j] -> name == $resultados[$i] -> awayTeamName) {
                                            $urlEquipoVisitante = explode("/", $equipos[$j] -> _links -> self -> href);
                                            $idEquipoVisitante = end($urlEquipoVisitante);
                                            $escudoVisitante = $equipos[$j] -> crestUrl;
                                        }
                                    }
                                    echo "<tr class='partido' onclick=\"document.location = 'partido.php?idPartido=$idPartido';\" style='cursor: pointer;'>";
                                        echo "<td class='nombre-local'>" . "<a href='equipo.php?idEquipo=$idEquipoLocal'>" . $nombreLocal . "</a>" . "</td>";
                                        echo "<td class='escudo-local'>" . "<a href='equipo.php?idEquipo=$idEquipoLocal'>" . "<img height='20px' src='" . $escudoLocal . "' onerror='cambiarImagen(\"" . $nombreLocal . "\")' class='" . $nombreLocal . "'>" . "</a>" . "</td>";
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
                                        if ($estadoPartido == "") {
                                            echo "<td class='goles'>" . "¿¿??" . "</td>";
                                        }
                                        echo "<td class='escudo-visitante'>" . "<a href='equipo.php?idEquipo=$idEquipoVisitante'>" . "<img height='20px' src='" . $escudoVisitante . "' onerror='cambiarImagen(\"" . $nombreVisitante . "\")' class='" . $nombreVisitante . "'>" . "</a>" . "</td>";
                                        echo "<td class='nombre-visitante'>" . "<a href='equipo.php?idEquipo=$idEquipoVisitante'>" . $nombreVisitante . "</a>" . "</td>";
                                    echo "</tr>";
                                }
                            echo "</table>";
                        }
                    }
                } catch(Exception $excepcion) {
                    header("Location: error.php");
                }
            ?>
        </div>
    </body>
</html>
