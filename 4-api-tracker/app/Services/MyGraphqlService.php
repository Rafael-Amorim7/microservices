<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Services\ConsumeGraphqlInterface;

class MyGraphqlService implements ConsumeGraphqlInterface
{
    public Client $client;
    public string $url;

    public function __construct()
    {
        $this->client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $this->url = 'http://localhost:8001';
    }

    public static function isUP() {
        $client = new Client(['headers' => ['Content-Type' => 'application/json']]);
        $url = 'http://localhost:8001';

        try {
            $resposta = $client->request('GET', $url);
        } catch (\Exception $e) {
            return false;
        }

        return $resposta->getStatusCode() == 200;
    }

    public function consultaDispositivo(string $device_id, string $dia)
    {
        $query = '{
            consultaDispositivo(id_dispositivo: "'.$device_id.'", dia: "'.$dia.'") {
                id_dispositivo
                marca
                quantidade_posicao
                total_km
            }
        }';

        $response = $this->client->post($this->url, [
            'body' => json_encode(['query' => $query])
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function consultaMarca(string $marca,string $dia)
    {
        $query = '{
            consultaMarca(marca: "'.$marca.'", dia: "'.$dia.'") {
                quantidade_dispositivo
                marca
                quantidade_posicao
                total_km
            }
        }';

        $response = $this->client->post($this->url, [
            'body' => json_encode(['query' => $query])
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function consultaGeral(string $dia)
    {
        $query = '{
            consultaGeral(dia: "'.$dia.'") {
                quantidade_dispositivo
                quantidade_posicao
                total_km
            }
        }';

        $response = $this->client->post($this->url, [
            'body' => json_encode(['query' => $query])
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
