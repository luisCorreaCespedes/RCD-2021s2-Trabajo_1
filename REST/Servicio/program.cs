using System;
using System.Net;
using System.Linq;
using System.Text;


//
public static string Digito(int rut) {
        int suma = 0;
        int multiplicador = 1;
        while (rut != 0) {
            multiplicador++;
            if (multiplicador == 8)
            multiplicador = 2;
            suma += (rut % 10) * multiplicador;
            rut = rut / 10;
        }
        suma = 11 - (suma % 11);
        if (suma == 11)    {
            return "0";
        } else if (suma == 10) {
            return "K";
        } else {
            return suma.ToString();
        }
}