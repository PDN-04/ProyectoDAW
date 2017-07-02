<?php
function calcularMinuto($horaInicio, $horaActual) {
	$minutoActual = 0;

	$hInicio = substr($horaInicio, 0, 2);
	$mInicio = substr($horaInicio, 3, 2);
	$sInicio = substr($horaInicio, 6, 2);
 
	$hActual = substr($horaActual, 0, 2);
	$mActual = substr($horaActual, 3, 2);
	$sActual = substr($horaActual, 6, 2);
 
	$inicio = ((($hInicio * 60) * 60) + ($mInicio * 60) + $sInicio);
	$fin = ((($hActual * 60) * 60) + ($mActual * 60) + $sActual);
 
	$diferencia = $fin - $inicio;
 
	$hDiferencia = floor($diferencia / 3600);
	$mDiferencia = floor(($diferencia - ($hDiferencia * 3600)) / 60);
	$sDiferencia = $diferencia - ($mDiferencia * 60) - ($hDiferencia * 3600);

	list($horas, $minutos, $segundos) = explode(':', date("H:i:s", mktime($hDiferencia, $mDiferencia, $sDiferencia)));
	$horaEnMinutos = ($horas * 60) + $minutos;
	if ($horaEnMinutos <= 47) {
		$minutoActual = $horaEnMinutos . "'";
	}
	if ($horaEnMinutos > 47 && $horaEnMinutos < 62) {
		$minutoActual = "Descanso";
	}
	if ($horaEnMinutos >= 62) {
		$minutoActual = ($horaEnMinutos - 17) . "'";
	}
	return $minutoActual; 
}
function traducirPosicion($posicionIngles) {
	$posicion = "";
	$color = "";
	$datos = [];
	switch ($posicionIngles) {
	    case "Keeper":
	        $posicion = "POR";
	        $color = "portero";
	        break;
	    case "Centre-Back":
	        $posicion = "DFC";
	        $color = "defensa";
	        break;
	    case "Left-Back":
	        $posicion = "LI";
	        $color = "defensa";
	        break;
	    case "Right-Back":
	        $posicion = "LD";
	        $color = "defensa";
	        break;
	    case "Defensive Midfield":
	        $posicion = "CMD";
	        $color = "medio";
	        break;
	    case "Central Midfield":
	        $posicion = "CM";
	        $color = "medio";
	        break;
	    case "Offensive Midfield":
	        $posicion = "CAM";
	        $color = "medio";
	        break;
	    case "Left Midfield":
	    	$posicion = "MI";
	        $color = "medio";
	        break;
	    case "Right Midfield":
	    	$posicion = "MD";
	        $color = "medio";
	        break;
	    case "Attacking Midfield":
	        $posicion = "CAM";
	        $color = "medio";
	        break;
	    case "Left Wing":
	        $posicion = "EI";
	        $color = "delantero";
	        break;
	    case "Right Wing":
	        $posicion = "ED";
	        $color = "delantero";
	        break;
	    case "Secondary Striker":
	        $posicion = "SD";
	        $color = "delantero";
	        break;
	    case "Centre-Forward":
	        $posicion = "DC";
	        $color = "delantero";
	        break;
	}
	$datos = [
	    "posicion" => $posicion,
	    "color" => $color,
	];
	return $datos;
}
function calcularEdad($fecha) {
	$dias = explode("-", $fecha, 3);
	$dias = mktime(0, 0, 0, $dias[1], $dias[2] , $dias[0]);
	$edad = (int)((time() - $dias) / 31556926);
	return $edad;
}
function calcularColor($competicion, $posicion) {
	$color = "";
	switch ($competicion) {
		case 426:
			switch ($posicion) {
				case 1:
				case 2:
				case 3:
				case 4:
					$color = "champions-league";
					break;
				case 5:
					$color = "europa-league";
					break;
				case 18:
				case 19:
				case 20:
					$color = "descenso";
					break;
				default:
					$color = "default";
					break;
			}
			break;
		case 430:
			switch ($posicion) {
				case 1:
				case 2:
				case 3:
				case 4:
					$color = "champions-league";
					break;
				case 5:
				case 6:
					$color = "europa-league";
					break;
				case 16:
				case 17:
				case 18:
					$color = "descenso";
					break;
				default:
					$color = "default";
					break;
			}
			break;
		case 434:
			switch ($posicion) {
				case 1:
				case 2:
				case 3:
					$color = "champions-league";
					break;
				case 4:
					$color = "europa-league";
					break;
				case 18:
				case 19:
				case 20:
					$color = "descenso";
					break;
				default:
					$color = "default";
					break;
			}
			break;
		case 436:
			switch ($posicion) {
				case 1:
				case 2:
				case 3:
				case 4:
					$color = "champions-league";
					break;
				case 5:
				case 6:
					$color = "europa-league";
					break;
				case 18:
				case 19:
				case 20:
					$color = "descenso";
					break;
				default:
					$color = "default";
					break;
			}
			break;
		case 438:
			switch ($posicion) {
				case 1:
				case 2:
				case 3:
					$color = "champions-league";
					break;
				case 4:
				case 5:
					$color = "europa-league";
					break;
				case 18:
				case 19:
				case 20:
					$color = "descenso";
					break;
				default:
					$color = "default";
					break;
			}
			break;
		case 439:
			switch ($posicion) {
				case 1:
				case 2:
				case 3:
					$color = "champions-league";
					break;
				case 4:
				case 5:
					$color = "europa-league";
					break;
				case 17:
				case 18:
					$color = "descenso";
					break;
				default:
					$color = "default";
					break;
			}
			break;
	}

	
	return $color;
}

