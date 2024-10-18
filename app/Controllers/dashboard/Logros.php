<?php

namespace App\Controllers\dashboard;


use CodeIgniter\RESTful\ResourceController;

class Logros extends ResourceController
{
    protected $modelName = "\App\Models\LogroModel";

    public function index()
    {
        $logros = $this->model->paginate(10);
        return view('/dashboard/logros/index', ['logros' => $logros, 'pager' => $this->model->pager]);
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
            return redirect()->to('/dashboard/logros')->with('mensaje', "logro creada con éxito");
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
            return redirect()->to('/dashboard/logros')->with('mensaje', "logro actualizada con éxito");
        } else {
            return redirect()->back()->with("error", $this->validator->listErrors())->withInput();
        }
    }
    public function delete($id = null)
    {
        $especie = $this->model->find($id);
        if ($especie) {
            $this->model->delete($id);
            return redirect()->to('/dashboard/logros')->with('mensaje', "logro eliminada con éxito");
        } else {
            return redirect()->back()->with('error', "Error al eliminar la especie");
        }
    }
}
