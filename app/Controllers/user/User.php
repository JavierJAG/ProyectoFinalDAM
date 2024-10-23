<?php

namespace App\Controllers\user;

use App\Models\CapturaModel;
use App\Models\CompeticionModel;
use App\Models\LogroModel;
use App\Models\ParticipacionModel;
use App\Models\UsuarioLogroModel;
use App\Models\ZonaPescaModel;
use CodeIgniter\RESTful\ResourceController;

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
        $zonasPesca = $zonaPescaModel->where('usuario_id', auth()->user()->id)->paginate(10);
        return view('/user/zonasPesca/index', ['zonasPesca' => $zonasPesca, 'pager' => $zonaPescaModel->pager]);
    }
    public function misCapturas()
    {
        $capturaModel = new CapturaModel();
     
        $search = $this->request->getPost('search'); // Obtener el término de búsqueda
        $order = $this->request->getPost('order'); // Obtener el criterio de ordenación
    
        // Base de la consulta
        $capturasQuery = $capturaModel;
    
        // Filtrar por nombre si hay un término de búsqueda
        if (!empty($search)) {
            $capturasQuery = $capturasQuery->like('nombre', $search);
        }
    
        // Aplicar ordenación según el criterio seleccionado
        switch ($order) {
            case 'peso':
                $capturasQuery = $capturasQuery->orderBy('peso', 'DESC');
                break;
            case 'tamano':
                $capturasQuery = $capturasQuery->orderBy('tamano', 'DESC');
                break;
            default:
                // Ordenar por fecha por defecto
                $capturasQuery = $capturasQuery->orderBy('fecha_captura', 'DESC');
                break;
        }
    
        // Obtener los resultados paginados
        $data = [
            'capturas' => $capturasQuery->paginate(10), // Cambia el número de capturas por página según sea necesario
            'pager' => $capturaModel->pager,
            'search' => $search,
            'order' => $order
        ];
    
        return view('/user/capturas/index', $data);
    }
    public function misLogros()
    {
        $usuarioLogroModel = new UsuarioLogroModel();
        $logros = $usuarioLogroModel->where('usuario_id', auth()->user()->id)->paginate(10);
        return view('/dashboard/logros/index', ['logros' => $logros, 'pager' => $usuarioLogroModel->pager]);
    }
    public function misCompeticiones()
    {
        $competicionModel = new CompeticionModel();
        $competiciones = $competicionModel->where('usuario_id', auth()->user()->id)->paginate(10);
        return view('/user/competiciones/index', ['competiciones' => $competiciones, 'pager' => $competicionModel->pager]);
    }
    public function misParticipaciones()
    {
        $participacionModel = new ParticipacionModel();
        $participaciones = $participacionModel->getUserParticipaciones(auth()->user()->id)->paginate(10);
        return view('/user/competiciones/participaciones', ['participaciones' => $participaciones, 'pager' => $participacionModel->pager]);
    }

    public function verTodasCapturas()
    {
        $capturaModel = new CapturaModel();
        $search = $this->request->getPost('search'); // Obtener el término de búsqueda
        $order = $this->request->getPost('order'); // Obtener el criterio de ordenación
    
        // Base de la consulta
        $capturasQuery = $capturaModel;
    
        // Filtrar por nombre si hay un término de búsqueda
        if (!empty($search)) {
            $capturasQuery = $capturasQuery->like('nombre', $search);
        }
    
        // Aplicar ordenación según el criterio seleccionado
        switch ($order) {
            case 'peso':
                $capturasQuery = $capturasQuery->orderBy('peso', 'DESC');
                break;
            case 'tamano':
                $capturasQuery = $capturasQuery->orderBy('tamano', 'DESC');
                break;
            default:
                // Ordenar por fecha por defecto
                $capturasQuery = $capturasQuery->orderBy('fecha_captura', 'DESC');
                break;
        }
    
        // Obtener los resultados paginados
        $data = [
            'capturas' => $capturasQuery->paginate(10), // Cambia el número de capturas por página según sea necesario
            'pager' => $capturaModel->pager,
            'search' => $search,
            'order' => $order
        ];
        return view('user/capturas/findAllUser', $data);
    }
    public function verTodasCompeticiones()
    {
        $competicionModel = new competicionModel();
        $competiciones = $competicionModel->paginate(10);
        return view('user/competiciones/findAllUser', ['competiciones' => $competiciones, 'pager' => $competicionModel->pager]);
    }
}
