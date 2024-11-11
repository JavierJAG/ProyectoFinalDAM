<?php

namespace App\Controllers\dashboard;

use App\Models\EspecieModel;
use App\Models\ImagenEspecieModel;
use App\Models\ImagenModel;
use CodeIgniter\RESTful\ResourceController;

class Especies extends ResourceController
{
    protected $modelName = "\App\Models\EspecieModel";

    public function index()
    {
        // Obtener el campo y la dirección de ordenamiento de los parámetros de la URL
        $campoOrden = $this->request->getGet('campo') ?? 'id'; // Campo de orden por defecto
        $direccionOrden = $this->request->getGet('orden') === 'desc' ? 'desc' : 'asc'; // Dirección de orden por defecto
    
        // Consultar las especies ordenadas según los parámetros
        $especies = $this->model->orderBy($campoOrden, $direccionOrden)->findAll();
    
        // Pasar los datos a la vista
        return view('/dashboard/especies/index', [
            'especies' => $especies,
            'campoOrden' => $campoOrden,
            'direccionOrden' => $direccionOrden
        ]);
    }
    
    public function show($id = null)
    {
        $especie = $this->model->find($id);
        $imagenModel = new ImagenModel();
        $imagenes = $imagenModel->getImagenesEspecie($id);
        return view('/dashboard/especies/show', ['especie' => $especie, 'imagenes' => $imagenes]);
    }
    public function new()
    {
        return view('/dashboard/especies/new');
    }
    public function edit($id = null)
    {
        $imagenesModel = new ImagenModel();
        $especie = $this->model->find($id);
        $imagenes = $imagenesModel->getImagenesEspecie($id);
        return view('/dashboard/especies/edit', [
            'especie' => $especie,
            'imagenes' => $imagenes
        ]);
    }
    public function create()
    {
        if ($this->validate('especie')) {
            $nombre_comun = $this->request->getPost('nombre_comun');
            $nombre_cientifico = $this->request->getPost('nombre_cientifico');
            $tamano_minimo = $this->request->getPost('tamano_minimo');
            $cupo_maximo = $this->request->getPost('cupo_maximo');
            if($tamano_minimo==null){
                $tamano_minimo=0;
            }
            if($cupo_maximo==null){
                $cupo_maximo=0;
            }

            $especieId = $this->model->insert([
                'nombre_comun' => $nombre_comun,
                'nombre_cientifico' => $nombre_cientifico,
                'tamano_minimo' => $tamano_minimo,
                'cupo_maximo' => $cupo_maximo
            ]);
            // Manejar la subida de imágenes

            $imagenesModel = new ImagenModel();
            $imagenEspecieModel = new ImagenEspecieModel();
            $imagenes = $this->request->getFiles('imagenes');
            foreach ($imagenes['imagenes'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $nombreImagen = $file->getRandomName();
                    $extension = $file->guessExtension();
                    $ruta = '../public/uploads/especies';
                    $file->move($ruta, $nombreImagen);

                    // Guardar la imagen en la base de datos
                    $imagenId = $imagenesModel->insert([
                        'imagen' => $nombreImagen,
                        'extension' => $extension
                    ]);

                    // Asociar la imagen con la especie
                    $imagenEspecieModel->insert([
                        'imagen_id' => $imagenId,
                        'especie_id' => $especieId,
                    ]);
                }
            }

            return redirect()->to('/dashboard/especies')->with('mensaje', "Especie creada con éxito");
        } else {
            return redirect()->back()->with("error", $this->validator->listErrors())->withInput();
        }
    }

    public function update($id = null)
    {
        if ($this->validate('especie')) {
            $nombre_comun = $this->request->getPost('nombre_comun');
            $nombre_cientifico = $this->request->getPost('nombre_cientifico');
            $tamano_minimo = $this->request->getPost('tamano_minimo');
            $cupo_maximo = $this->request->getPost('cupo_maximo');
            if($tamano_minimo==null){
                $tamano_minimo=0;
            }
            if($cupo_maximo==null){
                $cupo_maximo=0;
            }

            $this->model->update($id, [
                'nombre_comun' => $nombre_comun,
                'nombre_cientifico' => $nombre_cientifico,
                'tamano_minimo' => $tamano_minimo,
                'cupo_maximo' => $cupo_maximo
            ]);
            // Manejar la subida de imágenes

            $imagenesModel = new ImagenModel();
            $imagenEspecieModel = new ImagenEspecieModel();
            $imagenesEspecie = $imagenesModel->getImagenesEspecie($id);
            if ($imagenesEspecie) {
                foreach ($imagenesEspecie as $imagen) {

                    $rutaImagen = FCPATH . 'uploads/especies/' . $imagen->imagen;
                    unlink($rutaImagen);
                }
            }
            $imagenesModel->deleteImagenesEspecie($id);
            $imagenes = $this->request->getFiles('imagenes');
            foreach ($imagenes['imagenes'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $nombreImagen = $file->getRandomName();
                    $extension = $file->guessExtension();
                    $ruta = '../public/uploads/especies';
                    $file->move($ruta, $nombreImagen);

                    // Guardar la imagen en la base de datos
                   
                    $imagenId = $imagenesModel->insert([
                        'imagen' => $nombreImagen,
                        'extension' => $extension
                    ]);

                    // Asociar la imagen con la especie
                    $imagenEspecieModel->insert([
                        'imagen_id' => $imagenId,
                        'especie_id' => $id,
                    ]);
                }
            }
            return redirect()->to('/dashboard/especies')->with('mensaje', "Especie actualizada con éxito");
        } else {
            return redirect()->back()->with("error", $this->validator->listErrors())->withInput();
        }
    }
    public function delete($id = null)
    {
        $especie = $this->model->find($id);
        if ($especie) {
            $imagenesModel = new ImagenModel();
            $imagenesEspecie = $imagenesModel->getImagenesEspecie($id);
            if ($imagenesEspecie) {
                foreach ($imagenesEspecie as $imagen) {

                    $rutaImagen = FCPATH . 'uploads/especies/' . $imagen->imagen;
                    unlink($rutaImagen);
                }
            }
            $imagenesModel->deleteImagenesEspecie($id);
            $this->model->delete($id);
            return redirect()->to('/dashboard/especies')->with('mensaje', "Especie eliminada con éxito");
        } else {
            return redirect()->back()->with('error', "Error al eliminar la especie");
        }
    }
}
