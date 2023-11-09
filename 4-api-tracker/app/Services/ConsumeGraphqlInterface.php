<?php

namespace App\Services;

interface ConsumeGraphqlInterface
{

    public static function isUP();

    public function consultaDispositivo();

    public function consultaMarca();

    public function consultaGeral();
}
