from itertools import cycle

def rutvalidador (rut):                                     #Recibe un rut como un número entero 
    reversed_digits = map(int, reversed(str(rut)))         
    factors = cycle(range(2, 8))
    s = sum(d * f for d, f in zip(reversed_digits, factors))
    return (-s) % 11                                        #Retorna el dígito verificador en número entero 

#Si el número entero que regresa es 10, el dígito verificador es K

def nombrecompleto (nombre):
    return
