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
	switch ($posicionIngles) {
	    case "Keeper":
	        $posicion = "POR";
	        break;
	    case "Centre Back":
	        $posicion = "DFC";
	        break;
	    case "Left-Back":
	        $posicion = "LI";
	        break;
	    case "Right-Back":
	        $posicion = "LD";
	        break;
	    case "Defensive Midfield":
	        $posicion = "CMD";
	        break;
	    case "Central Midfield":
	        $posicion = "CM";
	        break;
	    case "Offensive Midfield":
	        $posicion = "CAM";
	        break;
	    case "Left Wing":
	        $posicion = "LW";
	        break;
	    case "Right Wing":
	        $posicion = "RW";
	        break;
	    case "Secondary Striker":
	        $posicion = "SS";
	        break;
	    case "Centre Forward":
	        $posicion = "CF";
	        break;
	}
	return $posicion;
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

function nombreOficialCompeticion($nombreCompeticion) {
	$nombreOficial = "";
	switch ($nombreCompeticion) {
		case "Premier League 2016/17":
			$nombreOficial = "Premier League";
			break;
		case "1. Bundesliga 2016/17":
			$nombreOficial = "Bundesliga";
			break;
		case "Ligue 1 2016/17":
			$nombreOficial = "Ligue 1";
			break;
		case "Primera Division 2016/17":
			$nombreOficial = "La Liga Santander";
			break;
		case "Serie A 2016/17":
			$nombreOficial = "Serie A";
			break;
		case "Primeira Liga 2016/17":
			$nombreOficial = "Liga NOS";
			break;
		case "Champions League 2016/17":
			$nombreOficial = "UEFA Champions League";
			break;
	}
	return $nombreOficial;
}
?>