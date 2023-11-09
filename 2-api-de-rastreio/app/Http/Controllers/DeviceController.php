<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Location;
use Illuminate\Http\Request;
use Ramsey\Uuid\UuidInterface;

class DeviceController extends Controller
{
    public function index()
    {
        $query = Device::query();

        return $query->paginate(5);
    }



    public function show(string $uuid)
    {
        $device = Device::find($uuid);
        if ($device === null) {
            return response()->json(['message' => 'Device not found'], 404);
        }

        return $device;
    }

    public function store(Request $request)
    {
        $device = Device::create([
                'nome' => $request->device_name,
                'codigo' => $request->codigo,
                'ativo' => true,
                'marca' => $request->marca
            ]);
        return response()
            ->json($device, 201);
    }

    public function update(string $uuid, Request $request)
    {
        $device = Device::find($uuid);

        if (!$device) {
            return response()->json(['message' => 'Device not found.'], 404);
        }

        $device->update($request->all());

        return $device;
    }

    public function destroy(Device $device) {
        $device->delete();
        return response()->noContent();
    }

    public function getLocationByDay(string $id, Request $request)
    {
        $filters = $this->defineFilters($request->all());

        $device = Device::find($id);

        if (!$device) {
            return response()->json(['message' => 'Dispositivo não encontrado'], 404);
        }

        $locations = Location::where('device_id', $id)
            ->when(isset($filters['day']), function ($query) use ($filters) {
                return $query->whereDate('created_at', $filters['day']);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return response()->json(['device' => $device, 'locations' => $locations]);
    }


    public function defineFilters($request): array
    {
        $filters = [];

        if ($request['day']) {
            $filters['day'] = $request['day'];
        }

        return $filters;
    }

}
