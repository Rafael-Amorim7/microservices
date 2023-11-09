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

    public function consultaDispositivo()
    {
        // Implementar consumo de outra api
        dd('other graphql');
    }

    public function consultaMarca()
    {
        // Implementar consumo de outra api
        dd('other graphql');
    }

    public function consultaGeral()
    {
        // Implementar consumo de outra api
        dd('other graphql');
    }
}
