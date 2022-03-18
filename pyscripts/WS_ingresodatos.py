# -*- coding: utf-8 -*-
"""
Created on Sun Oct 15 16:47:55 2021
@author: Fiorela
"""

import urllib.request
import requests
import json
import pandas as pd


''' ******* LEER ARCHIVO EXCEL ******* '''
ruta = "C:/wamp64/www/SOTR/LAB1/download/"
arch = "TablaLB1.xlsx"

curso_data = pd.read_excel(ruta+arch, sheet_name="cursos")
alumno_data = pd.read_excel(ruta+arch, sheet_name="personal_alumno")
docente_data = pd.read_excel(ruta+arch, sheet_name="personal_docente")
matricula_data = pd.read_excel(ruta+arch, sheet_name="matriculados")
asist_data = pd.read_excel(ruta+arch, sheet_name="asistencia")
vent_data = pd.read_excel(ruta+arch, sheet_name="ventilacion")

rutaurl = "http://localhost/SOTR/LAB1/php/webservices/"

''' ---------------------- CURSOS ---------------------- '''
url = rutaurl+"crear_cursos.php"

key = "123456"
header = {"Content-Type":"application/json"}

print("---- INGRESO DE CURSOS ----")
for i in range(len(curso_data)):
    datos={"id":curso_data['id'].iloc[i], 
           "codcurso":curso_data['codcurso'].iloc[i],
           "curso":curso_data['curso'].iloc[i], 
           "seccion":curso_data['seccion'].iloc[i], 
           "campus":curso_data['campus'].iloc[i], 
           "aula":curso_data['aula'].iloc[i], 
           "dia":curso_data['dia'].iloc[i], 
           "hora_inicio":curso_data['hora_inicio'].iloc[i],
           "hora_fin":curso_data['hora_fin'].iloc[i], 
           "tipo_sesion":curso_data['tipo_sesion'].iloc[i],
           "ciclo":curso_data['ciclo'].iloc[i], 
           "aforo_covid":curso_data['aforo_covid'].iloc[i], 
           "key":key}

    cliente = requests.session()
    respuesta = cliente.post(url, datos, headers=header)
    print(i, respuesta.text)
    
    
#%%

''' ---------------------- ESTUDIANTES ---------------------- '''
url = rutaurl+"crear_estudiante.php"

key = "123456"
header = {"Content-Type":"application/json"}

print("---- INGRESO DE ESTUDIANTES ----")
for i in range(len(alumno_data)):
    datos={"codigo":alumno_data['codigo'].iloc[i], 
           "nombre":alumno_data['nombre'].iloc[i],
           "apellidop":alumno_data['apellidop'].iloc[i], 
           "apellidom":alumno_data['apellidom'].iloc[i], 
           "carrera":alumno_data['carrera'].iloc[i], 
           "sexo":alumno_data['sexo'].iloc[i], 
           "campus":alumno_data['campus'].iloc[i],
           "estado": "ALUMNO",
           "key":key}

    cliente = requests.session()
    respuesta = cliente.post(url, datos, headers=header)
    print(i, respuesta.text)
    
#%%
''' ---------------------- DOCENTES ---------------------- '''
url = rutaurl+"crear_docentes.php"

key = "123456"
header = {"Content-Type":"application/json"}

print("---- INGRESO DE DOCENTES ----")
for i in range(len(docente_data)):
    datos={"codigo":docente_data['codigo'].iloc[i], 
           "nombre":docente_data['nombre'].iloc[i],
           "apellidop":docente_data['apellidop'].iloc[i], 
           "apellidom":docente_data['apellidom'].iloc[i], 
           "carrera":docente_data['carrera'].iloc[i], 
           "sexo":docente_data['sexo'].iloc[i], 
           "campus":docente_data['campus'].iloc[i], 
           "estado": "DOCENTE",
           "key":key}

    cliente = requests.session()
    respuesta = cliente.post(url, datos, headers=header)
    print(i, respuesta.text)

#%%
''' ---------------------- MATRICULAR ALUMNOS ---------------------- '''
url = rutaurl+"matricular_alumno.php"

key = "123456"
header = {"Content-Type":"application/json"}

print("---- MATRICULAR ALUMNOS ----")
for i in range(len(matricula_data)):
    datos={"id":matricula_data['id'].iloc[i], 
           "codalumno":matricula_data['codalumno'].iloc[i],
           "retirado":matricula_data['retirado'].iloc[i], 
           "key":key}

    cliente = requests.session()
    respuesta = cliente.post(url, datos, headers=header)
    print(i, respuesta.text)
#%%
''' ---------------------- ASISTENCIA ---------------------- '''
url = rutaurl+"insertar_asistencia.php"

key = "123456"
header = {"Content-Type":"application/json"}

print("---- INGRESO DE DATOS DE ASISTENCIA ----")
for i in range(len(asist_data)):
    datos={"idsesion":asist_data['idsesion'].iloc[i], 
           "codigo":asist_data['codigo'].iloc[i],
           "hora_entrada":asist_data['hora_entrada'].iloc[i], 
           "hora_salida":asist_data['hora_salida'].iloc[i], 
           "estado":asist_data['estado'].iloc[i], 
           "temperatura":asist_data['temperatura'].iloc[i], 
           "key":key}

    cliente = requests.session()
    respuesta = cliente.post(url, datos, headers=header)
    print(i, respuesta.text)

#%%

''' ---------------------- VENTILACION ---------------------- '''
url = rutaurl+"insertar_ventilacion.php"

key = "123456"
header = {"Content-Type":"application/json"}

print("---- INGRESO DE DATOS DE VENTILACION ----")
for i in range(len(vent_data)):
    datos={"idsesion":vent_data['idsesion'].iloc[i], 
           "CO2aula":vent_data['CO2aula'].iloc[i],
           "CO2externo":vent_data['CO2externo'].iloc[i], 
           "aforo":vent_data['aforo'].iloc[i], 
           "fecha":vent_data['fecha'].iloc[i], 
           "hora":vent_data['hora'].iloc[i], 
           "key":key}

    cliente = requests.session()
    respuesta = cliente.post(url, datos, headers=header)
    print(i, respuesta.text)

