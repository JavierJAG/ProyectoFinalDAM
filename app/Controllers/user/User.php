<?php

namespace App\Controllers\user;

use App\Models\CapturaModel;
use App\Models\CompeticionModel;
use App\Models\LocalidadModel;
use App\Models\ParticipanteModel;
use App\Models\UsuarioLogroModel;
use App\Models\ZonaPescaModel;
use CodeIgniter\RESTful\ResourceController;
use DateTime;

class User extends ResourceController
{
    protected $modelName = "\App\Models\UserModel";


    public function index()
    {
        return view('/user/index');
    }

    public function misZonasPesca()
    {
        $zonaPescaModel = new ZonaPescaModel();
        $capturaModel = new CapturaModel();
        $sort = $this->request->getGet('sort') === 'nombre' ? 'nombre' : null;
        $order = $this->request->getGet('order') === 'asc' ? 'asc' : 'desc'; // Valor predeterminado a 'desc'

        // Obtener el modelo de zonas de pesca y seleccionar las columnas necesarias
        $zonasPesca = $zonaPescaModel;

        // Aplica ordenación si se solicita
        if ($sort != null) {
            $zonasPesca = $zonasPesca->orderBy($sort, $order);
        }

        // Obtener las zonas de pesca del usuario
        $zonasPesca = $zonaPescaModel->where('usuario_id', auth()->user()->id)->paginate(10);

        $capturas = []; // Inicializar un array para acumular capturas

        // Iterar sobre cada zona de pesca
        foreach ($zonasPesca as $zp) {
            $capturasZona = $capturaModel->getCapturasZona(auth()->user()->id, $zp->id);
            $capturas = array_merge($capturas, $capturasZona); // Acumular capturas
        }

        return view('/user/zonasPesca/index', [
            'zonasPesca' => $zonasPesca,
            'pager' => $zonaPescaModel->pager,
            'capturas' => $capturas
        ]);
    }
    public function misCapturas()
    {
        $capturaModel = new CapturaModel();
        $zonaPescaModel = new ZonaPescaModel();

        // Obtener los parámetros de ordenación y búsqueda desde la URL o formulario
        $sort = $this->request->getGet('sort') ?: 'fecha_captura';
        $order = $this->request->getGet('order') === 'asc' ? 'asc' : 'desc';
        $search = $this->request->getVar('search');  // Obtener el término de búsqueda desde cualquier fuente
        $zona = $this->request->getVar('zona');      // Obtener la zona desde cualquier fuente

        // Obtener las zonas de pesca
        $zonasPesca = $zonaPescaModel->where('usuario_id', auth()->user()->id)->findAll();

        // Crear la consulta base
        $capturasQuery = $capturaModel->where('capturas.usuario_id', auth()->user()->id);

        // Filtrar por nombre si hay un término de búsqueda
        if (!empty($search)) {
            $capturasQuery = $capturasQuery->like('nombre', $search);
        }

        // Filtrar por zona si se seleccionó alguna
        if (!empty($zona)) {
            $capturasQuery = $capturasQuery->where('zona_id', $zona);
        }

        // Ordenar según el campo y la dirección especificados
        if ($sort === 'zona') {
            $capturasQuery = $capturasQuery->join('zonas_pesca', 'capturas.zona_id = zonas_pesca.id');
            $capturasQuery = $capturasQuery->orderBy('zonas_pesca.nombre', $order);
        } else {
            $capturasQuery = $capturasQuery->orderBy($sort, $order);
        }

        // Obtener los resultados paginados
        $capturas = $capturasQuery->paginate(10);

        // Pasar los datos a la vista
        $data = [
            'capturas' => $capturas,
            'pager' => $capturaModel->pager,
            'search' => $search,
            'order' => $order,
            'zona' => $zona,
            'zonasPesca' => $zonasPesca,
            'sort' => $sort,
        ];

        return view('/user/capturas/index', $data);
    }


    public function buscarCapturas($id)
    {
        $capturaModel = new CapturaModel();

        $sort = $this->request->getGet('sort') ?: 'fecha_captura';
        $order = $this->request->getGet('order') === 'asc' ? 'asc' : 'desc';
        $search = $this->request->getVar('search');

        // Base de la consulta
        $capturasQuery = $capturaModel;

        // Filtrar por nombre si hay un término de búsqueda
        if (!empty($search)) {
            $capturasQuery = $capturasQuery->like('nombre', $search);
        }

        // Aplicar ordenación según el criterio seleccionado
      

        // Obtener los resultados paginados
        $data = [
            'capturas' => $capturasQuery->where('usuario_id', $id)->orderBy($sort,$order)->paginate(10),
            'pager' => $capturaModel->pager,
            'usuario_id'=>$id,
            'search' => $search,
            'order' => $order,
            'sort'=>$sort
        ];

        return view('/user/user/capturas', $data);
    }

