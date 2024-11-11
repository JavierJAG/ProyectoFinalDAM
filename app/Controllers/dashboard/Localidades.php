<?php

namespace App\Controllers\dashboard;


use CodeIgniter\RESTful\ResourceController;

class Localidades extends ResourceController
{
    protected $modelName = "\App\Models\LocalidadModel";

    public function index()
    {
        // Obtener el campo y la dirección de ordenación desde la URL o usar valores predeterminados
        $campoOrden = $this->request->getGet('campo') ?? 'id'; // Campo de orden por defecto
        $direccionOrden = $this->request->getGet('orden') === 'desc' ? 'desc' : 'asc'; // Dirección de orden por defecto
    
        // Realizar la consulta de localidades aplicando ordenación
        $localidades = $this->model->orderBy($campoOrden, $direccionOrden)->paginate(10);
    
        // Pasar los valores de ordenación a la vista
        return view('/dashboard/localidades/index', [
            'localidades' => $localidades,
            'campoOrden' => $campoOrden,
            'direccionOrden' => $direccionOrden,
            'pager' => $this->model->pager
        ]);
    }
    
    public function show($id = null)
    {
        $localidad = $this->model->find($id);
        return view('/dashboard/localidades/show', ['localidad' => $localidad]);
    }
    public function new()
    {
        return view('/dashboard/localidades/new');
    }
    public function edit($id = null)
    {
        $localidad = $this->model->find($id);
        return view('/dashboard/localidades/edit', ['localidad' => $localidad]);
    }
    public function create()
    {
        if ($this->validate('localidad')) {
            $PROVINCIA = $this->request->getPost('PROVINCIA');
            $nombre = $this->request->getPost('nombre');


            $this->model->insert([
                'nombre' => $nombre,
                'PROVINCIA' => $PROVINCIA,

            ]);
            return redirect()->to('/dashboard/localidades')->with('mensaje', "Localidad creada con éxito");
        } else {
            return redirect()->back()->with("error", $this->validator->listErrors())->withInput();
        }
    }
    public function update($id = null)
    {
        if ($this->validate('localidad')) {
            $PROVINCIA = $this->request->getPost('PROVINCIA');
            $nombre = $this->request->getPost('nombre');


            $this->model->update($id, [
                'nombre' => $nombre,
                'PROVINCIA' => $PROVINCIA,

            ]);
            return redirect()->to('/dashboard/localidades')->with('mensaje', "Localidad actualizada con éxito");
        } else {
            return redirect()->back()->with("error", $this->validator->listErrors())->withInput();
        }
    }
    public function delete($id = null)
    {
        $especie = $this->model->find($id);
        if ($especie) {
            $this->model->delete($id);
            return redirect()->to('/dashboard/localidades')->with('mensaje', "Localidad eliminada con éxito");
        } else {
            return redirect()->back()->with('error', "Error al eliminar la especie");
        }
    }
}
