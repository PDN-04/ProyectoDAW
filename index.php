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
        <title>Inicio</title>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="js/main.js"></script>
        <link href="images/favicon.png" type="image/png" rel="icon" />
        <link href="css/estilos-menu.css" type="text/css" rel="stylesheet" />
        <link href="css/estilos-inicio.css" type="text/css" rel="stylesheet" />
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
                    $api = new FootballData();
                    $hoy = "2017-05-21";
                    $horaActual = date("H:i:s");
                    $competiciones = ['426', '430', '434', '436', '438', '439'];
                    echo "<table class='tabla-resultados'>";
                        foreach ($competiciones as $idCompeticion) {
                            $competicion = $api -> getSoccerseasonById($idCompeticion);
                            $datosOficiales = datosOficialCompeticion($competicion -> payload -> caption);
                            $partidos = $competicion -> getFixturesForDateRange($hoy,$hoy);
                            $nPartidos = count($partidos);
                            $equipos = $competicion -> getTeams();
                            $nEquipos = count($equipos);
                            if ($nPartidos > 0) {
                                echo "<tr class='tabla-caption'>";
                                    echo "<td colspan='10'>" . "<img src='images/" . $datosOficiales["logoLargo"] . "'>" . "<a href='clasificacion.php?idCompeticion=$idCompeticion'>" . $datosOficiales["nombreOficial"] . "</a>" . "</td>";
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
                                            $escudoLocal = $equipos[$j] -> crestUrl;
                                        }
                                        if ($equipos[$j] -> name == $partidos[$i] -> awayTeamName) {
                                            $urlEquipoVisitante = explode("/", $equipos[$j] -> _links -> self -> href);
                                            $idEquipoVisitante = end($urlEquipoVisitante);
                                            $escudoVisitante = $equipos[$j] -> crestUrl;
                                            
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
                                        if ($estadoPartido == "CANCELED") {
                                            echo "<td class='goles'>" . "Cancelado" . "</td>";
                                        }
                                        if ($estadoPartido == "") {
                                            echo "<td class='goles'>" . "Desconocido" . "</td>";
                                        }
                                        echo "<td class='nombre-local'>" . "<a href='equipo.php?idEquipo=$idEquipoLocal'>" . $nombreLocal . "</a>" . "</td>";
                                        echo "<td class='escudo-local'>" . "<a href='equipo.php?idEquipo=$idEquipoLocal'>" . "<img height='20px' src='" . $escudoLocal . "' onerror='cambiarImagen(\"" . $nombreLocal . "\")' class='" . $nombreLocal . "'>" . "</a>" . "</td>";
                                        if ($estadoPartido == "TIMED" || $estadoPartido == "SCHEDULED" || $estadoPartido == "POSTPONED" || $estadoPartido == "CANCELED") {
                                            echo "<td class='goles'>" . " - " . "</td>";
                                        }
                                        if ($estadoPartido == "IN_PLAY") {
                                            echo "<td class='goles' style='color: red;'>" . $golesLocal . " - " . $golesVisitante . "</td>";
                                        }
                                        if ($estadoPartido == "FINISHED") {
                                            echo "<td class='goles'>" . $golesLocal . " - " . $golesVisitante . "</td>";
                                        }
                                        if ($estadoPartido == "") {
                                            echo "<td class='goles'>" . "¿¿??" . "</td>";
                                        }
                                        echo "<td class='escudo-visitante'>" . "<a href='equipo.php?idEquipo=$idEquipoVisitante'>" . "<img height='20px' src='" . $escudoVisitante . "' onerror='cambiarImagen(\"" . $nombreVisitante . "\")' class='" . $nombreVisitante . "'>" . "</a>" . "</td>";
                                        echo "<td class='nombre-visitante'>" . "<a href='equipo.php?idEquipo=$idEquipoVisitante'>" . $nombreVisitante . "</a>" . "</td>";
                                    echo "</tr>";
                                }
                            }   
                        }
                    echo "</table>";
                } catch(Exception $excepcion) {
                    header("Location: error.php");
                }
            ?>
        </div>
    </body>
</html>
