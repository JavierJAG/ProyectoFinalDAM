<?php

namespace App\Models;

use CodeIgniter\Model;

class CapturaModel extends Model
{
    protected $table            = 'capturas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['fecha_captura', 'nombre', 'peso', 'tamano', 'descripcion', 'usuario_id', 'especie_id', 'imagen_id', 'zona_id'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getCapturasZona($userId, $zonaPescaId)
    {
        return $this->select('capturas.*')
            ->join('zonas_pesca', 'zonas_pesca.id=capturas.zona_id')
            ->where('capturas.usuario_id', $userId)
            ->where('capturas.zona_id', $zonaPescaId)
            ->findAll();
    }
}
