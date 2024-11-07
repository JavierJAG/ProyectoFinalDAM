<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Images\ImageResource;

class CaptchaController extends Controller
{
    public function generateCaptcha()
    {
        // Generar dos números aleatorios para la suma
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        $answer = $num1 + $num2;

        // Almacenar la respuesta en la sesión para validarla luego
        session()->set('captcha_answer', $answer);

        // Crear la imagen en blanco con un tamaño de 200x60 píxeles
        $width = 200;
        $height = 60;
        $image = imagecreatetruecolor($width, $height);

        // Colores
        $backgroundColor = imagecolorallocate($image, 255, 255, 255); // Blanco
        $textColor = imagecolorallocate($image, 0, 0, 0); // Negro

        // Rellenar el fondo de la imagen
        imagefill($image, 0, 0, $backgroundColor);

        // Escribir el texto en la imagen
        $fontSize = 20;
        $fontPath = FCPATH . 'path_to_your_font_file.ttf'; // Asegúrate de tener una fuente .ttf en tu proyecto
        $text = "$num1 + $num2 = ?";

        // Centrar el texto
        $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
        $x = ($width - ($bbox[2] - $bbox[0])) / 2;
        $y = ($height - ($bbox[5] - $bbox[3])) / 2 + $fontSize;

        imagettftext($image, $fontSize, 0, $x, $y, $textColor, $fontPath, $text);

        // Guardar la imagen en el directorio público
        $captchaImagePath = WRITEPATH . 'uploads/captcha.png';
        imagepng($image, $captchaImagePath); // Guardar la imagen como PNG
        imagedestroy($image); // Liberar recursos

        // Establecer la respuesta como una imagen PNG
        return $this->response->setContentType('image/png')
                             ->setBody(file_get_contents($captchaImagePath));
    }

    // Método para validar la respuesta del captcha
    public function validateCaptcha()
    {
        $input = $this->request->getPost('captcha_answer');
        $captcha_answer = session()->get('captcha_answer');

        if ($input == $captcha_answer) {
            return redirect()->to('/success');  // Si la respuesta es correcta
        } else {
            return redirect()->back()->with('error', 'Respuesta incorrecta.');
        }
    }
}
