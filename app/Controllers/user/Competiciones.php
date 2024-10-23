<?php

namespace App\Controllers\user;

use App\Models\CapturaModel;
use App\Models\ImagenCompeticionModel;
use App\Models\ImagenModel;
use App\Models\LocalidadModel;
use App\Models\LogroModel;
use App\Models\ParticipacionModel;
use App\Models\UsuarioLogroModel;
use App\Models\ZonaPescaModel;
use CodeIgniter\RESTful\ResourceController;

class Competiciones extends ResourceController
{
    protected $modelName = "\App\Models\CompeticionModel";

    public function index()
    {

        if (!auth()->user()->inGroup('superadmin') && !auth()->user()->inGroup('admin')) {
            return redirect()->to('/')->with('error', 'Acceso no permitido'); // Solo admin o superadmin pueden acceder
        }
        $competiciones = $this->model->paginate(10);
        return view('/user/competiciones/index', ['competiciones' => $competiciones, 'pager' => $this->model->pager]);
    }
    public function show($id = null)
    {

        $zonaPescaModel = new ZonaPescaModel();
        $localidadModel = new LocalidadModel();
        $imagenModel = new ImagenModel();
        $imagenes = $imagenModel->getImagenesCompeticion($id);
        $competicion = $this->model->find($id);
        $zonaPesca = $zonaPescaModel->find($competicion->zona_id);
        $localidad = $localidadModel->find($zonaPesca->localidad_id);
        return view('/user/competiciones/show', [
            'competicion' => $competicion,
            'zonaPesca' => $zonaPesca,
            'localidad' => $localidad,
            'imagenes' => $imagenes
        ]);
    }
    public function new()
    {
        if (!auth()->user()->inGroup('superadmin') && !auth()->user()->inGroup('admin')) {
            return redirect()->to('/')->with('error', 'Acceso no permitido'); // Solo admin o superadmin pueden acceder
        }
        return view('/user/competiciones/new');
    }
    public function edit($id = null)
    {
        if (!auth()->user()->inGroup('superadmin') && !auth()->user()->inGroup('admin')) {
            return redirect()->to('/')->with('error', 'Acceso no permitido'); // Solo admin o superadmin pueden acceder
        }
        $zonaPescaModel = new ZonaPescaModel();
        $localidadModel = new LocalidadModel();
        $imagenModel = new ImagenModel();
        $imagenes = $imagenModel->getImagenesCompeticion($id);
        $competicion = $this->model->find($id);
        $zonaPesca = $zonaPescaModel->find($competicion->zona_id);
        $localidad = $localidadModel->find($zonaPesca->localidad_id);
        $localidades = $localidadModel->where('PROVINCIA', $localidad->PROVINCIA)->findAll();
        $zonasPesca = $zonaPescaModel->where('localidad_id', $localidad->id)->findAll();
        return view('/user/competiciones/edit', [
            'competicion' => $competicion,
            'zonaPesca' => $zonaPesca,
            'localidad' => $localidad,
            'localidades' => $localidades,
            'zonasPesca' => $zonasPesca,
            'imagenes' => $imagenes
        ]);
    }
    public function create()
    {
        if (!auth()->user()->inGroup('superadmin') && !auth()->user()->inGroup('admin')) {
            return redirect()->to('/')->with('error', 'Acceso no permitido'); // Solo admin o superadmin pueden acceder
        }

        if ($this->validate('competicion')) {
            $nombre = $this->request->getPost('nombre');
            $fechaInicio = $this->request->getPost('fecha_inicio');
            $fechaFin = $this->request->getPost('fecha_fin');
            $zonaPesca = $this->request->getPost('zonaPesca');
            $descripcion = $this->request->getPost('descripcion');

            $competicionId = $this->model->insert([
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'zona_id' => $zonaPesca,
                'usuario_id' => auth()->user()->id

            ]);
            $imagenesModel = new ImagenModel();
            $imagenCapturaModel = new ImagenCompeticionModel();
            $imagenes = $this->request->getFiles('imagenes');
            foreach ($imagenes['imagenes'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $nombreImagen = $file->getRandomName();
                    $extension = $file->guessExtension();
                    $ruta = '../public/uploads/competiciones';
                    $file->move($ruta, $nombreImagen);

                    // Guardar la imagen en la base de datos
                    $imagenId = $imagenesModel->insert([
                        'imagen' => $nombreImagen,
                        'extension' => $extension
                    ]);

                    // Asociar la imagen con la captura
                    $imagenCapturaModel->insert([
                        'imagen_id' => $imagenId,
                        'competicion_id' => $competicionId,
                    ]);
                }
            }
            return redirect()->to('/user/perfil/misCompeticiones')->with('mensaje', "competicion creada con éxito");
        } else {
            return redirect()->back()->with("error", $this->validator->listErrors())->withInput();
        }
    }
    public function update($id = null)
    {
        if (!auth()->user()->inGroup('superadmin') && !auth()->user()->inGroup('admin')) {
            return redirect()->to('/')->with('error', 'Acceso no permitido'); // Solo admin o superadmin pueden acceder
        }
        if ($this->validate('competicion')) {
            $nombre = $this->request->getPost('nombre');
            $fechaInicio = $this->request->getPost('fecha_inicio');
            $fechaFin = $this->request->getPost('fecha_fin');
            $zonaPesca = $this->request->getPost('zonaPesca');
            $descripcion = $this->request->getPost('descripcion');

            $competicionId = $this->model->update($id, [
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'zona_id' => $zonaPesca

            ]);
            // Manejar la subida de imágenes

            $imagenesModel = new ImagenModel();
            $imagenCompeticionModel = new ImagenCompeticionModel();
            $imagenesCompeticion = $imagenesModel->getImagenesCompeticion($id);
            if ($imagenesCompeticion) {
                foreach ($imagenesCompeticion as $imagen) {

                    $rutaImagen = FCPATH . 'uploads/competiciones/' . $imagen->imagen;
                    unlink($rutaImagen);
                }
            }
            $imagenesModel->deleteImagenesCompeticion($id);
            $imagenes = $this->request->getFiles('imagenes');
            foreach ($imagenes['imagenes'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $nombreImagen = $file->getRandomName();
                    $extension = $file->guessExtension();
                    $ruta = '../public/uploads/competiciones';
                    $file->move($ruta, $nombreImagen);

                    // Guardar la imagen en la base de datos

                    $imagenId = $imagenesModel->insert([
                        'imagen' => $nombreImagen,
                        'extension' => $extension
                    ]);

                    // Asociar la imagen con la Competicion
                    $imagenCompeticionModel->insert([
                        'imagen_id' => $imagenId,
                        'competicion_id' => $id,
                    ]);
                }
            }
            return redirect()->to('/user/perfil/misCompeticiones')->with('mensaje', "competicion actualizada con éxito");
        } else {
            return redirect()->back()->with("error", $this->validator->listErrors())->withInput();
        }
    }
    public function delete($id = null)
    {
        if (!auth()->user()->inGroup('superadmin') && !auth()->user()->inGroup('admin')) {
            return redirect()->to('/')->with('error', 'Acceso no permitido'); // Solo admin o superadmin pueden acceder
        }
        $competicion = $this->model->find($id);
        if ($competicion) {
            $imagenesModel = new ImagenModel();
            $imagenesCompeticion = $imagenesModel->getImagenesCompeticion($id);
            if ($imagenesCompeticion) {
                foreach ($imagenesCompeticion as $imagen) {

                    $rutaImagen = FCPATH . 'uploads/competiciones/' . $imagen->imagen;
                    unlink($rutaImagen);
                }
            }
            $imagenesModel->deleteImagenesCompeticion($id);
            $this->model->delete($id);
            return redirect()->to('/user/competiciones')->with('mensaje', "Competición eliminada con éxito");
        } else {
            return redirect()->back()->with('error', "Error al eliminar la competición");
        }
    }

