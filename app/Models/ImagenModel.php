<?php

namespace App\Models;

use CodeIgniter\Model;

class ImagenModel extends Model
{
    protected $table            = 'imagenes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['imagen', 'extension'];

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


    public function getImagenesEspecie($especieId)
    {
        return $this->select('imagenes.imagen,imagenes.extension')
            ->join('imagenes_especies as ie', 'ie.imagen_id = imagenes.id')
            ->join('especies', 'especies.id = ie.especie_id')
            ->where('especies.id', $especieId)
            ->findAll();
    }
   
    public function getImagenesCaptura($especieId) {
        return $this->select('imagenes.imagen,imagenes.extension')
            ->join('imagenes_especies as ie', 'ie.imagen_id = imagenes.id')
            ->join('especies', 'especies.id = ie.especie_id')
            ->where('especies.id', $especieId)
            ->findAll();
    }
    public function getImagenesCompeticion($especieId) {
        return $this->select('imagenes.imagen,imagenes.extension')
            ->join('imagenes_especies as ie', 'ie.imagen_id = imagenes.id')
            ->join('especies', 'especies.id = ie.especie_id')
            ->where('especies.id', $especieId)
            ->findAll();
    }

    public function deleteImagenesEspecie($especieId)
    {
        $imagenesEspecie = $this->select('imagenes.id')
            ->join('imagenes_especies as ie', 'ie.imagen_id = imagenes.id')
            ->join('especies as e', 'e.id = ie.especie_id')
            ->where('e.id', $especieId)
            ->findAll();
        if ($imagenesEspecie != null) {
            foreach ($imagenesEspecie as $i) {
                $this->delete($i->id);
            }
        }
    }
    public function deleteImagenesCaptura($capturaId)
    {
        $imagenesEspecie = $this->select('imagenes.id')
            ->join('imagenes_capturas as ie', 'ie.imagen_id = imagenes.id')
            ->join('especies as e', 'e.id = ie.especie_id')
            ->where('e.id', $capturaId)
            ->findAll();
        if ($imagenesEspecie != null) {
            foreach ($imagenesEspecie as $i) {
                $this->delete($i->id);
            }
        }
    }
    public function deleteImagenesCompeticion($competicionId)
    {
        $imagenesEspecie = $this->select('imagenes.id')
            ->join('imagenes_competiciones as ic', 'ie.imagen_id = imagenes.id')
            ->where('e.id', $competicionId)
            ->findAll();
        if ($imagenesEspecie != null) {
            foreach ($imagenesEspecie as $i) {
                $this->delete($i->id);
            }
        }
    }
}
