<?php

namespace App\Controllers\dashboard;


use CodeIgniter\RESTful\ResourceController;

class Logros extends ResourceController
{
    protected $modelName = "\App\Models\LogroModel";

    public function index()
    {
        // Obtener el campo y la dirección de ordenación desde la URL, con valores predeterminados
        $campoOrden = $this->request->getGet('campo') ?? 'id'; // Campo de orden predeterminado
        $direccionOrden = $this->request->getGet('orden') === 'desc' ? 'desc' : 'asc'; // Dirección de orden predeterminada
    
        // Consulta de logros con la ordenación seleccionada
        $logros = $this->model->orderBy($campoOrden, $direccionOrden)->paginate(10);
    
        // Pasar la ordenación a la vista
        return view('/dashboard/logros/index', [
            'logros' => $logros,
            'campoOrden' => $campoOrden,
            'direccionOrden' => $direccionOrden,
            'pager' => $this->model->pager
        ]);
    }
    
    public function show($id = null)
    {
        $logro = $this->model->find($id);
        return view('/dashboard/logros/show', ['logro' => $logro]);
    }
    public function new()
    {
        return view('/dashboard/logros/new');
    }
    public function edit($id = null)
    {
        $logro = $this->model->find($id);
        return view('/dashboard/logros/edit', ['logro' => $logro]);
    }
    public function create()
    {
        if ($this->validate('logro')) {
            $descripcion = $this->request->getPost('descripcion');
            $nombre = $this->request->getPost('nombre');


            $this->model->insert([
                'nombre' => $nombre,
                'descripcion' => $descripcion,

            ]);
            return redirect()->to('/dashboard/logros')->with('mensaje', "logro creado con éxito");
        } else {
            return redirect()->back()->with("error", $this->validator->listErrors())->withInput();
        }
    }
    public function update($id = null)
    {
        if ($this->validate('logro')) {
            $descripcion = $this->request->getPost('descripcion');
            $nombre = $this->request->getPost('nombre');


            $this->model->update($id, [
                'nombre' => $nombre,
                'descripcion' => $descripcion,

            ]);
            return redirect()->to('/dashboard/logros')->with('mensaje', "logro actualizado con éxito");
        } else {
            return redirect()->back()->with("error", $this->validator->listErrors())->withInput();
        }
    }
    public function delete($id = null)
    {
        $especie = $this->model->find($id);
        if ($especie) {
            $this->model->delete($id);
            return redirect()->to('/dashboard/logros')->with('mensaje', "logro eliminado con éxito");
        } else {
            return redirect()->back()->with('error', "Error al eliminar la especie");
        }
    }
}
