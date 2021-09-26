<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FuncionesRest extends Controller
{
    public function rut(Request $request) {
        Log::info("Inicialización de la función de Digito Verificador");
        try {
            $gets = $request->json()->all();
            Log::info("Obtención de RUT y Dígito Verificador");
            $rut = $gets['rut'];
            $dv = $gets['dv'];
            $validador;
            if (strlen($rut) < 7 || strlen($rut) > 8) {
                Log::warning("El RUT es inválido");
                return 0;
            }
            else {
                Log::info("El RUT es válido");
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
                Log::info("Cálculo del Dígito Verificador en base al RUT ingresado");
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
            Log::info("Comparación del Dígito Verificador ingresado y el obtenido mediante el RUT ingresado");
            if ($validador == $dv) {
                Log::info("El Dígito Verificador es válido para el RUT ingresado");
                return 1;
            }
            else {
                Log::warning("El Dígito Verificador no es válido para el RUT ingresado");
                return 2;
            }
        } catch (\Exception $exc) {
            Log::error("Error en la función de Dígito Verificador");
            Log::error($exc->getMessage());
        }
    }

    public function nombre(Request $request) {
        Log::info("Inicialización de la función de SPLIT Nombre");
        try {
            /* Obtención de datos */
            $gets = $request->json()->all();
            Log::info("Obtención del nombre completo");
            $nombre = $gets['name'];
            $fullNombre = $nombre;
            Log::info("Limpieza de STRING ingresado con carácteres ISO-8859-1");
            $fullNombre = str_replace(
                array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ü'),
                array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '+', '-', '*'),
                $fullNombre
            );
            $respuesta = array();
            
            /* Validación */
            Log::info("Validación del nombre completo");
            $alfabeto = " ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+-*'";
            $validador = 0;
            if (strlen($fullNombre) == 0) {
                Log::warning("No hay un nombre ingresado");
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
                    Log::info("El nombre es válido");
                    $validador = 1;
                }
                else {
                    Log::warning("El nombre es inválido");
                    $validador = 2;
                }
            }
            
            /* Separación y jerarquización */
            Log::info("Separación y jerarquización del nombre");
            $nombre_explode = explode(" ", $nombre);
            $count_nombres = count($nombre_explode);
            if ($validador == 0) {
                Log::warning("Por validación, no hay un nombre ingresado");
                array_push($respuesta, 1);
            }
            else if ($validador == 1){
                if ($count_nombres <= 2) {
                    Log::warning("El nombre no es correcto, faltan datos adicionales");
                    array_push($respuesta, 1);
                }
                else {
                    Log::info("El nombre se ha jerarquizado correctamente");
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
                Log::warning("Por validación, el nombre es incorrecto");
                array_push($respuesta, 2);
            }
            Log::info("Se devuelve la respuesta de la petición de la función");
            return $respuesta;
        } catch (\Exception $exc) {
            Log::error("Error en la función de SPLIT Nombre");
            Log::error($exc->getMessage());
        }
    }
}
