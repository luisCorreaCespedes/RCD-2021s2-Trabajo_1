<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FuncionesRest extends Controller
{
    public function rut(Request $request) {
        // Caso 0: Rut inválido
        // Caso 1: Rut Válido
        // Caso 2: Rut Inválido
            $gets = $request->json()->all();
            $rut = $gets['rut'];
            $dv = $gets['dv'];
            $digito;
            $validador;
            $rut = str_replace('.', '', $rut);
            if (strlen($rut) < 7 || strlen($rut) > 8) {
                return 0;
            } else {
                $arr = strrev($rut);
                $arr = str_split($arr);
                $serie = 2;
                $suma = 0;
                $c = 0;
                while ($c < 8) {
                    if ($serie <= 7) {
                        $suma+=$arr[$c]*$serie;
                        $serie++;
                    } else {
                        $serie = 2;
                        $suma+=$arr[$c]*$serie;
                        $serie++;
                    }
                    $c++;
                }
                $suma %=11;
                $suma=11-$suma;
                if ($suma == 10) {
                    $digito = 10;
                } else if ($suma == 11) {
                    $digito = 11;
                } else if ($suma < 10) {
                   $digito = $suma;
                }
            }

            if ($digito == $dv) return 1;
            else if ($digito != $dv) return 2;
            else return 0;
    }
}
