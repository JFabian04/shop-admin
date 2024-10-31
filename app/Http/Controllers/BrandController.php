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
            return response()->json(['success' => false, 'Error interno del servidor: ' . $data['error']], 500);
        }
    }

    // Obtener marcas para responde en JSON
    public function gatAllObject(Request $request)
    {
        try {
            $data = Brand::filterName($request->name)->take(15)->where('status', 0)->get();;
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'Error interno del servidor: ' . $th->getMessage()], 500);
        }
    }

    // Funcion para Registrar
    public function store(BrandRequest $request)
    {
        try {
            $data = $request->all();

            // Generar y añadir a la data el identifacor unico
            $data['identifier'] = $this->genUniqueId();

            // Validar si la marca ya está registrada
            $item = Brand::where('name', $data['name'])->get();

            if (count($item) > 0) {
                return response()->json(['success' => false, 'errors' =>  ['name' => ['La marca ya ha sido registrada.']]], 200);
            } else {
                Brand::create($data);
                return response()->json(['success' => true, 'title' => 'Correcto!', 'message' => 'Registro realizado con éxito.'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'Error interno del servidor: ' . $th->getMessage()], 500);
        }
    }

    // Funcion para Obtener por ID
    public function show($id)
    {
        try {
            $item = Brand::find($id);

            return response()->json(['success' => true, 'data' => $item]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'Error interno del servidor: ' . $th->getMessage()], 500);
        }
    }

    // Funcion para editar una marca por parametro ID
    public function update(BrandRequest $request, $id)
    {
        try {
            $item = Brand::find($id);

            $item->update($request->all());

            return response()->json(['success' => true, 'title' => 'Correcto!', 'message' => 'Actualización realizada con éxito.']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'Error interno del servidor: ' . $th->getMessage()], 500);
        }
    }

    // Función para activar/desactivar
    public function changeStatus($id)
    {
        try {
            $item = Brand::find($id);

            // dd($item);

            if ($item) {
                $item->update(['status' => $item->status == 0 ? 1 : 0]);

                return response()->json(['success' => true, 'title' => 'Actualizado!', 'message' => 'El estado fue cambiado.'], 200);
            } else {
                return response()->json(['success' => false, 'title' => '404!', 'message' => 'Ocurrió un error. Intente nuevamente.'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'Error interno del servidor: ' . $th->getMessage()], 500);
        }
    }

    // Función para eliminar
    public function destroy($id)
    {
        try {
            $item = Brand::find($id);

            if ($item) {
                $item->delete();
                return response()->json(['success' => true, 'title' => 'Eliminado!', 'message' => 'El registro se eliminó con éxito.'], 200);
            } else {
                return response()->json(['success' => false, 'title' => '404!', 'message' => 'Ocurrió un error. Intente nuevamente.'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'Error interno del servidor: ' . $th->getMessage()], 500);
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
