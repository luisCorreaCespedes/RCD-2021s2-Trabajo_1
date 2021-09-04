from itertools import cycle

def rutvalidador (rut):                                     #Recibe un rut como un número entero 
    dígitos = map(int, reversed(str(rut)))         
    factores = cycle(range(2, 8))
    s = sum(d * f for d, f in zip(dígitos, factores))
    return (-s) % 11                                        #Retorna el dígito verificador en número entero 

#Si el número entero que regresa es 10, el dígito verificador es K

def nombrecompleto (nombre):
    return
