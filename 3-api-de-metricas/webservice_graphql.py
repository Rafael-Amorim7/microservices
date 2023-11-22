from ariadne import QueryType, make_executable_schema
from ariadne.asgi import GraphQL
from ariadne import load_schema_from_path
from ariadne import make_executable_schema

import mysql.connector

type_defs = load_schema_from_path("./schema.graphql")
query = QueryType()

@query.field("consultaDispositivo")
def consultarDispositivo(_, info, id_dispositivo, dia):
    try:
        query = ("SELECT device_id, brand, position_count, total_distance "
                "FROM rastreio.metrics "
                "WHERE device_id = %s AND date = %s")
        
        params = (id_dispositivo, dia)
        
        dispositivo = dbConnection(query, params)

        if dispositivo:
            device_id, brand, position_count, total_distance = dispositivo
            
            return{
                "id_dispositivo": device_id,
                "marca": brand,
                "quantidade_posicao": position_count,
                "total_km": total_distance
            }
        else:
            return "Not Found"
        
    except Exception as err:
            print("Erro:", err)    

@query.field("consultaMarca")
def consultarMarca(_, info, marca, dia):
    try:
        query = ("SELECT COUNT(device_id), brand, sum(position_count), format(sum(metrics.total_distance),2) "
                "FROM rastreio.metrics "
                "WHERE brand = %s AND date = %s "
                "GROUP BY brand")
        
        params = (marca, dia)

        brand = dbConnection(query, params)

        if brand:
            device_quantity, brand, position_quantity, total_km = brand
            position_quantity = int(position_quantity)

            return {
                "quantidade_dispositivo": device_quantity,
                "marca": brand,
                "quantidade_posicao": position_quantity,
                "total_km": total_km
            }
        
        else:
            return "Not Found"
        
    except Exception as error:
        return error
        

@query.field("consultaGeral")
def consultarGeral(_, info, dia):
    try:
        query = ("SELECT COUNT(device_id), sum(position_count), format(sum(metrics.total_distance),2) "
                "FROM rastreio.metrics "
                "WHERE date = %s")

        geral = dbConnection(query, (dia,))

        if geral:
            device_quantity, position_quantity, total_km = geral
            
            return {
                "quantidade_dispositivo": device_quantity,
                "quantidade_posicao": position_quantity,
                "total_km": total_km
            }
        
        else:
            return "Not Found"
        
    except Exception as error:
        return error

def dbConnection(query, param):
    try:
        connection = mysql.connector.connect(user='sherlock',
                                                password='', 
                                                host='127.0.0.1', 
                                                database='rastreio')
        cursor = connection.cursor(buffered=True)

        cursor.execute(query, param)
        dispositivo = cursor.fetchone()

        cursor.close()
        connection.close()

        return dispositivo
    
    except Exception as error:
         return "Not Found"

schema = make_executable_schema(type_defs, query)

app = GraphQL(schema, debug=True)