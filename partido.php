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
        <title>Partido</title>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="js/main.js"></script>
        <link href="images/favicon.png" type="image/png" rel="icon" />
        <link href="css/estilos-menu.css" type="text/css" rel="stylesheet" />
        <link href="css/estilos-partido.css" type="text/css" rel="stylesheet" />
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
                    if (isset($_GET['idPartido'])) {
                        $idPartido = $_GET['idPartido'];
                        $api = new FootballData();
                        $hoy = date("Y-m-d");
                        $partido = $api -> getFixtureById($idPartido) -> fixture;
                        $head2head = $api -> getFixtureById($idPartido) -> head2head;
                        $estadoPartido = $partido -> status;
                        $horaActual = date("H-i-s");
                        $horaPartido = date("H:i", strtotime("+0 hour", strtotime($partido -> date)));
                        $urlCompeticion = explode("/", $partido -> _links -> competition -> href);
                        $idCompeticion = end($urlCompeticion);
                        $nombreCompeticion = $api -> getSoccerseasonById($idCompeticion) -> payload -> caption;
                        $datosOficiales = datosOficialCompeticion($nombreCompeticion);
                        $urlEquipoLocal = explode("/", $partido -> _links -> homeTeam -> href);
                        $idEquipoLocal = end($urlEquipoLocal);
                        $equipoLocal = $api -> getTeamById($idEquipoLocal);
                        $nombreLocal = $partido -> homeTeamName;
                        $escudoLocal = $equipoLocal -> _payload -> crestUrl;
                        $golesLocal = $partido -> result -> goalsHomeTeam;
                        $urlEquipoVisitante = explode("/", $partido -> _links -> awayTeam -> href);
                        $idEquipoVisitante = end($urlEquipoVisitante);
                        $equipoVisitante = $api -> getTeamById($idEquipoVisitante);
                        $nombreVisitante = $partido -> awayTeamName;
                        $escudoVisitante = $equipoVisitante -> _payload -> crestUrl;
                        $golesVisitante = $partido -> result -> goalsAwayTeam;

                        echo "<table class='tabla-resultados'>";
                        echo "<tr class='tabla-header'>";
                            echo "<td colspan='10'>" . "<img src='images/" . $datosOficiales["logoLargo"] . "'>" . "<span>" . $datosOficiales["nombreOficial"] . "<span>" . "</td>";
                        echo "</tr>";
                        echo "<tr class='tabla-caption'>";
                            echo "<td colspan=3>" . "Jornada " . $partido -> matchday . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                            echo "<td>" . "</td>";
                            if ($estadoPartido == "TIMED" || $estadoPartido == "SCHEDULED") {
                                echo "<td>" . $horaPartido . "</td>";                        
                            }
                            if ($estadoPartido == "IN_PLAY") {
                                echo "<td style='color: red; font-size: 25px;'>" . calcularMinuto($horaPartido, $horaActual) . "</td>";
                            }
                            if ($estadoPartido == "FINISHED") {
                                echo "<td>" . "Finalizado" . "</td>";
                            }
                            if ($estadoPartido == "POSTPONED") {
                                echo "<td>" . "Aplazado" . "</td>";
                            }
                            if ($estadoPartido == "CANCELED") {
                                echo "<td>" . "Cancelado" . "</td>";
                            }
                            if ($estadoPartido == "") {
                                echo "<td>" . "Desconocido" . "</td>";
                            }
                            echo "<td>" . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                            echo "<td class='escudo-local'>" . "<a href='equipo.php?idEquipo=$idEquipoLocal'>" . "<img height='100px' src='" . $escudoLocal . "' onerror='cambiarImagen(\"" . $nombreLocal . "\")' class='" . $nombreLocal . "'>" . "</a>" . "</td>";
                                echo "<td class='goles'>" . $golesLocal . " - " . $golesVisitante . "</td>";
                           echo "<td class='escudo-visitante'>" . "<a href='equipo.php?idEquipo=$idEquipoVisitante'>" . "<img height='100px' src='" . $escudoVisitante . "' onerror='cambiarImagen(\"" . $nombreVisitante . "\")' class='" . $nombreVisitante . "'>" . "</a>" . "</td>";
                        echo "</tr>";
                        echo "<tr>";
                            echo "<td>" . $nombreLocal . "</td>";
                            echo "<td>" . "</td>";
                            echo "<td>" . $nombreVisitante . "</td>";
                        echo "</tr>";

                        if (!empty($partido -> odds)) {
                            echo "<table class='tabla-apuestas'>";
                                echo "<tr class='tabla-caption'>";
                                    echo "<td colspan='3'>" . "Apuestas" . "</td>";
                                echo "</tr>";
                                echo "<tr class='tabla-datos'>";
                                    echo "<td>" . "1" . "</td>";
                                    echo "<td>" . "X" . "</td>";
                                    echo "<td>" . "2" . "</td>";
                                echo "</tr>";
                                echo "<tr>";
                                    echo "<td>" . $partido -> odds -> homeWin . "</td>";
                                    echo "<td>" . $partido -> odds -> draw . "</td>";
                                    echo "<td>" . $partido -> odds -> awayWin . "</td>";
                                echo "</tr>";
                            echo "</table>";
                        }

                        if (!empty($head2head)) {
                            echo "<table class='tabla-partidos'>";
                                echo "<tr class='tabla-caption'>";
                                    echo "<td colspan='6'>" . "Anteriores enfrentamientos" . "</td>";
                                echo "</tr>";
                                for ($i = 0; $i < $head2head -> count; $i++) {
                                    $H2HurlPartido = explode("/", $head2head -> fixtures[$i] -> _links -> self -> href);;
                                    $H2HidPartido = end($H2HurlPartido);
                                    $H2HdiaPartido = date("d/m/y", strtotime("+0 hour", strtotime($head2head -> fixtures[$i] -> date)));
                                    $H2HnombreLocal = $head2head -> fixtures[$i] -> homeTeamName;
                                    $H2HnombreVisitante = $head2head -> fixtures[$i] -> awayTeamName;
                                    $H2HgolesLocal = $head2head -> fixtures[$i] -> result -> goalsHomeTeam;
                                    $H2HgolesVisitante = $head2head -> fixtures[$i] -> result -> goalsAwayTeam;
                                    if ($H2HnombreLocal == $nombreLocal) {
                                        $H2HescudoLocal = $escudoLocal;
                                    }
                                    if ($H2HnombreLocal == $nombreVisitante) {
                                        $H2HescudoLocal = $escudoVisitante;
                                    }
                                    if ($H2HnombreVisitante == $nombreLocal) {
                                        $H2HescudoVisitante = $escudoLocal;
                                    }
                                    if ($H2HnombreVisitante == $nombreVisitante) {
                                        $H2HescudoVisitante = $escudoVisitante;
                                    }
                                    echo "<tr class='partido'>";
                                        echo "<td class='h2h-goles'>" . $H2HdiaPartido . "</td>";
                                        echo "<td class='h2h-nombre-local'>" . $H2HnombreLocal . "</td>";
                                        echo "<td class='h2h-escudo-local'>" . "<img height='20px' src='" . $H2HescudoLocal . "' onerror='cambiarImagen(\"" . $H2HnombreLocal . "\")' class='" . $H2HnombreLocal . "'>" . "</td>";
                                        echo "<td class='h2h-goles'>" . $H2HgolesLocal . " - " . $H2HgolesVisitante . "</td>";
                                        echo "<td class='h2h-escudo-visitante'>" . "<img height='20px' src='" . $H2HescudoVisitante . "' onerror='cambiarImagen(\"" . $H2HnombreVisitante . "\")' class='" . $H2HnombreVisitante . "'>" . "</td>";
                                        echo "<td class='h2h-nombre-visitante'>" . $H2HnombreVisitante . "</td>";
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
