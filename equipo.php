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
        <title>Equipo</title>
        <link href="css/estilos-equipo.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div class="container">
            <?php
                try {
                    if (isset($_GET['idEquipo'])) {
                        $idEquipo = $_GET['idEquipo'];
                        $api = new FootballData();
                        $equipo = $api -> getTeamById($idEquipo);
                        $escudo = $equipo -> _payload -> crestUrl;
                        $nombre = $equipo -> _payload -> name;
                        $nombreCorto = $equipo -> _payload -> shortName;
                        $iniciales = $equipo -> _payload -> code;
                        $valorPlantilla = $equipo -> _payload -> squadMarketValue;
                        $jugadores = $equipo -> getPlayers();
                        $nJugadores = count($jugadores);

                        echo "<table class='tabla-equipo'>";
                            echo "<tr>";
                                echo "<td class='nombre-equipo'>" . $nombre . "</td>";
                                echo "<td>" . "<img src='$escudo'>" . "</td>";
                                if (is_null($valorPlantilla)) {
                                    echo "<td class='valor-equipo'>" . "Valor plantilla" . "<br>" . "¿?" . "</td>";
                                }
                                else {
                                    echo "<td class='valor-equipo'>" . "Valor plantilla" . "<br>" . $valorPlantilla . "</td>";
                                }
                            echo "</tr>";
                        echo "</table>";

                        echo "<h1>" . "Plantilla" . "</h1>";
                        echo "<table class='tabla-plantilla'>";
                        $contador = 0;
                        for ($i = 0; $i < $nJugadores; $i++) {
                            if ($contador == 0) {
                                echo "<tr>";
                                    echo "<td class='tabla-jugador'>";
                                        echo "<div class='dorsal-jugador'>";
                                            if (is_null($jugadores[$i] -> jerseyNumber)) {
                                                echo "<span>" . "¿?" . "</span>";
                                            }
                                            else {
                                                echo "<span>" . $jugadores[$i] -> jerseyNumber . "</span>";
                                            }
                                        echo "</div>";
                                        echo "<div class='info-jugador'>";
                                            echo "<span class='nombre-jugador'>" . $jugadores[$i] -> name . "</span>";
                                            echo "<span>" . "Posición: " . traducirPosicion($jugadores[$i] -> position) . "</span>";
                                            echo "<span>" . "Edad: " . calcularEdad($jugadores[$i] -> dateOfBirth) . "</span>";
                                            echo "<span>" . "País: " . $jugadores[$i] -> nationality . "</span>";
                                            echo "<span>" . "Contrato hasta: " . $jugadores[$i] -> contractUntil . "</span>";
                                            echo "<span>" . "Valor: " . $jugadores[$i] -> marketValue . "</span>";
                                        echo "</div>";
                                    echo "</td>";
                                    $contador++;
                            }
                            else {
                                if ($contador == 2) {
                                        echo "<td class='tabla-jugador'>";
                                        echo "<div class='dorsal-jugador'>";
                                            if (is_null($jugadores[$i] -> jerseyNumber)) {
                                                echo "<span>" . "¿?" . "</span>";
                                            }
                                            else {
                                                echo "<span>" . $jugadores[$i] -> jerseyNumber . "</span>";
                                            }
                                        echo "</div>";
                                        echo "<div class='info-jugador'>";
                                            echo "<span class='nombre-jugador'>" . $jugadores[$i] -> name . "</span>";
                                            echo "<span>" . "Posición: " . traducirPosicion($jugadores[$i] -> position) . "</span>";
                                            echo "<span>" . "Edad: " . calcularEdad($jugadores[$i] -> dateOfBirth) . "</span>";
                                            echo "<span>" . "País: " . $jugadores[$i] -> nationality . "</span>";
                                            echo "<span>" . "Contrato hasta: " . $jugadores[$i] -> contractUntil . "</span>";
                                            echo "<span>" . "Valor: " . $jugadores[$i] -> marketValue . "</span>";
                                        echo "</div>";
                                    echo "</td>";
                                    echo "</tr>";
                                    $contador = 0;
                                }
                                else {
                                    echo "<td class='tabla-jugador'>";
                                        echo "<div class='dorsal-jugador'>";
                                            if (is_null($jugadores[$i] -> jerseyNumber)) {
                                                echo "<span>" . "¿?" . "</span>";
                                            }
                                            else {
                                                echo "<span>" . $jugadores[$i] -> jerseyNumber . "</span>";
                                            }
                                        echo "</div>";
                                        echo "<div class='info-jugador'>";
                                            echo "<span class='nombre-jugador'>" . $jugadores[$i] -> name . "</span>";
                                            echo "<span>" . "Posición: " . traducirPosicion($jugadores[$i] -> position) . "</span>";
                                            echo "<span>" . "Edad: " . calcularEdad($jugadores[$i] -> dateOfBirth) . "</span>";
                                            echo "<span>" . "País: " . $jugadores[$i] -> nationality . "</span>";
                                            echo "<span>" . "Contrato hasta: " . $jugadores[$i] -> contractUntil . "</span>";
                                            echo "<span>" . "Valor: " . $jugadores[$i] -> marketValue . "</span>";
                                        echo "</div>";
                                    echo "</td>";
                                    $contador++;
                                }
                            }  
                        }
                        echo "</table>";
                    }
                } catch(Exception $e) {
                    print_r($e->getMessage());
                }
            ?>
        </div>
    </body>
</html>
