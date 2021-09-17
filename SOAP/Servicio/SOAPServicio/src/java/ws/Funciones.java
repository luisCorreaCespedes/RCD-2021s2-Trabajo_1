package ws;

import javax.jws.WebService;
import javax.jws.WebMethod;
import javax.jws.WebParam;


@WebService(serviceName = "Funciones")
public class Funciones {

    @WebMethod(operationName = "validador")
    public String validador(@WebParam(name = "rut") int rut, @WebParam(name = "dv") String dv) {
        String aux = Integer.toString(rut);
        if (aux == null) return "Campo vacío";
        if (aux.length() == 0) return "No hay un RUT ingresado";
        if (aux.length() < 7 || aux.length() > 8) return "El RUT no es válido";
        if (dv == null) return "No hay un DV ingresado";
        int digito;
        int suma;
        int resto;
        int resultado;
        int factor;
        dv = dv.toLowerCase();
        String dig;
        for(factor = 2, suma = 0; rut > 0; factor++){
            digito = rut % 10;
            rut /= 10;
            suma += digito * factor;
            if(factor >= 7) factor = 1;
        }
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

    public static boolean validarNombre(String nombre) {
        String val;
        char character;
        char tildes;
        int ascii;
        val = "áéíóúÁÉÍÓÚ";
        if(nombre.length() == 0) return false;
        else {
            int cont = 0;
            for(int i=0; i<nombre.length(); i++) {
                character = nombre.charAt(i);
                ascii = (int) character;
                if(ascii == 32) cont++;
                for(int j=65; j<=90; j++) {
                    if(ascii == j) cont++;
                }
                for(int h=97; h<=122; h++) {
                    if(ascii == h) cont++;
                }    
            }
            for(int i=0; i<nombre.length(); i++) {
                tildes = nombre.charAt(i);
                for(int j=0; j<val.length(); j++){
                    if (tildes == val.charAt(j)) cont++;
                }
            }
            return cont == nombre.length();			
        }
    }
    
    @WebMethod(operationName = "split")
    public String split(@WebParam(name = "nombre") String nombre) {
        String mensaje;
        mensaje = "No hay un nombre completo";
        String[] nombreSeparado = nombre.split(" ");
        if (nombreSeparado.length == 1) return mensaje;
        String nombres;
        String apellidos;
        nombres = "";
        apellidos = "";
        if(validarNombre(nombre)) {
            for(int i=0; i<nombreSeparado.length-2; i++){
                nombres+=nombreSeparado[i] + "<br>";
            }
            for(int i=nombreSeparado.length-2; i<nombreSeparado.length; i++){
                apellidos+=nombreSeparado[i] + "<br>";
            } 
            if ("".equals(nombres)) return mensaje;
            else return "Nombres:" + "<br>" + nombres + "<br>" + "Apellidos:" + "<br>" + apellidos;
            }
        else return "El nombre es inválido";
    }
}
