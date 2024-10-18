<?php

namespace App\Controllers;

class Home extends BaseController
{
    
        public function index(): string
        {
            // URL de la página a la que deseas hacer la solicitud
            $url = 'https://www.xunta.gal/dog/Publicados/2024/20240220/AnuncioG0691-300124-0001_es.html';
        
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
            $table = $xpath->query("//table[@id='table-26']");
        
            // Verifica si se encontró la tabla y almacena su contenido
            $tableContent = '';
            if ($table->length > 0) {
                // Extrae el HTML de la tabla
                $tableContent = $dom->saveHTML($table->item(0));
            } else {
                $tableContent = '<p>No se encontró la tabla.</p>';
            }
        
            // Carga una vista y pasa el contenido de la tabla
            return view('welcome_message', ['tableContent' => $tableContent]);
        }
        
        
}