function datosOficialCompeticion($nombreCompeticion) {
	$nombreOficial = "";
	$logo = "";
	$logoLargo = "";
	switch ($nombreCompeticion) {
		case "Premier League 2016/17":
			$nombreOficial = "Premier League";
			$logo = "PremierLeague-logo.png";
			$logoLargo = "PremierLeague-logoLarge.png";
			break;
		case "1. Bundesliga 2016/17":
			$nombreOficial = "Bundesliga";
			$logo = "Bundesliga-logo.png";
			$logoLargo = "Bundesliga-logoLarge.png";
			break;
		case "Ligue 1 2016/17":
			$nombreOficial = "Ligue 1";
			$logo = "Ligue1-logo.png";
			$logoLargo = "Ligue1-logoLarge.png";
			break;
		case "Primera Division 2016/17":
			$nombreOficial = "LaLiga";
			$logo = "LaLiga-logo.png";
			$logoLargo = "LaLiga-logoLarge.png";
			break;
		case "Serie A 2016/17":
			$nombreOficial = "Serie A";
			$logo = "SerieA-logo.png";
			$logoLargo = "SerieA-logoLarge.png";
			break;
		case "Primeira Liga 2016/17":
			$nombreOficial = "Liga NOS";
			$logo = "LigaNOS-logo.png";
			$logoLargo = "LigaNOS-logoLarge.png";
			break;
		case "Champions League 2016/17":
			$nombreOficial = "UEFA Champions League";
			$logo = "ChampionsLeague-logo.png";
			$logoLargo = "ChampionsLeague-logoLarge.png";
			break;
		default:
			$nombreOficial = "Competición desconocida";
			$logo = "error.svg";
			$logoLargo = "error.svg";
			break;
	}
	$datos = [
	    "nombreOficial" => $nombreOficial,
	    "logo" => $logo,
	    "logoLargo" => $logoLargo
	];
	return $datos;
}

function rachaPartidos($partidos, $nombre) {
	$partidosJugados = [];
	$racha = [];
    for ($i = 0; $i < $partidos -> count; $i++) {
        if ($partidos -> fixtures[$i] -> status == "FINISHED") {
            if ($partidos -> fixtures[$i] -> homeTeamName == $nombre) {
                if ($partidos -> fixtures[$i] -> result -> goalsHomeTeam > $partidos -> fixtures[$i] -> result -> goalsAwayTeam) {
                    array_push($partidosJugados, "V");
                }
                if ($partidos -> fixtures[$i] -> result -> goalsHomeTeam < $partidos -> fixtures[$i] -> result -> goalsAwayTeam) {
                    array_push($partidosJugados, "D");
                }
                if ($partidos -> fixtures[$i] -> result -> goalsHomeTeam == $partidos -> fixtures[$i] -> result -> goalsAwayTeam) {
                    array_push($partidosJugados, "E");
                }
            }
            if ($partidos -> fixtures[$i] -> awayTeamName == $nombre) {
                if ($partidos -> fixtures[$i] -> result -> goalsHomeTeam > $partidos -> fixtures[$i] -> result -> goalsAwayTeam) {
                    array_push($partidosJugados, "D");
                }
                if ($partidos -> fixtures[$i] -> result -> goalsHomeTeam < $partidos -> fixtures[$i] -> result -> goalsAwayTeam) {
                    array_push($partidosJugados, "V");
                }
                if ($partidos -> fixtures[$i] -> result -> goalsHomeTeam == $partidos -> fixtures[$i] -> result -> goalsAwayTeam) {
                    array_push($partidosJugados, "E");
                }
            }
        }
    }
    for ($i = (count($partidosJugados) - 1); $i > (count($partidosJugados) - 6); $i--) {
        array_push($racha, $partidosJugados[$i]);
    }
    return $racha;
}

function ultimosPartidos($partidos, $nombre) {
	$partidosJugados = [];
	$ultimosPartidosJugados = [];
    for ($i = 0; $i < $partidos -> count; $i++) {
        if ($partidos -> fixtures[$i] -> status == "FINISHED") {
        	array_push($partidosJugados, $partidos -> fixtures[$i]);
        }
    }
    for ($i = (count($partidosJugados) - 1); $i > (count($partidosJugados) - 6); $i--) {
        array_push($ultimosPartidosJugados, $partidosJugados[$i]);
    }
    return $ultimosPartidosJugados;
}
?>