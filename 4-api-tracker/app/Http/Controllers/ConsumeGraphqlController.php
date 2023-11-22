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

    public function consultaDispositivo(Request $request)
    {
        $consulta = $this->service->consultaDispositivo($request->device_id, $request->dia);
        return $consulta;
    }

    public function consultaMarca(Request $request)
    {
        $consulta = $this->service->consultaMarca($request->marca, $request->dia);
        return $consulta;
    }

    public function consultaGeral(Request $request)
    {
        $consulta = $this->service->consultaGeral($request->dia);
        return $consulta;
    }
}