    public function get_zonasPesca()
    {
        $localidadModel = new LocalidadModel();
        $zonaPescaModel = new ZonaPescaModel();
        $provincia = $this->request->getPost('provincia');
        $localidad = $this->request->getPost('localidad');
        $localidadData = $localidadModel->where('PROVINCIA', $provincia)->where('nombre', $localidad)->first();
        $zonasPescaData = $zonaPescaModel->where('localidad_id', $localidadData->id)->findAll();
        return $this->response->setJSON($zonasPescaData);
    }

    public function verParticipantes($id)
    {
        $participacionModel = new ParticipacionModel();
        $usuarioLogroModel = new UsuarioLogroModel();
        $usuariosLogros = $usuarioLogroModel->where('competicion_id',$id)->findAll();
        $logroModel = new LogroModel();
        $logros = $logroModel->findAll();
        $participantes = $participacionModel->getParticipantes($id);
        return view('/user/competiciones/participantes', ['participantes' => $participantes, 'competicion_id' => $id, 'logros' => $logros,'usuariosLogros'=>$usuariosLogros]);
    }

    public function verParticipaciones($competicionId, $usuarioId)
    {
        $participacionModel = new ParticipacionModel();
        $capturas = $participacionModel->getParticipaciones($competicionId, $usuarioId);
        return view('/user/competiciones/participaciones', ['capturas' => $capturas]);
    }
    public function participar($competicionId, $capturaId)
    {
        $participacionModel = new ParticipacionModel();
        $participacionModel->insert([
            'usuario_id' => 1,
            'competicion_id' => $competicionId,
            'captura_id' => $capturaId
        ]);
    }

