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
        <title>Equipo</title>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="js/main.js"></script>
        <link href="images/favicon.png" type="image/png" rel="icon" />
        <link href="css/estilos-menu.css" type="text/css" rel="stylesheet" />
        <link href="css/estilos-equipo.css" type="text/css" rel="stylesheet" />
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
                    if (isset($_GET['idEquipo'])) {
                        $idEquipo = $_GET['idEquipo'];
                        $api = new FootballData();
                        $equipo = $api -> getTeamById($idEquipo);
                        $partidos = $equipo -> getFixtures();
                        $escudo = $equipo -> _payload -> crestUrl;
                        $nombre = $equipo -> _payload -> name;
                        $nombreCorto = $equipo -> _payload -> shortName;
                        $iniciales = $equipo -> _payload -> code;
                        $valorPlantilla = $equipo -> _payload -> squadMarketValue;
                        $jugadores = $equipo -> getPlayers();
                        $nJugadores = count($jugadores);
                        $racha = rachaPartidos($partidos, $nombre);
                        $ultimosPartidos = ultimosPartidos($partidos, $nombre);
                        echo "<table class='tabla-equipo'>";
                            echo "<tr class='tabla-header'>";
                                echo "<td class='escudo-equipo'>" . "<img src='$escudo' onerror='cambiarImagen(\"" . $nombre . "\")' class='" . $nombre . "'>" . "</td>";
                                echo "<td class='nombre-equipo' colspan='3'>" . $nombre . "</td>";
                            echo "</tr>";
                            echo "<tr class='tabla-caption'>";
                                echo "<td colspan='4'>" . "Información" . "</td>";
                            echo "</tr>";
                            echo "<tr class='nombre-equipo'>";
                                echo "<td>" . "Nombre del equipo" . "</td>";
                                echo "<td>" . $nombre . "</td>";
                                echo "<td>" . "Nombre corto" . "</td>";
                                echo "<td>" . $iniciales . "</td>";
                            echo "</tr>";
                            echo "<tr class='valor-equipo'>";
                                echo "<td>" . "Nº Jugadores" . "</td>";
                                if ($nJugadores != 0) {
                                    echo "<td>" . $nJugadores . "</td>";
                                }
                                else {
                                    echo "<td>" . "Desconocido" . "</td>";
                                }
                                echo "<td>" . "Racha" . "</td>";
                                echo "<td>";
                                    for ($i = 0; $i < count($racha); $i++) {
                                        if ($racha[$i] == "V") {
                                            echo "<span class='victoria'>" . $racha[$i] . "</span>";
                                        }
                                        if ($racha[$i] == "E") {
                                            echo "<span class='empate'>" . $racha[$i] . "</span>";
                                        }
                                        if ($racha[$i] == "D") {
                                            echo "<span class='derrota'>" . $racha[$i] . "</span>";
                                        }
                                    }
                                echo "</td>";
                            echo "</tr>";
                        echo "</table>";
                        if ($nJugadores > 0) {
                            echo "<table class='tabla-plantilla'>";
                                echo "<tr class='tabla-caption'>";
                                    echo "<td colspan='5'>" . "Plantilla" . "</td>";
                                echo "</tr>";
                                echo "<tr class='tabla-datos'>";
                                    echo "<td>" . "Posición" . "</td>";
                                    echo "<td colspan='2'>" . "Jugador" . "</td>";
                                    echo "<td>" . "Edad" . "</td>";
                                    echo "<td>" . "Origen" . "</td>";
                                echo "</tr>";
                                for ($i = 0; $i < $nJugadores; $i++) {
                                    $datos = traducirPosicion($jugadores[$i] -> position);
                                    echo "<tr class='jugador'>";
                                        echo "<td class='" . $datos["color"] . "'>" . $datos["posicion"] . "</td>";
                                        echo "<td>" . $jugadores[$i] -> jerseyNumber . "</td>";
                                        echo "<td>" . $jugadores[$i] -> name . "</td>";
                                        echo "<td>" . calcularEdad($jugadores[$i] -> dateOfBirth) . "</td>";
                                        echo "<td>" . $jugadores[$i] -> nationality . "</td>";
                                    echo "</tr>";
                                }
                            echo "</table>";
                        }
                        else {
                            echo "<table class='tabla-plantilla'>";
                                echo "<tr class='tabla-caption'>";
                                    echo "<td colspan='5'>" . "Plantilla" . "</td>";
                                echo "</tr>";
                                echo "<tr class='tabla-datos'>";
                                    echo "<td>" . "No hay datos sobre la plantilla del " . $nombre . "</td>";
                                echo "</tr>";
                            echo "</table>";
                        }
                        echo "<table class='tabla-resultados'>";
                                echo "<tr class='tabla-caption'>";
                                    echo "<td colspan='5'>" . "Últimos partidos" . "</td>";
                                echo "</tr>";
                                for ($i = 0; $i < count($ultimosPartidos); $i++) {
                                    $urlPartido = explode("/", $ultimosPartidos[$i] -> _links -> self -> href);;
                                    $idPartido = end($urlPartido);
                                    $nombreLocal = $ultimosPartidos[$i] -> homeTeamName;
                                    $nombreVisitante = $ultimosPartidos[$i] -> awayTeamName;
                                    $golesLocal = $ultimosPartidos[$i] -> result -> goalsHomeTeam;
                                    $golesVisitante = $ultimosPartidos[$i] -> result -> goalsAwayTeam;
                                    $urlEquipoLocal = explode("/", $ultimosPartidos[$i] -> _links -> homeTeam -> href);
                                    $idEquipoLocal = end($urlEquipoLocal);
                                    $urlEquipoVisitante = explode("/", $ultimosPartidos[$i] -> _links -> awayTeam -> href);
                                    $idEquipoVisitante = end($urlEquipoVisitante);
                                    $urlCompeticion = explode("/", $ultimosPartidos[$i] -> _links -> competition -> href);
                                    $idCompeticion = end($urlCompeticion);
                                    $competicion = $api -> getSoccerseasonById($idCompeticion);
                                    $equipos = $competicion -> getTeams();
                                    $nEquipos = count($equipos);
                                    for ($j = 0; $j < $nEquipos; $j++) {
                                        if ($equipos[$j] -> name == $nombreLocal) {
                                            $escudoLocal = $equipos[$j] -> crestUrl;
                                        }
                                        if ($equipos[$j] -> name == $nombreVisitante) {
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
                } catch(Exception $excepcion) {
                    header("Location: error.php");
                }
            ?>
        </div>
    </body>
</html>
