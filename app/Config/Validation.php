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
        'nombre_comun' => 'required|alpha_numeric_space',
        'nombre_cientifico' => 'permit_empty|alpha_numeric_space',
        'talla_minima' => 'permit_empty|numeric|greater_than_equal_to[0]',
        'cupo_maximo' => 'permit_empty|is_natural|greater_than_equal_to[0]'
    ];
    public $localidad = [
        'nombre' => 'required|alpha_numeric_space',
        'nombre' => 'required'
    ];
    public $logro = [
        'nombre' => 'required|alpha_numeric_space',
        'descripcion' => 'required'
    ];
    public $zonaPesca = [
        'nombre' => 'required|alpha_numeric_space',
    ];
    public $captura = [
        'fecha_captura' => 'required',
        'nombre' => 'required|min_length[3]',
    ];
    public $competicion = [
        'nombre' => 'required|min_length[3]'
    ];
}
