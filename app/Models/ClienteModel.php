<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'cpf_cnpj',
        'nome_razao_social',
    ];

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
    protected $validationRules      = [
        'cpf_cnpj' => 'required|numeric|min_length[11]|max_length[14]|is_unique[clientes.cpf_cnpj]',
        'nome_razao_social' => 'required|string|max_length[255]',
    ];
    protected $validationMessages   = [
        'cpf_cnpj' => [
            'required' => 'O campo CPF/CNPJ é obrigatório.',
            'numeric' => 'O campo CPF/CNPJ deve ser numérico.',
            'is_unique' => 'O CPF/CNPJ informado já está cadastrado.',
            'min_length' => 'O campo CPF/CNPJ deve ter no mínimo 11 caracteres.',
            'max_length' => 'O campo CPF/CNPJ deve ter no máximo 14 caracteres.',
        ],
        'nome_razao_social' => [
            'required' => 'O campo Nome/Razão Social é obrigatório.',
            'string' => 'O campo Nome/Razão Social deve ser uma string.',
            'max_length' => 'O campo Nome/Razão Social deve ter no máximo 255 caracteres.',
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