    public function otorgarLogro($competicionId, $usuarioId)
    {
        $usuarioLogroModel = new UsuarioLogroModel();
        $logroId = $this->request->getPost('logro');
        if (!is_numeric($logroId)) {
            return redirect()->back()->with('error', 'Debes seleccionar un premio');
        }
        $usuarioLogro = $usuarioLogroModel->where('competicion_id', $competicionId)
            ->where('usuario_id', $usuarioId)
            ->where('logro_id', $logroId)
            ->first();
        if (!$usuarioLogro == null) {
            return redirect()->back()->with('error', 'El usuario ya tiene ese premio asignado');
        }
        $usuarioLogro = $usuarioLogroModel->where('competicion_id', $competicionId)
            ->where('logro_id', $logroId)
            ->first();
        if (!$usuarioLogro == null) {
            return redirect()->back()->with('error', 'Ese premio ya ha sido asignado');
        }
        $usuarioLogro = $usuarioLogroModel->where('competicion_id', $competicionId)
        ->where('usuario_id', $usuarioId)
        ->first();
    if (!$usuarioLogro == null) {
        return redirect()->back()->with('error', 'El usuario ya tiene un premio asignado');
    }
        $usuarioLogroModel->insert([
            'usuario_id' => $usuarioId,
            'logro_id' => $logroId,
            'competicion_id' => $competicionId,
        ]);
        return redirect()->back()->with('mensaje', 'Premio otorgado con éxito');
    }
    public function eliminarLogro($competicionId, $usuarioId,$logroId)
    {
        $usuarioLogroModel = new UsuarioLogroModel();
       
        $usuarioLogro = $usuarioLogroModel->where('competicion_id', $competicionId)
            ->where('usuario_id', $usuarioId)
            ->where('logro_id', $logroId)
            ->first();
        if ($usuarioLogro == null) {
            return redirect()->back()->with('error', 'El usuario no posee premio asignado');
        }
       $usuarioLogroModel->delete($usuarioLogro->id);
        return redirect()->back()->with('mensaje', 'Premio eliminado con éxito');
    }
}
