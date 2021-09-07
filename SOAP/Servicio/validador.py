from itertools import cycle

def rutvalidador (rut):                                     #Recibe un rut como un número entero 
    dígitos = map(int, reversed(str(rut)))         
    factores = cycle(range(2, 8))
    s = sum(d * f for d, f in zip(dígitos, factores))
    print ((-s) % 11) #Muestra el resultado para comprobar
    return (-s) % 11                                        #Retorna el dígito verificador en número entero 

#Si el número entero que regresa es 10, el dígito verificador es K

rutvalidador(18675767)                    #Pruebasss

def separarnombres (ncompleto):
    separados =  ncompleto.split(" ")
    cont= len(separados)
    contnombres= cont - 2
    Nombress=[]
    Apellidoss=[]

    for i in range(contnombres):
        Nombress.append(separados[i])

    for j in range(2):
        Apellidoss.append(separados[contnombres+j])

    return Nombress, Apellidoss






N,A= separarnombres("Camilo Esteban Galileo Navas Moya")   #pruebasss

print(N)