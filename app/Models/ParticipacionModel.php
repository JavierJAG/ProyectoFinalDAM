<?php

namespace App\Models;

use CodeIgniter\Model;

class ParticipacionModel extends Model
{
    protected $table            = 'participaciones';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['usuario_id', 'captura_id', 'competicion_id'];

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

    public function getParticipantes($competicionId)
    {
        return $this->select('users.*')
            ->join('users','users.id = participaciones.usuario_id')
            ->where('competicion_id', $competicionId)
            ->groupBy('usuario_id')
            ->findAll();
    }
    public function getParticipaciones($competicionId, $usuarioId)
    {
        return $this->select('capturas.*')
            ->join('capturas', 'capturas.id = participaciones.captura_id')
            ->where('participaciones.usuario_id', $usuarioId)
            ->where('participaciones.competicion_id', $competicionId)
            ->findAll();
    }
}
