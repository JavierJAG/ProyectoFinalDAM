<?php

namespace App\Controllers\user;

use App\Models\EspecieModel;
use App\Models\ImagenCapturaModel;
use App\Models\ImagenModel;
use App\Models\LocalidadModel;
use App\Models\ZonaPescaModel;
use CodeIgniter\RESTful\ResourceController;

class Capturas extends ResourceController
{
    protected $modelName = "\App\Models\CapturaModel";

    public function index()
    {
        $capturas = $this->model->paginate(10);
        return view('/user/capturas/index', ['capturas' => $capturas, 'pager' => $this->model->pager]);
    }
    public function show($id = null)
    {
        // Intenta obtener la captura por ID
        $captura = $this->model->find($id);
        $zonaPescaModel = new ZonaPescaModel();
        $localidadModel = new LocalidadModel();
        $userModel = model('UserModel');
        $user = $userModel->find($captura->usuario_id);
        $zonaPesca = $zonaPescaModel->find($captura->zona_id);
        $localidad = $localidadModel->where('id', $zonaPesca->localidad_id)->first();

        // Verifica si la captura fue encontrada
        if (!$captura) {
            // Maneja el caso donde no se encuentra la captura
            return redirect()->back()->with('error', 'Captura no encontrada.');
        }

        // Inicializa modelos
        $imagenModel = new ImagenModel();
        $especieModel = new EspecieModel();

        // Obtiene imágenes de la captura
        $imagenes = $imagenModel->getImagenesCaptura($id);
        $especie = null;
        $imagenesEspecie = null;

        // Verifica si especie_id está presente y no es nulo
        if ($captura->especie_id != null) {
            $especie = $especieModel->find($captura->especie_id);
            $imagenesEspecie = $imagenModel->getImagenesEspecie($captura->especie_id);
        }

        // Devuelve la vista con los datos
        return view('/user/capturas/show', [
            'captura' => $captura,
            'imagenes' => $imagenes,
            'especie' => $especie,
            'autor' => $user,
            'zona' => $zonaPesca,
            'localidad' => $localidad,
            'imagenes_especie' => $imagenesEspecie
        ]);
    }

    public function new()
    {
        $zonaPescaModel = new ZonaPescaModel();
        $zonas = $zonaPescaModel->where('usuario_id',auth()->user()->id)->findAll();
        if (empty($zonas)){
            return redirect()->to('/user/perfil/misZonasPesca')->with('mensaje','Debes crear primero zonas de pesca en las que registrar tu captura. Crea al menos una.');
        }
        return view('/user/capturas/new');
    }
    public function edit($id = null)
    {
        $zonaPescaModel = new ZonaPescaModel();
        $localidadModel = new LocalidadModel();
        $imagenesModel = new ImagenModel();
        $captura = $this->model->find($id);
        $zonaPesca = $zonaPescaModel->find($captura->zona_id);
        $localidad = $localidadModel->find($zonaPesca->localidad_id);
        $localidades = $localidadModel->where('PROVINCIA', $localidad->PROVINCIA)->findAll();
        $zonasPesca = $zonaPescaModel->where('localidad_id', $localidad->id)->findAll();
        $imagenes = $imagenesModel->getImagenesCaptura($id);
        return view('/user/capturas/edit', [
            'captura' => $captura,
            'imagenes' => $imagenes,
            'zonaPesca' => $zonaPesca,
            'localidad' => $localidad,
            'localidades' => $localidades,
            'zonasPesca' => $zonasPesca,
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
            $zonaPesca = $this->request->getPost('zonaPesca');
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
                'especie_id' => $especieId,
                'zona_id' => $zonaPesca,
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

            return redirect()->to('/user/perfil/misCapturas')->with('mensaje', "Captura creada con éxito");
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
            $zonaPesca = $this->request->getPost('zonaPesca');

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
                'usuario_id' => auth()->user()->id,
                'especie_id' => $especieId,
                'zona_id' => $zonaPesca,
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
            return redirect()->to('/user/perfil/misCapturas')->with('mensaje', "Captura actualizada con éxito");
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
            return redirect()->to('/user/perfil/misCapturas')->with('mensaje', "Captura eliminada con éxito");
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
