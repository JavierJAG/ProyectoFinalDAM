<?php

namespace App\Controllers\user;

use App\Models\CapturaModel;
use App\Models\EspecieModel;
use App\Models\ImagenCapturaModel;
use App\Models\ImagenModel;
use CodeIgniter\RESTful\ResourceController;

class Capturas extends ResourceController
{
    protected $modelName = "\App\Models\CapturaModel";

    public function index()
    {
        $capturas = $this->model->findAll();
        return view('/user/capturas/index', ['capturas' => $capturas]);
    }
    public function show($id = null)
    {
        $captura = $this->model->find($id);
        $imagenModel = new ImagenModel();
        $imagenes = $imagenModel->getImagenesCaptura($id);
        return view('/user/capturas/show', ['captura' => $captura, 'imagenes' => $imagenes]);
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
            $nombre_comun = $this->request->getPost('nombre_comun');
            $nombre_cientifico = $this->request->getPost('nombre_cientifico');
            $talla_minima = $this->request->getPost('talla_minima');
            $cupo_maximo = $this->request->getPost('cupo_maximo');

            $capturaId = $this->model->insert([
                'nombre_comun' => $nombre_comun,
                'nombre_cientifico' => $nombre_cientifico,
                'talla_minima' => $talla_minima,
                'cupo_maximo' => $cupo_maximo
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

            return redirect()->to('/user/capturas')->with('mensaje', "Captura creada con éxito");
        } else {
            return redirect()->back()->with("error", $this->validator->listErrors())->withInput();
        }
    }

    public function update($id = null)
    {
        if ($this->validate('captura')) {
            $nombre_comun = $this->request->getPost('nombre_comun');
            $nombre_cientifico = $this->request->getPost('nombre_cientifico');
            $talla_minima = $this->request->getPost('talla_minima');
            $cupo_maximo = $this->request->getPost('cupo_maximo');

            $this->model->update($id, [
                'nombre_comun' => $nombre_comun,
                'nombre_cientifico' => $nombre_cientifico,
                'talla_minima' => $talla_minima,
                'cupo_maximo' => $cupo_maximo
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
    function get_especies() {
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
