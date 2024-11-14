<?php

namespace App\Controllers\user;

use App\Models\CapturaModel;
use App\Models\EspecieModel;
use App\Models\ImagenCapturaModel;
use App\Models\ImagenCompeticionModel;
use App\Models\ImagenModel;
use App\Models\LocalidadModel;
use App\Models\LogroModel;
use App\Models\ParticipacionModel;
use App\Models\ParticipanteModel;
use App\Models\UserModel;
use App\Models\UsuarioLogroModel;
use App\Models\ZonaPescaModel;
use CodeIgniter\RESTful\ResourceController;
use DateTime;

class Competiciones extends ResourceController
{
    protected $modelName = "\App\Models\CompeticionModel";

    public function index()
    {
        // Verificación de permisos
        if (!auth()->user()->inGroup('superadmin') && !auth()->user()->inGroup('admin')) {
            return redirect()->to('/')->with('error', 'Acceso no permitido'); // Solo admin o superadmin pueden acceder
        }
    
        // Obtener los parámetros de ordenamiento de la URL
        $campoOrden = $this->request->getGet('campo') ?? 'fecha_inicio'; // Campo de orden por defecto
        $direccionOrden = $this->request->getGet('orden') === 'desc' ? 'desc' : 'asc'; // Dirección de ordenación por defecto
    
        // Consultar competiciones aplicando el ordenamiento
        $competiciones = $this->model->orderBy($campoOrden, $direccionOrden)->paginate(10);
    
        // Pasar los datos a la vista, incluyendo el estado del ordenamiento
        return view('/user/competiciones/index', [
            'competiciones' => $competiciones,
            'campoOrden' => $campoOrden,
            'direccionOrden' => $direccionOrden,
            'pager' => $this->model->pager
        ]);
    }
    
