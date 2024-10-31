<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductFile;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //Función privada para obtener todos los regisotr en un array
    private function getAll()
    {
        try {
            $data = Product::query();

            return ['status' => true, 'data' => $data];
        } catch (\Throwable $th) {
            return ['status' => false, 'error' => $th->getMessage()];
        }
    }

    // Funcion que se encargar de retortnar los datos para DataTable
    public function gatAllTable()
    {
        $data = $this->getAll();


        if ($data['status'] == true) {
            $resp = $data['data']->with(['brand:id,name'])->get();
            return datatables()->of($resp)->toJson();
        } else {
            return response()->json(['success' => false, 'Error interno del servidor: ' . $data['error']], 500);
        }
    }

    // Obtener marcas para responde en JSON
    public function gatAllObject(Request $request)
    {
        $data = $this->getAll();


        if ($data['status'] == true) {

            $resp = $data['data']->with(['brand:id,name'])->filterName($request->name)->where('status', 0)->paginate(10);
            // dd($resp);

            return response()->json($resp, 200);
        } else {
            return response()->json('Error interno del servidor: ' . $data['error'], 500);
        }
    }

    // Funcion para Registrar
    public function store(ProductRequest $request)
    {
        try {
            $data = $request->all();

            Product::create($data);
            return response()->json(['success' => true, 'title' => 'Correcto!', 'message' => 'Registro realizado con éxito.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'Error interno del servidor: ' . $th->getMessage()], 500);
        }
    }


    // Funcion para Obtener por ID
    public function show($id)
    {
        try {
            $item = Product::with(['brand:id,name'])->find($id);

            return response()->json(['success' => true, 'data' => $item]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'Error interno del servidor: ' . $th->getMessage()], 500);
        }
    }

    // Funcion para editar una marca por parametro ID
    public function update(ProductRequest $request, $id)
    {
        try {
            $item = Product::find($id);

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
            $item = Product::find($id);

            if ($item) {
                $item->update(['status' => !$item->status]);

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
            $item = Product::find($id);

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

    // Función para cargar las imagenes del producto
    public function uploadImages(Request $request, $id)
    {
        $imagesData = json_decode($request->input('images'), true);

        foreach ($imagesData as $imageData) {
            if (isset($imageData['image']) && !empty($imageData['image'])) {
                $imageFile = $imageData['image'];
                $main = isset($imageData['main']) ? $imageData['main'] : 0; // Valor por defecto 0 si no existe

                // Obtener el número del contenedor de la imagen
                $imageNumber = $imageData['number'];

                // nombre único para la imagen
                $imageName = $imageNumber . '_' . time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();

                // mover la imagen a la carpeta designada
                $imageFile->move(public_path('product_files/' . $id), $imageName);

                // Busca si ya existe en la base de datos
                $productFile = ProductFile::where('product_id', $id)->where('file_name', 'like', "$imageNumber%")->first();

                if ($productFile) {
                    // Si existe, actualizar
                    $productFile->file_name = $imageName;
                    $productFile->is_main = $main;
                    $productFile->save();
                } else {
                    // Si no existe, crear uno nuevo
                    $newProductFile = new ProductFile();
                    $newProductFile->product_id = $id;
                    $newProductFile->file_name = $imageName;
                    $newProductFile->is_main = $main;
                    $newProductFile->save();
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Imágenes cargadas correctamente'], 201);
    }

    // Función para cargar imagens de producto
    public function getImages($id)
    {
        $images = ProductFile::where('product_id', $id)->get();

        return response()->json($images, 200);
    }
}
