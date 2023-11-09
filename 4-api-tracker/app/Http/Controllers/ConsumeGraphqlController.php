<?php

namespace App\Http\Controllers;

use App\Services\ConsumeGraphqlInterface;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ConsumeGraphqlController extends Controller
{
    protected ConsumeGraphqlInterface $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    public function consultaDispositivo()
    {
        $consulta = $this->service->consultaDispositivo();
        // TODO: validar
        return $consulta;
    }

    public function consultaMarca()
    {
        $consulta = $this->service->consultaMarca();
        // TODO: validar
        return $consulta;
    }

    public function consultaGeral()
    {
        $consulta = $this->service->consultaGeral();
        // TODO: validar
        return $consulta;
    }
}
