<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RolFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $auth = service('auth'); // O el servicio que estés usando para autenticación

        // Verifica si el usuario está logueado
        if (!$auth->loggedIn()) {
            return redirect()->to('/'); // Redirige al índice si no está logueado
        }

        $user = auth()->user(); // Obtiene el usuario actual

        // Lógica de acceso basado en roles
        // Asumiendo que el rol del usuario está en la propiedad `role`

        // Verifica si la ruta solicitada requiere un rol específico
        $path = $request->getUri()->getPath();

        if (strpos($path, 'dashboard') !== false) {
            if (!$user->inGroup('superadmin')) {
                return redirect()->to('/'); // Redirige si no es superadmin
            }
        } 

    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}