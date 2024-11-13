<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        \Denis303\ReCaptcha\Validation\ReCaptchaRules::class
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    
    public $especie = [
        'nombre_comun' => [
            'required' => 'El nombre común es obligatorio.',
            'regex_match' => 'El nombre común solo puede contener letras, números, espacios, puntos y guiones.'
        ],
        'nombre_cientifico' => [
            'permit_empty' => 'El nombre científico puede quedar vacío.',
            'regex_match' => 'El nombre científico solo puede contener letras, números, espacios, puntos y guiones.'
        ],
        'talla_minima' => [
            'permit_empty' => 'La talla mínima puede quedar vacía.',
            'numeric' => 'La talla mínima debe ser un valor numérico.',
            'greater_than_equal_to' => 'La talla mínima no puede ser negativa.'
        ],
        'cupo_maximo' => [
            'permit_empty' => 'El cupo máximo puede quedar vacío.',
            'is_natural' => 'El cupo máximo debe ser un número entero.',
            'greater_than_equal_to' => 'El cupo máximo no puede ser negativo.'
        ]
    ];
    
    public $localidad = [
        'nombre' => [
            'required' => 'El nombre de la localidad es obligatorio.',
            'alpha_numeric_space' => 'El nombre de la localidad solo puede contener letras, números y espacios.'
        ]
    ];
    
    public $logro = [
        'nombre' => [
            'required' => 'El nombre del logro es obligatorio.',
            'regex_match' => 'El nombre del logro solo puede contener letras, números, espacios, puntos y guiones.'
        ],
        'descripcion' => [
            'required' => 'La descripción del logro es obligatoria.',
            'regex_match' => 'La descripción solo puede contener letras, números, espacios, puntos y guiones.'
        ]
    ];
    
    public $zonaPesca = [
        'nombre' => [
            'required' => 'El nombre de la zona de pesca es obligatorio.',
            'regex_match' => 'El nombre solo puede contener letras, números, espacios, puntos y guiones.'
        ],
        'descripcion' => [
            'permit_empty' => 'La descripción puede quedar vacía.',
            'regex_match' => 'La descripción solo puede contener letras, números, espacios, puntos y guiones.'
        ]
    ];
    
    public $captura = [
        'fecha_captura' => [
            'required' => 'La fecha de captura es obligatoria.'
        ],
        'nombre' => [
            'required' => 'El nombre de la captura es obligatorio.',
            'min_length' => 'El nombre de la captura debe tener al menos 3 caracteres.',
            'regex_match' => 'El nombre de la captura solo puede contener letras, números, espacios, puntos y guiones.'
        ],
        'descripcion' => [
            'permit_empty' => 'La descripción puede quedar vacía.'
        ],
        'tamano' => [
            'permit_empty' => 'El tamaño puede quedar vacío.',
            'numeric' => 'El tamaño debe ser un valor numérico.',
            'greater_than_equal_to' => 'El tamaño no puede ser negativo.'
        ],
        'peso' => [
            'permit_empty' => 'El peso puede quedar vacío.',
            'numeric' => 'El peso debe ser un valor numérico.',
            'greater_than_equal_to' => 'El peso no puede ser negativo.'
        ],
        'zonaPesca' => [
            'required' => 'La zona de pesca es obligatoria.'
        ]
    ];
    
    public $competicion = [
        'nombre' => [
            'required' => 'El nombre de la competición es obligatorio.',
            'min_length' => 'El nombre de la competición debe tener al menos 3 caracteres.',
            'regex_match' => 'El nombre de la competición solo puede contener letras, números, espacios, puntos y guiones.'
        ],
        'descripcion' => [
            'required' => 'La descripción de la competición es obligatoria.'
        ],
        'fecha_inicio' => [
            'required' => 'La fecha de inicio de la competición es obligatoria.'
        ],
        'fecha_fin' => [
            'required' => 'La fecha de fin de la competición es obligatoria.'
        ]
    ];
    
}
