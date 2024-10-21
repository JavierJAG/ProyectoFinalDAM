<?php

namespace App\Controllers\user;

use App\Models\EspecieModel;
use App\Models\ImagenCapturaModel;
use App\Models\ImagenModel;
use CodeIgniter\RESTful\ResourceController;

class Capturas extends ResourceController
{
    protected $modelName = "\App\Models\CapturaModel";

    public function index()
    {
        $capturas = $this->model->where('usuario_id', auth()->user()->id)->paginate(10);
        return view('/user/capturas/index', ['capturas' => $capturas, 'pager' => $this->model->pager]);
    }
    public function show($id = null)
    {
        $captura = $this->model->find($id);
        $imagenModel = new ImagenModel();
        $especieModel = new EspecieModel();
        $imagenes = $imagenModel->getImagenesCaptura($id);
        $especie = null;
        $imagenesEspecie = null;
        if (!$captura->especie_id == null) {
            $especie = $especieModel->find($captura->especie_id);
            $imagenesEspecie = $imagenModel->getImagenesEspecie($captura->especie_id);
        }

        return view('/user/capturas/show', ['captura' => $captura, 'imagenes' => $imagenes, 'especie' => $especie, 'imagenes_especie' => $imagenesEspecie]);
    }
    public function new()
    {
        return view('/user/capturas/new');
    }
    public function edit($id = null)
    {
        $imagenesModel = new ImagenModel();
        $captura = $this->model->find($id);
        $imagenes = $imagenesModel->getImagenesCaptura($id);
        return view('/user/capturas/edit', [
            'captura' => $captura,
            'imagenes' => $imagenes
        ]);
    }
    public function create()
    {
        if ($this->validate('captura')) {
            // if (!auth()->loggedIn()) {
            //     return redirect()->to(base_url('/Home'))->with('error', 'Necesitas registrarte para poder continuar');
            // }

            $especieModel = new especieModel();

            $fecha_captura = $this->request->getPost('fecha_captura');
            $nombre = $this->request->getPost('nombre');
            $descripcion = $this->request->getPost('descripcion');
            $peso = $this->request->getPost('peso');
            $tamano = $this->request->getPost('tamano');
            $especies = $especieModel->findAll();
            // $userId = auth()->user()->id;
            $especieId = null;
            foreach ($especies as $especie) {
                if ($especie->nombre_comun == $nombre || $especie->nombre_cientifico == $nombre) {
                    $especieId = $especie->id;
                    break;
                }
            }
            $capturaId = $this->model->insert([
                'fecha_captura' => $fecha_captura,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'peso' => $peso,
                'tamano' => $tamano,
                'usuario_id' => auth()->user()->id,
                'especie_id' => $especieId
            ]);
            // Manejar la subida de imágenes

            $imagenesModel = new ImagenModel();
            $imagenCapturaModel = new ImagenCapturaModel();
            $imagenes = $this->request->getFiles('imagenes');
            foreach ($imagenes['imagenes'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $nombreImagen = $file->getRandomName();
                    $extension = $file->guessExtension();
                    $ruta = '../public/uploads/capturas';
                    $file->move($ruta, $nombreImagen);

                    // Guardar la imagen en la base de datos
                    $imagenId = $imagenesModel->insert([
                        'imagen' => $nombreImagen,
                        'extension' => $extension
                    ]);

                    // Asociar la imagen con la captura
                    $imagenCapturaModel->insert([
                        'imagen_id' => $imagenId,
                        'captura_id' => $capturaId,
                    ]);
                }
            }

            return redirect()->to('/user/capturas')->with('mensaje', "Captura actualizada con éxito");
        } else {
            return redirect()->back()->with("error", $this->validator->listErrors())->withInput();
        }
    }

    public function update($id = null)
    {
        if ($this->validate('captura')) {
            // if (!auth()->loggedIn()) {
            //     return redirect()->to(base_url('/Home'))->with('error', 'Necesitas registrarte para poder continuar');
            // }

            $especieModel = new especieModel();

            $fecha_captura = $this->request->getPost('fecha_captura');
            $nombre = $this->request->getPost('nombre');
            $descripcion = $this->request->getPost('descripcion');
            $peso = $this->request->getPost('peso');
            $tamano = $this->request->getPost('tamano');
            $especies = $especieModel->findAll();
            // $userId = auth()->user()->id;
            $especieId = null;
            foreach ($especies as $especie) {
                if ($especie->nombre_comun == $nombre || $especie->nombre_cientifico == $nombre) {
                    $especieId = $especie->id;
                    break;
                }
            }
            $capturaId = $this->model->update($id, [
                'fecha_captura' => $fecha_captura,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'peso' => $peso,
                'tamano' => $tamano,
                'usuario_id' => 1,
                'especie_id' => $especieId
            ]);
            // Manejar la subida de imágenes

            $imagenesModel = new ImagenModel();
            $imagenCapturaModel = new ImagenCapturaModel();
            $imagenesCaptura = $imagenesModel->getImagenesCaptura($id);
            if ($imagenesCaptura) {
                foreach ($imagenesCaptura as $imagen) {

                    $rutaImagen = FCPATH . 'uploads/capturas/' . $imagen->imagen;
                    unlink($rutaImagen);
                }
            }
            $imagenesModel->deleteImagenesCaptura($id);
            $imagenes = $this->request->getFiles('imagenes');
            foreach ($imagenes['imagenes'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $nombreImagen = $file->getRandomName();
                    $extension = $file->guessExtension();
                    $ruta = '../public/uploads/capturas';
                    $file->move($ruta, $nombreImagen);

                    // Guardar la imagen en la base de datos

                    $imagenId = $imagenesModel->insert([
                        'imagen' => $nombreImagen,
                        'extension' => $extension
                    ]);

                    // Asociar la imagen con la captura
                    $imagenCapturaModel->insert([
                        'imagen_id' => $imagenId,
                        'captura_id' => $id,
                    ]);
                }
            }
            return redirect()->to('/user/capturas')->with('mensaje', "Captura actualizada con éxito");
        } else {
            return redirect()->back()->with("error", $this->validator->listErrors())->withInput();
        }
    }
    public function delete($id = null)
    {
        $captura = $this->model->find($id);
        if ($captura) {
            $imagenesModel = new ImagenModel();
            $imagenesCaptura = $imagenesModel->getImagenesCaptura($id);
            if ($imagenesCaptura) {
                foreach ($imagenesCaptura as $imagen) {

                    $rutaImagen = FCPATH . 'uploads/capturas/' . $imagen->imagen;
                    unlink($rutaImagen);
                }
            }
            $imagenesModel->deleteImagenesCaptura($id);
            $this->model->delete($id);
            return redirect()->to('/user/capturas')->with('mensaje', "Captura eliminada con éxito");
        } else {
            return redirect()->back()->with('error', "Error al eliminar la captura");
        }
    }
    function get_especies()
    {
        $term = $this->request->getVar('term');

        $especieModel = new EspecieModel();
        // Validar que haya un término de búsqueda
        if ($term) {
            // Buscar en la base de datos especies cuyo nombre coincida parcialmente con el término
            $especies = $especieModel
                ->like('nombre_comun', $term)
                ->findAll(); // Puedes limitar la cantidad con un ->limit(10) si deseas

            // Formatear los resultados para la respuesta en formato JSON
            $data = [];
            foreach ($especies as $especie) {
                $data[] = [
                    'nombre' => $especie->nombre_comun
                ];
            }

            // Retornar los resultados en formato JSON
            return $this->response->setJSON($data);
        }
    }
}
