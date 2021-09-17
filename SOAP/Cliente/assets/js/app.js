// CONSUMIR SOAP
$(document).ready(function() {

    // Consumiendo RUT
    $("#verifyDV").click(function() {
        var rut = $("#inputRut").val();
        var dv = $("#inputDV").val();
        var data = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:ws=\"http://ws/\">\r\n   <soapenv:Header/>\r\n   <soapenv:Body>\r\n      <ws:validador>\r\n        <rut>" + rut + "</rut>\r\n       <dv>" + dv + "</dv>\r\n       </ws:validador>\r\n   </soapenv:Body>\r\n</soapenv:Envelope>";
        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;
        xhr.addEventListener("readystatechange", function() {
            if (this.readyState === 4) {
                const parser = new DOMParser();
                const dater = parser.parseFromString(this.responseText, 'text/xml');
                console.log(dater.querySelector('validadorResponse').textContent);
                $("#validatorDV").html(dater.querySelector('validadorResponse').textContent);
            }
        });
        xhr.open("POST", "http://localhost:8080/SOAPServicio/Funciones");
        xhr.setRequestHeader("Content-Type", "text/xml");
        xhr.send(data);
    });


    // Consumiendo NOMBRES
    $("#verifyName").click(function() {
        var nombres = $("#inputName").val();
        var data = "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:ws=\"http://ws/\">\r\n   <soapenv:Header/>\r\n   <soapenv:Body>\r\n      <ws:split>\r\n         <nombre>" + nombres + "</nombre>\r\n      </ws:split>\r\n   </soapenv:Body>\r\n</soapenv:Envelope>\r\n\r\n";
        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;
        xhr.addEventListener("readystatechange", function() {
            if (this.readyState === 4) {
                const parser = new DOMParser();
                const dater = parser.parseFromString(this.responseText, 'text/xml');
                console.log(dater.querySelector('splitResponse').textContent);
                $("#validatorName").html(dater.querySelector('splitResponse').textContent);
            }
        });
        xhr.open("POST", "http://localhost:8080/SOAPServicio/Funciones");
        xhr.setRequestHeader("Content-Type", "text/xml");

        xhr.send(data);
    });
});
    