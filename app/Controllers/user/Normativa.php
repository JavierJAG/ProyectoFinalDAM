<?php

namespace App\Controllers\user;

use App\Controllers\BaseController;
use App\Models\EspecieModel;
use App\Models\ImagenModel;

class Normativa extends BaseController
{
    public function index()
    {
        $provincia = $this->request->getGet('provincia');
        $tableContent = $this->getContent($provincia);

        // Carga una vista y pasa el contenido de la tabla
        return view('/user/normativa/normativa', ['tableContent' => $tableContent, 'provincia' => $provincia]);
    }

    public function getContent($provincia)
    {
        // URL de la página a la que deseas hacer la solicitud
        $url = 'https://www.xunta.gal/dog/Publicados/2024/20240220/AnuncioG0691-300124-0001_es.html';

        $tablaId = null;
        switch ($provincia) {
            case 'A CORUÑA':
                $tablaId = "//table[@id='table-26']";
                break;
            case 'LUGO':
                $tablaId = "//table[@id='table-27']";
                break;
            case 'OURENSE':
                $tablaId = "//table[@id='table-28']";
                break;
            case 'PONTEVEDRA':
                $tablaId = "//table[@id='table-29']";
                break;

            default:
                $tablaId = "//table[@id='table-26']";
                break;
        }

        // Inicializa cURL usando la librería HTTP\CURLRequest de CodeIgniter
        $client = \Config\Services::curlrequest();

        // Realiza la solicitud GET
        $response = $client->get($url);

        // Obtiene el contenido de la página
        $htmlContent = $response->getBody();

        // Procesa el contenido HTML usando DOMDocument
        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlContent);

        // Utiliza XPath para encontrar la tabla con el ID 'table-26'
        $xpath = new \DOMXPath($dom);
        $table = $xpath->query($tablaId);

        // Verifica si se encontró la tabla y almacena su contenido
        $tableContent = '';
        if ($table->length > 0) {
            // Extrae el HTML de la tabla
            $tableContent = $dom->saveHTML($table->item(0));
        } else {
            $tableContent = '<p>No se encontró la tabla.</p>';
        }
        return $tableContent;
    }
    public function listarEspecies(){
        $especieModel = new EspecieModel();
        $especies = $especieModel;
        $search = $this->request->getGet("search");
        if ($search) {
            $especies = $especieModel
                ->like('nombre_comun', $search)
                ->orLike('nombre_cientifico', $search)
                ->findAll();
        } else {
            $especies = $especieModel->findAll();
        }
        return view('/user/especies/lista', ['especies' => $especies,'search' => $search]);
    }
    public function detalleEspecie($especieId){
        $especieModel = new EspecieModel();
        $especie = $especieModel->find($especieId);
        $imagenModel = new ImagenModel();
        $imagenes = $imagenModel->getImagenesEspecie($especieId);
        return view('/user/especies/detalles', ['especie' => $especie, 'imagenes' => $imagenes]);
    }
}
