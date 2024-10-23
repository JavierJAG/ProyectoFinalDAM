<?php

namespace App\Controllers\user;

use App\Models\FishingEventModel;
use App\Models\ZonaPescaModel;
use CodeIgniter\RESTful\ResourceController;

class Salidas extends ResourceController
{
    protected $modelName = "\App\Models\SalidaModel";
    // Carga la vista del calendario
    public function index()
    {
        return view('/user/salidas/index');
    }

    // Devuelve los eventos guardados en formato JSON
    public function events()
    {
        $zonaModel = new ZonaPescaModel();
        // Obtén todos los eventos de la base de datos
        $events = $this->model->findAll(); // Asegúrate de que este método esté implementado correctamente en tu modelo

        // Arreglo para almacenar los eventos formateados
        $formattedEvents = [];

        foreach ($events as $event) {
            // Asegúrate de que 'fecha_inicio' y 'fecha_fin' tengan el formato adecuado (ISO 8601)
            // También asegúrate de que estás accediendo correctamente a la zona de pesca relacionada con el evento.
    
            $zona = $zonaModel->find($event->zona_id); // Método que necesitas implementar para obtener la zona

            $formattedEvents[] = [
                'id' => $event->id, // Incluye el ID del evento para poder borrarlo después
                'title' => $event->titulo, // Título del evento
                'start' => date('Y-m-d\TH:i:s', strtotime($event->fecha)), // Fecha de inicio en formato ISO 8601
                'extendedProps' => [
                    'zonaId' => $zona->id, // ID de la zona
                    'zonaNombre' => $zona->nombre // Nombre de la zona
                ]
            ];
        }

        // Devuelve los eventos como JSON
        return $this->response->setJSON($formattedEvents);
    }





    // Guarda un evento nuevo
    public function saveEvent()
    {
        $userId = auth()->user()->id;

        $data = [
            'fecha' => $this->request->getPost('fecha'),
            'titulo' => $this->request->getPost('titulo'),
            'usuario_id' => $userId,
            'zona_id' => $this->request->getPost('zona_id')
        ];

        if ($this->model->save($data)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }
    public function deleteEvent()
    {
        $eventId = $this->request->getPost('id'); // Obtiene el ID del evento

        // Asegúrate de que tu modelo tenga un método para eliminar el evento
        if ($this->model->delete($eventId)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }
}