    public function show($id = null)
    {

        $zonaPescaModel = new ZonaPescaModel();
        $localidadModel = new LocalidadModel();
        $usuarioLogroModel = new UsuarioLogroModel();
        $imagenModel = new ImagenModel();
        $participanteModel = new ParticipanteModel();
        $userModel = new UserModel();
        $imagenes = $imagenModel->getImagenesCompeticion($id);
        $competicion = $this->model->find($id);
        $zonaPesca = $zonaPescaModel->find($competicion->zona_id);
        $localidad = $localidadModel->find($zonaPesca->localidad_id);
        $participa = false;
        $participante = $participanteModel->where('competicion_id', $id)->where('usuario_id', auth()->user()->id)->first();
        if ($participante != null) {
            $participa = true;
        }
        $organizador = $userModel->where('id',$competicion->usuario_id)->first();
        $logros = $usuarioLogroModel
            ->select('usuarios_logros.*, logros.nombre AS logro_nombre, logros.descripcion as logro_descripcion,users.id as user_id,users.username as user_username, usuarios_logros.fecha_obtencion AS fecha_obtencion')
            ->join('logros', 'logros.id = usuarios_logros.logro_id')
            ->join('competiciones', 'competiciones.id = usuarios_logros.competicion_id')
            ->join('users', 'users.id = usuarios_logros.usuario_id')
            ->where('usuarios_logros.competicion_id', $id)
            ->findAll();


        $fechaActual = new \DateTime(); // Fecha actual
        $fechaFinCompeticion = new \DateTime($competicion->fecha_fin); // Fecha de fin de la competición

        // Crear una variable booleana que indica si la competición ha finalizado
        $competicionFinalizada = $fechaActual > $fechaFinCompeticion;

        return view('/user/competiciones/show', [
            'competicion' => $competicion,
            'zonaPesca' => $zonaPesca,
            'localidad' => $localidad,
            'imagenes' => $imagenes,
            'logros' => $logros,
            'participa' => $participa,
            'competicionFinalizada' => $competicionFinalizada,
            'organizador'=>$organizador
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

            // Convertir las fechas a objetos DateTime para realizar comparaciones
            $fechaActual = new \DateTime();
            $fechaInicioObj = new \DateTime($fechaInicio);
            $fechaFinObj = new \DateTime($fechaFin);

            // Validar que la fecha de inicio es posterior a la fecha actual
            if ($fechaInicioObj <= $fechaActual) {
                return redirect()->back()->with("error", "La fecha de inicio debe ser posterior a la fecha actual.")->withInput();
            }

            // Validar que la fecha de fin es posterior a la fecha de inicio
            if ($fechaFinObj <= $fechaInicioObj) {
                return redirect()->back()->with("error", "La fecha de fin debe ser posterior a la fecha de inicio.")->withInput();
            }

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

            // Convertir las fechas a objetos DateTime para realizar comparaciones
            $fechaActual = new \DateTime();
            $fechaInicioObj = new \DateTime($fechaInicio);
            $fechaFinObj = new \DateTime($fechaFin);

            // Validar que la fecha de inicio es posterior a la fecha actual
            if ($fechaInicioObj <= $fechaActual) {
                return redirect()->back()->with("error", "La fecha de inicio debe ser posterior a la fecha actual.")->withInput();
            }

            // Validar que la fecha de fin es posterior a la fecha de inicio
            if ($fechaFinObj <= $fechaInicioObj) {
                return redirect()->back()->with("error", "La fecha de fin debe ser posterior a la fecha de inicio.")->withInput();
            }

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
        $zonasPescaData = $zonaPescaModel->where('localidad_id', $localidadData->id)->where('usuario_id', auth()->user()->id)->findAll();
        return $this->response->setJSON($zonasPescaData);
    }

    public function verParticipantes($id)
    {
        $usuarioLogroModel = new UsuarioLogroModel();
        $participanteModel = new ParticipanteModel();
        $competicion = $this->model->find($id);
        $fecha_inicio = new DateTime($competicion->fecha_inicio);
        $fecha_fin = new DateTime($competicion->fecha_fin);
        $fecha_actual = new DateTime();
        $participantes = $participanteModel->getAllParticipantes($id);
        $usuariosLogros = $usuarioLogroModel->where('competicion_id', $id)->findAll();
        $logroModel = new LogroModel();
        $logros = $logroModel->findAll();
        $puedeParticipar = false;
        $mensajeParticipacion = '';

        if ($fecha_actual < $fecha_inicio) {
            $mensajeParticipacion = 'El envío de capturas se abre el ' . $fecha_inicio->format('d/m/Y') . '.';
        } elseif ($fecha_actual > $fecha_fin) {
            $mensajeParticipacion = 'El periodo de envío se ha cerrado el ' . $fecha_fin->format('d/m/Y') . '.';
        } else {
            $puedeParticipar = true;
        }

        return view('/user/competiciones/participantes', [
            'participantes' => $participantes,
            'competicion_id' => $id,
            'logros' => $logros,
            'usuariosLogros' => $usuariosLogros,
            'puedeParticipar' => $puedeParticipar,
            'mensajeParticipacion' => $mensajeParticipacion
        ]);
    }

    public function verParticipaciones($competicionId, $usuarioId)
    {
        $participacionModel = new ParticipacionModel();
        $capturas = $participacionModel->getParticipaciones($competicionId, $usuarioId);
        return view('/user/competiciones/participaciones', ['capturas' => $capturas, 'usuario_id' => $usuarioId, 'competicion_id' => $competicionId]);
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
    public function eliminarLogro($competicionId, $usuarioId, $logroId)
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
    public function participarCompeticion($competicionId)
    {
        $participanteModel = new ParticipanteModel();
        $participante = $participanteModel->where('competicion_id', $competicionId)->where('usuario_id', auth()->user()->id)->first();
        if ($participante != null) {
            return redirect()->back()->with('error', 'Ya estás inscrito a esta competición');
        }
        $participanteModel->insert([
            'usuario_id' => auth()->user()->id,
            'competicion_id' => $competicionId
        ]);
        return redirect()->back()->with('mensaje', 'Te has inscrito a esta competición');
    }
    public function eliminarParticipacionCompeticion($competicionId)
    {
        $participanteModel = new ParticipanteModel();
        $participante = $participanteModel->where('competicion_id', $competicionId)->where('usuario_id', auth()->user()->id)->first();
        if ($participante == null) {
            return redirect()->back()->with('error', 'No estás inscrito a esta competición');
        }
        $participanteModel->delete($participante->id);
        return redirect()->back()->with('mensaje', 'Te has desinscrito a esta competición');
    }
    public function crearParticipacion($competicionId)
    {

        if ($this->validate('captura')) {

            $especieModel = new EspecieModel();
            $participacionModel = new ParticipacionModel();
            $capturaModel = new CapturaModel();

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
            $capturaId = $capturaModel->insert([
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
            $participacionModel->insert([
                'usuario_id' => auth()->user()->id,
                'captura_id' => $capturaId,
                'competicion_id' => $competicionId
            ]);

            return redirect()->back()->with('mensaje', "Participación ingresada con éxito");
        } else {
            return redirect()->back()->with("error", $this->validator->listErrors())->withInput();
        }
    }
    public function anhadirParticipacion($competicionId)
    {

        return view('/user/competiciones/anhadir_participacion', ['competicion_id' => $competicionId]);
    }
}
