<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    //Función privada para obtener todas las marcas
    private function getAll()
    {
        try {
            $data = Brand::all();

            return ['status' => true, 'data' => $data];
        } catch (\Throwable $th) {
            return ['status' => false, 'error' => $th->getMessage()];
        }
    }

    // Obtener las marcas para DataTable
    public function gatAllTable()
    {
        $data = $this->getAll();
        // dd($data);
        if ($data['status'] == true) {
            return datatables()->of($data['data'])->toJson();
        } else {
            return response()->json(['status' => false, 'Error interno del servidor: ' . $data['error']], 500);
        }
    }

    // Obtener marcas para responde en JSON
    public function gatAllObject()
    {
        $data = $this->getAll();
        if ($data['status'] == true) {
            return response()->json(['status' => true, 'data' => $data['data']], 200);
        } else {
            return response()->json(['status' => false, 'Error interno del servidor: ' . $data['error']], 500);
        }
    }

    // Funcion para Registrar
    public function store(BrandRequest $request)
    {
        try {
            $data = $request->all();
            
            // Generar y añadir a la data el identifacor unico
            $data['identifier'] = $this->genUniqueId();

            Brand::create($data);
            return response()->json(['status' => true, 'title' => 'Correcto!', 'message' => 'Registro realizado con éxito.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'Error interno del servidor: ' . $th->getMessage()], 500);
        }
    }

    // Funcion para Obtener por ID
    public function show($id)
    {
        try {
            $item = Brand::find($id);

            return response()->json(['status' => true, 'data' => $item]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'Error interno del servidor: ' . $th->getMessage()], 500);
        }
    }

    // Funcion para editar una marca por parametro ID
    public function update(BrandRequest $request, $id)
    {
        try {
            $item = Brand::find($id);

            $item->update($request);

            return response()->json(['status' => true, 'title' => 'Correcto!', 'message' => 'Actualización realizada con éxito.']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'Error interno del servidor: ' . $th->getMessage()], 500);
        }
    }

    // Función para activar/desactivar
    public function changeStatus($id)
    {
        try {
            $item = Brand::find($id);

            if ($item) {
                $item->update(['status' => !$item->status]);

                return response()->json(['status' => true, 'title' => 'Actualizado!', 'message' => 'El estado fue cambiado.'], 200);
            } else {
                return response()->json(['status' => false, 'title' => '404!', 'message' => 'Ocurrió un error. Intente nuevamente.'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'Error interno del servidor: ' . $th->getMessage()], 500);
        }
    }

    // Función para eliminar
    public function destroy($id)
    {
        try {
            $item = Brand::find($id);

            if ($item) {
                $item->delete();
                return response()->json(['status' => true, 'title' => 'Eliminado!', 'message' => 'El registro se eliminó con éxito.'], 200);
            } else {
                return response()->json(['status' => false, 'title' => '404!', 'message' => 'Ocurrió un error. Intente nuevamente.'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'Error interno del servidor: ' . $th->getMessage()], 500);
        }
    }

    // Funcion privada para generar idenficador unico
    private function genUniqueId()
    {
        do {
            $uniqueId = substr(md5(uniqid(mt_rand(), true)), 0, 10);
        } while (Brand::where('identifier', $uniqueId)->exists());
    
        return $uniqueId;
    }
}