    public function misLogros()
    {
        $usuario_id = auth()->user()->id;
        $usuarioLogroModel = new UsuarioLogroModel();

        // Obtener los parámetros de ordenación desde la URL (GET)
        $sort = $this->request->getGet('sort') ?: 'fecha_obtencion'; // Si no se especifica, por defecto ordena por 'fecha_obtencion'
        $order = $this->request->getGet('order') === 'asc' ? 'asc' : 'desc'; // Si no se especifica, por defecto es 'desc'

        // Realiza la consulta para obtener los logros junto con la competición y fecha
        $logrosUsuario = $usuarioLogroModel
            ->select('usuarios_logros.*, logros.descripcion AS logro_descripcion, logros.nombre AS logro_nombre, competiciones.id as competicion_id, competiciones.nombre AS competicion_nombre, usuarios_logros.fecha_obtencion AS fecha_logro')
            ->join('logros', 'logros.id = usuarios_logros.logro_id')
            ->join('competiciones', 'competiciones.id = usuarios_logros.competicion_id')
            ->where('usuarios_logros.usuario_id', auth()->user()->id)
            ->orderBy($sort, $order)
            ->paginate(10);

        return view('/user/user/logros', [
            'logros' => $logrosUsuario,
            'usuario_id' => $usuario_id,
            'pager' => $usuarioLogroModel->pager,
            'sort' => $sort,
            'order' => $order
        ]);
    }


    public function buscarLogros($id)
    {
        $usuarioLogroModel = new UsuarioLogroModel();
        // Obtener los parámetros de ordenación desde la URL (GET)
        $sort = $this->request->getGet('sort') ?: 'fecha_obtencion'; // Si no se especifica, por defecto ordena por 'fecha_obtencion'
        $order = $this->request->getGet('order') === 'asc' ? 'asc' : 'desc'; // Si no se especifica, por defecto es 'desc'
        // Realiza la consulta para obtener los logros junto con la competición y fecha
        $logrosUsuario = $usuarioLogroModel
            ->select('usuarios_logros.*,logros.descripcion AS logro_descripcion, logros.nombre AS logro_nombre, competiciones.nombre AS competicion_nombre, usuarios_logros.fecha_obtencion AS fecha_logro')
            ->join('logros', 'logros.id = usuarios_logros.logro_id')
            ->join('competiciones', 'competiciones.id = usuarios_logros.competicion_id')
            ->where('usuarios_logros.usuario_id', $id)
            ->orderBy($sort, $order)
            ->paginate(10);

        return view('/user/user/logros', [
            'logros' => $logrosUsuario,
            'usuario_id' => $id,
            'sort' => $sort,
            'order' => $order,
            'pager' => $usuarioLogroModel->pager
        ]);
    }
    public function misCompeticiones()
    {
        $competicionModel = new CompeticionModel();
        $competiciones = $competicionModel->where('usuario_id', auth()->user()->id)->paginate(10);
        return view('/user/competiciones/index', ['competiciones' => $competiciones, 'pager' => $competicionModel->pager]);
    }
    public function misParticipaciones()
    {
        $participanteModel = new ParticipanteModel();
        $participaciones = $participanteModel->getParticipantes(auth()->user()->id);
        $fecha_actual = new DateTime();

        return view('/user/competiciones/participacionesUser', ['participaciones' => $participaciones, 'fecha_actual' => $fecha_actual, 'pager' => $participanteModel->pager]);
    }

    public function verTodasCapturas()
    {
        $capturaModel = new CapturaModel();

        // Obtener el término de búsqueda desde el formulario o la URL
        $search = $this->request->getVar('search');

        // Obtener los parámetros de orden y dirección desde la URL (GET)
        $sort = $this->request->getGet('sort') ?: 'fecha_captura'; // Orden predeterminado: 'fecha_captura'
        $order = $this->request->getGet('order') ?: 'desc'; // Dirección predeterminada: 'desc'

        // Base de la consulta
        $capturasQuery = $capturaModel;

        // Filtrar por nombre si hay un término de búsqueda
        if (!empty($search)) {
            $capturasQuery = $capturasQuery->like('nombre', $search);
        }

        // Aplicar la ordenación seleccionada antes de paginar
        $capturasQuery = $capturasQuery->orderBy($sort, $order);

        // Obtener los resultados paginados
        $capturas = $capturasQuery->paginate(10);

        // Preparar los datos para la vista
        $data = [
            'capturas' => $capturas,
            'pager' => $capturaModel->pager,
            'search' => $search,
            'order' => $order,
            'sort' => $sort,
        ];

        return view('/user/capturas/findAllUser', $data);
    }

