import requests

temp = input("Ingrese la temperatura de fiebre")

try:
    respuesta = requests.get("http://localhost/SOTR/LAB1/php/admin/ventanas/ws_casosfiebre.php?temperatura="+temp)

except:
    quit()

if respuesta.status_code==200:
    print("Se encontró la respuesta del servidor")
elif respuesta.status_code==404:
    print("El servidor no está disponible o la URL no existe")
    quit()
else:
    print("No se tuvo respuesta del servidor")
    quit()

    respuesta.encoding = "utf-8"
    lista = respuesta.json()
    tam = len(lista)
    print("El número de elementos devueltos por el servicio Web es de ", tam)

    i = 1
    for elem in lista:
        print("Elemnto",i)
        print("Código: ",elem["codigo"])
        print("Nombres: ",elem["nombres"])
        print("Apellido paterno: ",elem["apellido"])
        print("Carrera: ",elem["carrera"])
        print("Sexo: ",elem["sexo"])
        print("Campus: ",elem["campus"])
        
        
#%%
import urllib.request
import requests
import json

# INGRESO DE DATOS DE PYTHON A MYSQL por medio de PHP
rutaurl = "http://localhost/SOTR/LAB1/php/webservices/"

''' ---------------------- CURSOS ---------------------- '''
url = rutaurl+"crear_cursos.php"

print("Registre un nuevo curso de la UPC:")

idi = input("ID: ")
codcurso = input("Código del curso: ")
curso = input("Nombre del curso: ")
seccion = input("Sección del curso: ")
campus = input("Campus donde se dictará: ")
aula = input("Aula del curso: ")
dia = input("Día de dictado del curso: ")
hora_inicio = input("Hora de inicio del curso: ")
hora_fin = input("Hora de término del curso: ")
tipo_sesion = input("Tipo de sesión (TE/PR/LB/TA): ")
ciclo = input("Semestre académico del curso: ")
aforo_covid = input("Aforo COVID del aula: ")

key = "123456"

datos={"id":idi, "codcurso":codcurso,"curso":curso, 
       "seccion":seccion, "campus":campus,
       "aula":aula, "dia":dia, "hora_inicio":hora_inicio,
       "hora_fin":hora_fin, "tipo_sesion":tipo_sesion, "ciclo":ciclo,
       "aforo_covid":aforo_covid, "key":key}

header = {"Content-Type":"application/json"}
cliente = requests.session()
respuesta = cliente.post(url, datos, headers=header)
print(respuesta.text)

