<?php

namespace App\Models;

use CodeIgniter\Model;

class ParticipanteModel extends Model
{
    protected $table            = 'participantes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['usuario_id','competicion_id'];

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

   
    public function getParticipantes($usuarioId)
    {
        return $this->select('competiciones.id as competicion_id,competiciones.fecha_inicio as fecha_inicio, competiciones.fecha_fin as fecha_fin, competiciones.nombre as nombre,participantes.usuario_id as id')
            ->join('competiciones', 'competiciones.id = participantes.competicion_id')
            ->where('participantes.usuario_id', $usuarioId)
            ->findAll();
    }
    public function getAllParticipantes($competicionId)
    {
        return $this->select('competiciones.usuario_id as autor_id,competiciones.fecha_inicio as fecha_inicio, competiciones.fecha_fin as fecha_fin, competiciones.nombre as nombre,participantes.usuario_id as id,users.username as username')
            ->join('competiciones', 'competiciones.id = participantes.competicion_id')
            ->join('users','users.id=participantes.usuario_id')
            ->where('participantes.competicion_id', $competicionId)
            ->findAll();
    }
}
