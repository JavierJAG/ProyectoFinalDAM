<?php

namespace App\Controllers\user;

use App\Models\CapturaModel;
use App\Models\LocalidadModel;
use App\Models\zonaPescaModel;
use CodeIgniter\RESTful\ResourceController;

class ZonasPesca extends ResourceController
{
    protected $modelName = "\App\Models\ZonaPescaModel";

    public function index()
    {
        $zonasPesca = $this->model->paginate(10);
        $capturaModel = new CapturaModel();

        $capturas = []; 

       
        foreach ($zonasPesca as $zp) {
            $capturasZona = $capturaModel->getCapturasZona(auth()->user()->id, $zp->id);
            $capturas = array_merge($capturas, $capturasZona); 
        }
        return view('/user/zonasPesca/index', ['zonasPesca' => $zonasPesca,'capturas'=>$capturas, 'pager' => $this->model->pager]);
    }
    public function show($id = null)
    {
        $userModel = model('UserModel');
        $zonaPesca = $this->model->find($id);
        $localidadModel = new LocalidadModel();
        $localidad = $localidadModel->find($zonaPesca->localidad_id);
        $usuario = $userModel->find($zonaPesca->usuario_id);
        return view('/user/zonasPesca/show', ['zonaPesca' => $zonaPesca,'usuario'=>$usuario, 'localidad' => $localidad]);
    }
    public function new()
    {
        return view('/user/zonasPesca/new');
    }
    public function edit($id = null)
    {
        $zonaPesca = $this->model->find($id);
        $localidadModel = new LocalidadModel();
        $localidad = $localidadModel->find($zonaPesca->localidad_id);
        $localidades = $localidadModel->where('PROVINCIA', $localidad->PROVINCIA)->findAll();
        return view('/user/zonasPesca/edit', ['zonaPesca' => $zonaPesca, 'localidad' => $localidad, 'localidades' => $localidades]);
    }
    public function create()
    {
        if ($this->validate('zonaPesca')) {
            $nombre = $this->request->getPost('nombre');
            $descripcion = $this->request->getPost('descripcion');
    


            $PROVINCIA = $this->request->getPost('PROVINCIA');
            $localidad = $this->request->getPost('localidad');



            $localidadModel = new LocalidadModel();
            $localidadData = $localidadModel->where('PROVINCIA', $PROVINCIA)->where('nombre', $localidad)->first();

            // Verificar que se obtuvo la localidad
            if (!$localidadData) {
                return redirect()->back()->with("error", "La localidad especificada no existe.")->withInput();
            }
            // Realizar la inserción en la base de datos
            $this->model->insert([
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'localidad_id' => $localidadData->id,
                'usuario_id'=>auth()->user()->id
            ]);

            return redirect()->to('/user/perfil/misZonasPesca')->with('mensaje', "Zona de pesca creada con éxito");
        } else {
            return redirect()->back()->with("error", $this->validator->listErrors())->withInput();
        }

        // Si la validación falla, redirigir con errores
        return redirect()->back()->with("error", $this->validator->listErrors())->withInput();
    }


    public function update($id = null)
    {
        if ($this->validate('zonaPesca')) {
            $nombre = $this->request->getPost('nombre');
            $descripcion = $this->request->getPost('descripcion');


            $PROVINCIA = $this->request->getPost('PROVINCIA');
            $localidad = $this->request->getPost('localidad');

            



            $localidadModel = new LocalidadModel();
            $localidadData = $localidadModel->where('PROVINCIA', $PROVINCIA)->where('nombre', $localidad)->first();

            // Verificar que se obtuvo la localidad
            if (!$localidadData) {
                return redirect()->back()->with("error", "La localidad especificada no existe.")->withInput();
            }

            // Realizar la inserción en la base de datos
            $this->model->update($id, [
                'nombre' => $nombre,
                'descripcion' => $descripcion,
               
                'localidad_id' => $localidadData->id,
            ]);

            return redirect()->to('/user/perfil/misZonasPesca')->with('mensaje', "Zona de pesca actualizada con éxito");
        } else {
            return redirect()->back()->with("error", "Las coordenadas deben ser números válidos en el rango correcto.")->withInput();
        }


        // Si la validación falla, redirigir con errores
        return redirect()->back()->with("error", $this->validator->listErrors())->withInput();
    }
    public function delete($id = null)
    {
        $especie = $this->model->find($id);
        if ($especie) {
            $this->model->delete($id);
            return redirect()->to('/user/perfil/misZonasPesca')->with('mensaje', "zonaPesca eliminada con éxito");
        } else {
            return redirect()->back()->with('error', "Error al eliminar la especie");
        }
    }

    public function getLocalidades()
    {
        $provincia = $this->request->getPost('provincia');


        $localidadModel = new LocalidadModel();

        // Obtener zonaPescaes de la base de datos según la provincia
        $localidad = $localidadModel->where('PROVINCIA', $provincia)->findAll();

        // Devolver como JSON
        return $this->response->setJSON($localidad);
    }
    public function verModalZonaPesca($id)
{
    $zona = $this->model->find($id); 
    $localidadModel= new LocalidadModel();
    $localidad= $localidadModel->where('id',$zona->localidad_id)->first();

    if ($zona) {
        return $this->response->setJSON([
            'success' => true,
            'zona' => [
                'nombre' => $zona->nombre,
                'descripcion' => $zona->descripcion,
                'provincia' => $localidad->PROVINCIA,
                'localidad'=>$localidad->nombre
            ]
        ]);
    } else {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Zona no encontrada'
        ]);
    }
}

}
