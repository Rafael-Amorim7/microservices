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

    public function consultaDispositivo()
    {
        $data = [
            'input' => [
                'dispositivo_id' => 'AJ192LAJK',
                'dia' => ' 2023-08-01',
            ]
        ];

        $response = $this->client->post($this->url, [
            'body' => "mutation { consultaDispositivo(" . json_encode($data) . ") { message result status } } "
        ]);

        return json_decode($response->getBody()->getContents());

    }

    public function consultaMarca()
    {
        $data = [
            'input' => [
                'marca' => 'Apple',
                'dia' => '2023-08-01',
            ]
        ];

        $response = $this->client->post($this->url, [
            'body' => "mutation { consultaMarca(" . json_encode($data) . ") { message result status } } "
        ]);

        return json_decode($response->getBody()->getContents());

    }

    public function consultaGeral()
    {
        $data = [
            'input' => [
                'dia' => '2023-08-01',
            ]
        ];

        $response = $this->client->post($this->url, [
            'body' => "mutation { consultaGeral(" . json_encode($data) . ") { message result status } } "
        ]);

        return json_decode($response->getBody()->getContents());

    }
}
