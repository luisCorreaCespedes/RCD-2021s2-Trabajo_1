/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package ws;

import javax.jws.WebService;
import javax.jws.WebMethod;
import javax.jws.WebParam;

/**
 *
 * @author luisc
 */
@WebService(serviceName = "Funciones")
public class Funciones {

    /**
     * This is a sample web service operation
     */
    @WebMethod(operationName = "validador")
    public String validador(@WebParam(name = "rut") int rut, @WebParam(name = "dv") String dv) {
        String aux = Integer.toString(rut);
        if (aux == null) return "Rut inválido";
        if (aux.length() < 7 || aux.length() > 8) return "Rut inválido";
        if (dv == null) return "Rut inválido";
        
        int digito,suma,resto,resultado,factor;
        dv = dv.toLowerCase();
        String dig;
        // Extraer dígito por dígito del rut
        for(factor = 2, suma = 0; rut > 0; factor++){
            digito = rut % 10;
            rut /= 10;
            suma += digito * factor;
            if(factor >= 7) factor = 1; // Para volver al ciclo
        }
        // Algoritmo del módulo 11
        resto = suma % 11;
        resultado = 11 - resto;
        if(resultado < 10) dig = Integer.toString(resultado);
        else if (resultado == 10) dig = "k";
        else dig = "0";
        char c = dig.charAt(0);
        char d = dv.charAt(0);
        
        if (c == d) return "El Dígito Verificador ES correcto";
        else return "El Dígito Verificador NO es correcto";
    }

    /**
     * Web service operation
     */
    public static boolean validarNombre(String nombre) {
        String val;
        val = "áéíóúÁÉÍÓÚ";
	if(nombre.length() == 0) {
            return false;
	}
	else{
            int cont = 0;
            for(int i=0; i<nombre.length(); i++) {
		char character = nombre.charAt(i);
		int ascii = (int) character;
		if(ascii == 32) {
                    cont++;
		}
		for(int j=65; j<=90; j++) {
                    if(ascii == j) {
			cont++;
                    }
		}
		for(int h=97; h<=122; h++) {
                    if(ascii == h) {
			cont++;
                    }
		}
                
            }
            for(int i=0; i<nombre.length(); i++) {
                char tildes = nombre.charAt(i);
                for(int j=0; j<val.length(); j++){
                    if (tildes == val.charAt(j)){
                        cont++;
                    }
                }
            }
            return cont == nombre.length();			
	}
    }
    
    @WebMethod(operationName = "split")
    public String split(@WebParam(name = "nombre") String nombre) {
            String[] nombre_separado = nombre.split(" ");
            if (nombre_separado.length == 1) {
                return "Nombre inválido";
            }
            String nombres;
            String apellidos;
            nombres = "";
            apellidos = "";
            if(validarNombre(nombre)==true) {
                for(int i=0; i<nombre_separado.length-2; i++){
                    nombres+=nombre_separado[i] + "<br>";
                }
                for(int i=nombre_separado.length-2; i<nombre_separado.length; i++){
                    apellidos+=nombre_separado[i] + "<br>";
                }
                
                
                if ("".equals(nombres)){
                    return "Nombre inválido";
                }
                
                else {
                    return "Nombres:" + "<br>" + nombres + "<br>" + "Apellidos:" + "<br>" + apellidos;
                }
            }
            else {
                return "Nombre inválido";
            }
        }
    }
