<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FuncionesRest extends Controller
{
    public function rut(Request $request) {
        $gets = $request->json()->all();
        $rut = $gets['rut'];
        $dv = $gets['dv'];
        $validador;
        if (strlen($rut) < 7 || strlen($rut) > 8) {
            return 0;
        }
        else {
            $rutInvertido = strrev($rut);
            $rutInvertido = str_split($rutInvertido);
            $serie = 2;
            $sumaDigitosRut = 0;
            $contador = 0;
            while ($contador < 8) {
                if ($serie <= 7) {
                    $sumaDigitosRut += $rutInvertido[$contador] * $serie;
                    $serie++;
                } else {
                    $serie = 2;
                    $sumaDigitosRut += $rutInvertido[$contador] * $serie;
                    $serie++;
                }
                $contador++;
            }
            $sumaDigitosRut %= 11;
            $sumaDigitosRut = 11 - $sumaDigitosRut;
            switch ($sumaDigitosRut) {
                case 10: $validador = 10;
                    break;
                case 11: $validador = 11;
                    break;
                case $sumaDigitosRut < 10: $validador = $sumaDigitosRut;
                    break;
                default: $validador = $sumaDigitosRut;
            }
        }
        if ($validador == $dv) {
            return 1;
        }
        else {
            return 2;
        }
    }

    public function nombre(Request $request) {

        /* Obtención de datos */
        $gets = $request->json()->all();
        $nombre = $gets['name'];
        $fullNombre = $nombre;
        $fullNombre = str_replace(
            array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ü'),
            array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '+', '-', '*'),
            $fullNombre
        );
        $respuesta = array();
        
        /* Validación */
        $alfabeto = " ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+-*'";
        $validador = 0;
        if (strlen($fullNombre) == 0) {
            $validador = 0;
        }
        else {
            $cont = 0;
            for ($i = 0; $i < strlen($fullNombre); $i++) {
                for ($j = 0; $j < strlen($alfabeto); $j++) {
                    if ($fullNombre[$i] == $alfabeto[$j]) {
                        $cont++;
                    }
                }
            }
            if ($cont == strlen($fullNombre)) {
                $validador = 1;
            }
            else {
                $validador = 2;
            }
        }
        
        /* Separación y jerarquización */
        $nombre_explode = explode(" ", $nombre);
        $count_nombres = count($nombre_explode);
        if ($validador == 0) {
            array_push($respuesta, 1);
        }
        else if ($validador == 1){
            if ($count_nombres <= 2) {
                array_push($respuesta, 1);
            }
            else {
                $apellidos = array();
                array_push($apellidos, "Apellidos:<br>");
                array_push($apellidos, $nombre_explode[$count_nombres-2]);
                array_push($apellidos, "<br>");
                array_push($apellidos, $nombre_explode[$count_nombres-1]);
                for ($i = 0; $i < count($apellidos); $i++) {
                    $apellidos[$i] = ucfirst(strtolower($apellidos[$i]));
                }
                $nombres = array();
                array_push($nombres, "Nombres:<br>");
                for ($j = 0; $j < $count_nombres-2; $j++) {
                    array_push($nombres, $nombre_explode[$j]);
                    array_push($nombres, "<br>");
                }
                for ($k = 0; $k < count($nombres); $k++) {
                    $nombres[$k] = ucfirst(strtolower($nombres[$k]));
                }
                array_push($nombres, "<br>");
                array_push($respuesta, $nombres);
                array_push($respuesta, $apellidos);
            }
        }
        else {
            array_push($respuesta, 2);
        }
        return $respuesta;
    }
}
