<?php

namespace App\Controllers\dashboard;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Administracion extends BaseController
{

    function index()
    {
        return view("/dashboard/administracion/index");
    }
    public function gestionUsuarios()
    {
        $userModel = model(UserModel::class);
        $usuarios = $userModel->findAll();
        $usuariosFiltrados = [];

        foreach ($usuarios as $usuario) {
            if (!in_array('superadmin', $usuario->getGroups())) {
                $usuariosFiltrados[] = $usuario;
            }
        }

        return view("/dashboard/administracion/gestionUsuarios", ['usuarios' => $usuariosFiltrados]);
    }

    public function addAdmin()
    {
        // Obtén el userId desde los datos del POST
        $data = $this->request->getPost();
        $userId = isset($data['userId']) ? intval($data['userId']) : null;

        // Verifica si se proporcionó un userId válido
        if ($userId === null) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID de usuario no válido.']);
        }

        // Cargar el modelo
        $userModel = model(UserModel::class);
        $user = $userModel->find($userId); // Usa 'find' para buscar el usuario

        // Verificar si el usuario existe
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'Usuario no encontrado.']);
        }

        // Si $user es un array, convierte a objeto si es necesario
        if (is_array($user)) {
            $user = (object) $user; // Convierte a objeto
        }

        // Añadir el usuario al grupo "admin"
        $user->addGroup('admin');

        return $this->response->setJSON(['success' => true]);
    }


    public function removeAdmin()
    {
        // Obtén los datos del POST
        $data = $this->request->getPost();
        $userId = isset($data['userId']) ? intval($data['userId']) : null;

        // Verifica si se proporcionó un userId válido
        if ($userId === null) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID de usuario no válido.']);
        }

        // Cargar el modelo
        $userModel = model(UserModel::class);
        $user = $userModel->find($userId); // Usa 'find' para buscar el usuario

        // Verificar si el usuario existe
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'Usuario no encontrado.']);
        }

        // Si $user es un array, convierte a objeto si es necesario
        if (is_array($user)) {
            $user = (object) $user; // Convierte a objeto
        }

        // Quitar el usuario del grupo "admin"
        $user->removeGroup('admin');

        return $this->response->setJSON(['success' => true]);
    }

    public function eliminarUsuario($id){
        $userModel = model(UserModel::class);
        $userModel->delete($id,true);
        return redirect()->back()->with('mensaje','Usuario eliminado con éxito');
    }
}
