<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table            = 'produtos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome',
        'descricao',
        'preco',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nome' => 'required|string|max_length[255]',
        'descricao' => 'permit_empty|string',
        'preco' => 'required|decimal',
    ];
    protected $validationMessages   = [
        'nome' => [
            'required' => 'O campo nome é obrigatório.',
            'string' => 'O campo nome deve ser uma string.',
            'max_length' => 'O campo nome deve ter no máximo 255 caracteres.',
        ],
        'descricao' => [
            'permit_empty' => 'O campo descrição deve ser permitido vazio.',
            'string' => 'O campo descrição deve ser uma string.',
        ],
        'preco' => [
            'required' => 'O campo preço é obrigatório.',
            'decimal' => 'O campo preço deve ser um número decimal.',
        ],
    ];
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
}
