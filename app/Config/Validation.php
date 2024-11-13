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
            'label' => 'Nombre Común',
            'rules' => 'required|regex_match[/^[a-zA-ZÀ-ÿ0-9\s.\-]+$/]',
            'errors' => [
                'required' => 'El nombre común es obligatorio.',
                'regex_match' => 'El nombre común solo puede contener letras, números, espacios, puntos y guiones.'
            ]
        ],
        'nombre_cientifico' => [
            'label' => 'Nombre Científico',
            'rules' => 'permit_empty|regex_match[/^[a-zA-ZÀ-ÿ0-9\s.\-]+$/]',
            'errors' => [
                'permit_empty' => 'El nombre científico puede quedar vacío.',
                'regex_match' => 'El nombre científico solo puede contener letras, números, espacios, puntos y guiones.'
            ]
        ],
        'tamano_minimo' => [
            'label' => 'Tamaño Mínimo',
            'rules' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'errors' => [
                'permit_empty' => 'La talla mínima puede quedar vacía.',
                'numeric' => 'La talla mínima debe ser un valor numérico.',
                'greater_than_equal_to' => 'La talla mínima no puede ser negativa.'
            ]
        ],
        'cupo_maximo' => [
            'label' => 'Cupo Máximo',
            'rules' => 'permit_empty|is_natural|greater_than_equal_to[0]',
            'errors' => [
                'permit_empty' => 'El cupo máximo puede quedar vacío.',
                'is_natural' => 'El cupo máximo debe ser un número entero.',
                'greater_than_equal_to' => 'El cupo máximo no puede ser negativo.'
            ]
        ]
    ];
    // Reglas de validación para la localidad
    public $localidad = [
        'nombre' => [
            'rules' => 'required|alpha_numeric_space',
            'errors' => [
                'required' => 'El nombre de la localidad es obligatorio.',
                'alpha_numeric_space' => 'El nombre de la localidad solo puede contener letras, números y espacios.'
            ]
        ]
    ];

    // Reglas de validación para el logro
    public $logro = [
        'nombre' => [
            'rules' => 'required|regex_match[/^[a-zA-ZÀ-ÿ0-9\s.\-]+$/]',
            'errors' => [
                'required' => 'El nombre del logro es obligatorio.',
                'regex_match' => 'El nombre del logro solo puede contener letras, números, espacios, puntos y guiones.'
            ]
        ],
        'descripcion' => [
            'rules' => 'required|regex_match[/^[a-zA-ZÀ-ÿ0-9\s.\-]+$/]',
            'errors' => [
                'required' => 'La descripción del logro es obligatoria.',
                'regex_match' => 'La descripción del logro solo puede contener letras, números, espacios, puntos y guiones.'
            ]
        ]
    ];

    // Reglas de validación para la zona de pesca
    public $zonaPesca = [
        'nombre' => [
            'rules' => 'required|regex_match[/^[a-zA-ZÀ-ÿ0-9\s.\-]+$/]',
            'errors' => [
                'required' => 'El nombre de la zona de pesca es obligatorio.',
                'regex_match' => 'El nombre de la zona de pesca solo puede contener letras, números, espacios, tildes, puntos y guiones.'
            ]
        ],
        'descripcion' => [
            'rules' => 'permit_empty|regex_match[/^[a-zA-ZÀ-ÿ0-9\s.\-]+$/]',
            'errors' => [
                'regex_match' => 'La descripción de la zona de pesca solo puede contener letras, números, espacios, tildes, puntos y guiones.'
            ]
        ]
    ];

    // Reglas de validación para la captura
    public $captura = [
        'fecha_captura' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'La fecha de captura es obligatoria.'
            ]
        ],
        'nombre' => [
            'rules' => 'required|min_length[3]|regex_match[/^[a-zA-ZÀ-ÿ0-9\s.\-]+$/]',
            'errors' => [
                'required' => 'El nombre de la captura es obligatorio.',
                'min_length' => 'El nombre de la captura debe tener al menos 3 caracteres.',
                'regex_match' => 'El nombre de la captura solo puede contener letras, números, espacios, puntos y guiones.'
            ]
        ],
        'descripcion' => [
            'rules' => 'permit_empty',
            'errors' => [
                'permit_empty' => 'La descripción de la captura puede quedar vacía.'
            ]
        ],
        'tamano' => [
            'rules' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'errors' => [
                'permit_empty' => 'El tamaño puede quedar vacío.',
                'numeric' => 'El tamaño debe ser un valor numérico.',
                'greater_than_equal_to' => 'El tamaño no puede ser negativo.'
            ]
        ],
        'peso' => [
            'rules' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'errors' => [
                'permit_empty' => 'El peso puede quedar vacío.',
                'numeric' => 'El peso debe ser un valor numérico.',
                'greater_than_equal_to' => 'El peso no puede ser negativo.'
            ]
        ],
        'zonaPesca' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'La zona de pesca es obligatoria.'
            ]
        ]
    ];

    // Reglas de validación para la competición
    public $competicion = [
        'nombre' => [
            'rules' => 'required|min_length[3]|regex_match[/^[a-zA-ZÀ-ÿ0-9\s.\-]+$/]',
            'errors' => [
                'required' => 'El nombre de la competición es obligatorio.',
                'min_length' => 'El nombre de la competición debe tener al menos 3 caracteres.',
                'regex_match' => 'El nombre de la competición solo puede contener letras, números, espacios, puntos y guiones.'
            ]
        ],
        'descripcion' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'La descripción de la competición es obligatoria.'
            ]
        ],
        'fecha_inicio' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'La fecha de inicio es obligatoria.'
            ]
        ],
        'fecha_fin' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'La fecha de finalización es obligatoria.'
            ]
        ]
    ];
}
