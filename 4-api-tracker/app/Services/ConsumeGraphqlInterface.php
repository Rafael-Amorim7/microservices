<?php

namespace App\Services;

interface ConsumeGraphqlInterface
{

    public static function isUP();

    public function consultaDispositivo(string $device_id, string $dia);

    public function consultaMarca(string $marca, string $dia);

    public function consultaGeral(string $dia);
}