    public function verTodasCompeticiones()
    {
        $competicionModel = new CompeticionModel();
        $localidadModel = new LocalidadModel();
        $zonaPescaModel = new ZonaPescaModel();

        $today = date('Y-m-d H:i:s'); // Fecha y hora actual
        $provincia = $this->request->getGet('PROVINCIA');
        $localidadSeleccionada = $this->request->getGet('localidad');

        // Obtener todas las provincias y localidades
        $todasProvincias = ['A CORUÑA', 'LUGO', 'OURENSE', 'PONTEVEDRA'];

        // Aplicar filtros sobre localidades si se ha seleccionado una provincia
        $localidadesCompeticion = $localidadModel;
        if (!empty($provincia)) {
            $localidadesCompeticion = $localidadesCompeticion->where('PROVINCIA', $provincia);
        }

        if (!empty($localidadSeleccionada)) {
            $localidadesCompeticion = $localidadesCompeticion->where('nombre', $localidadSeleccionada);
        }

        // Obtener localidades filtradas
        $localidadesCompeticion = $localidadesCompeticion->findAll();

        if (empty($localidadesCompeticion)) {
            // Si no hay localidades, no hay competiciones
            return view('user/competiciones/findAllUser', [
                'competicionesActivas' => [],
                'competicionesFinalizadas' => [],
                'localidades' => [],
                'provinciaSeleccionada' => $provincia,
                'localidadSeleccionada' => $localidadSeleccionada,
                'todasProvincias' => $todasProvincias
            ]);
        }

        // Extraer los IDs de las localidades
        $localidadIds = array_column($localidadesCompeticion, 'id');

        // Obtener zonas de pesca asociadas a esas localidades
        $zonasPesca = $zonaPescaModel->whereIn('localidad_id', $localidadIds)->findAll();

        if (empty($zonasPesca)) {
            // Si no hay zonas de pesca, no hay competiciones
            return view('user/competiciones/findAllUser', [
                'competicionesActivas' => [],
                'competicionesFinalizadas' => [],
                'localidades' => $localidadesCompeticion,
                'provinciaSeleccionada' => $provincia,
                'localidadSeleccionada' => $localidadSeleccionada,
                'todasProvincias' => $todasProvincias
            ]);
        }

        // Extraer los IDs de las zonas de pesca
        $zonaPescaIds = array_column($zonasPesca, 'id');

        // Obtener competiciones asociadas a esas zonas de pesca
        $competiciones = $competicionModel->whereIn('zona_id', $zonaPescaIds)->findAll();

        // Arreglos para competiciones activas y finalizadas
        $competicionesActivas = [];
        $competicionesFinalizadas = [];

        foreach ($competiciones as $competicion) {
            if ($competicion->fecha_fin > $today) {
                // Competición activa
                $competicionesActivas[] = $competicion;
            } else {
                // Competición finalizada
                $competicionesFinalizadas[] = $competicion;
            }
        }

        // Pasar los datos a la vista, incluyendo la provincia y localidad seleccionadas
        return view('user/competiciones/findAllUser', [
            'competicionesActivas' => $competicionesActivas,
            'competicionesFinalizadas' => $competicionesFinalizadas,
            'localidades' => $localidadesCompeticion,
            'provinciaSeleccionada' => $provincia,
            'localidadSeleccionada' => $localidadSeleccionada,
            'todasProvincias' => $todasProvincias
        ]);
    }
    public function buscar()
    {
        $nombre = $this->request->getGet('buscar');
        $userModel = model('UserModel');

        // Busca los usuarios
        $usuarios = $userModel;
        if (!empty($nombre)) {
            $usuarios =  $usuarios->like('username', $nombre);
        }
        $usuarios = $usuarios->findAll();
        // Retorna la vista con los usuarios encontrados
        return view('/user/user/busqueda', ['usuarios' => $usuarios]);
    }

    public function verPerfil($id)
    {
        $userModel = model('UserModel');
        $usuario = $userModel->find($id);

        // Verifica si el usuario existe
        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usuario no encontrado');
        }

        return view('/user/user/perfil', ['usuario' => $usuario]);
    }
    public function updateProfile()
    {
        $name = $this->request->getPost('name');
        if (empty($name)) {
            return redirect()->back();
        } else {
            $userModel = model('UserModel');
            $userModel->update(auth()->user()->id, [
                'nombre' => $name
            ]);
        }
        return redirect()->to('/user/perfil');
    }
    public function changePasswordForm()
    {
        return view('/user/user/change_password');
    }
    public function changePassword()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }

        $userModel = model('UserModel');
        $user = auth()->user();

        /**
         * 
         * Esta parte está sacada de indagar en los archivos de shield de la carpeta vendor
         */
        // Verificar la contraseña actual
        $passwords = service('passwords');


        if (! $passwords->verify($this->request->getPost('current_password'), $user->password_hash)) {
            return redirect()->back()->with('error', 'La contraseña actual es incorrecta.');
        }

        // Actualizar la contraseña
        $user->password_hash = $passwords->hash($this->request->getPost('new_password'));
        $userModel->save($user);

        return redirect()->to('/user/perfil')->with('mensaje', 'Contraseña cambiada exitosamente.');
    }
}
