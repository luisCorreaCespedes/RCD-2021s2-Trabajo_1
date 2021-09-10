//inputRut verifyDV

$(document).ready(function() {
    $("#verifyDV").click(function() {
        var rut = $("#inputRut").val();
        var dig = $("#inputDV").val();
        var data = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:ws=\"http://ws/\">\r\n   <soapenv:Header/>\r\n   <soapenv:Body>\r\n      <ws:calculo_dv>\r\n        <rut>" + rut + "</rut>\r\n       <rut>" + dig + "</rut>\r\n       </ws:calculo_dv>\r\n   </soapenv:Body>\r\n</soapenv:Envelope>";

        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;

        xhr.addEventListener("readystatechange", function() {
            if (this.readyState === 4) {
                const parser = new DOMParser();
                const data = parser.parseFromString(this.responseText, 'text/xml');
                console.log(data.querySelector('calculo_dvResponse').textContent);
                $("#validatorDV").html(data.querySelector('calculo_dvResponse').textContent);
            }
        });

        xhr.open("POST", "http://localhost:8080/SOAPService/Funciones");
        xhr.setRequestHeader("Content-Type", "text/xml");

        xhr.send(data);

    });
    $("#btnName").click(function() {
        var nombres = $("#sendFn").val();
        var data = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:ws=\"http://ws/\">\r\n   <soapenv:Header/>\r\n   <soapenv:Body>\r\n      <ws:splitnombre>\r\n         <nombre_ok>" + nombres + "</nombre_ok>\r\n      </ws:splitnombre>\r\n   </soapenv:Body>\r\n</soapenv:Envelope>\r\n\r\n";

        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;

        xhr.addEventListener("readystatechange", function() {
            if (this.readyState === 4) {
                console.log(this.responseText);
                const parser = new DOMParser();
                const data = parser.parseFromString(this.responseText, 'text/xml');
                var apellido = data.querySelectorAll('return:first-child');
                var nombre = data.querySelectorAll('return:last-child');
                var nombre_array = [].slice.call(nombre);
                var apellido_array = [].slice.call(apellido);
                let aux = "";
                let aux1 = "";
                for (let index = 0; index < nombre_array[0].childNodes.length - 2; index++) {
                    aux += nombre_array[0].childNodes[index].textContent + "<br>"
                }
                $("#cardName").html(aux);
                for (let index = 0; index < apellido_array[0].childNodes.length; index++) {
                    aux1 += apellido_array[0].childNodes[index].textContent + "<br>"
                }
                $("#cardLast").html(aux1);
            }
        });

        xhr.open("POST", "http://localhost:8080/SOAP_RCD/operaciones_SOAP");
        xhr.setRequestHeader("Content-Type", "text/xml");

        xhr.send(data);
    });
});