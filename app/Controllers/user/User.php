<?php

namespace App\Controllers\user;

use App\Models\CapturaModel;
use App\Models\CompeticionModel;
use App\Models\LogroModel;
use App\Models\ParticipacionModel;
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
        $capturas = $capturaModel->where('usuario_id', auth()->user()->id)->paginate(10);
        return view('/user/capturas/index', ['capturas' => $capturas, 'pager' => $capturaModel->pager]);
    }
    public function misLogros()
    {
        $logroModel = new LogroModel();
        $logros = $logroModel->where('usuario_id', auth()->user()->id)->paginate(10);
        return view('/dashboard/logros/index', ['logros' => $logros, 'pager' => $logroModel->pager]);
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
        $capturas = $capturaModel->paginate(10);
        return view('user/capturas/findAllUser', ['capturas' => $capturas, 'pager' => $capturaModel->pager]);
    }
    public function verTodasCompeticiones()
    {
        $competicionModel = new competicionModel();
        $competiciones = $competicionModel->paginate(10);
        return view('user/competiciones/findAllUser', ['competiciones' => $competiciones, 'pager' => $competicionModel->pager]);
    }
}
