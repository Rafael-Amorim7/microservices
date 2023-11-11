<?php

namespace App\Services;

use App\Services\ConsumeGraphqlInterface;

class OthersGraphqlService implements ConsumeGraphqlInterface
{

    public static function isUP()
    {
        // Testar Api
        return false;
    }

    public function consultaDispositivo(string $device_id, string $dia)
    {
        // Implementar consumo de outra api
        dd('other graphql');
    }

    public function consultaMarca(string $marca, string $dia)
    {
        // Implementar consumo de outra api
        dd('other graphql');
    }

    public function consultaGeral(string $dia)
    {
        // Implementar consumo de outra api
        dd('other graphql');
    }
}
