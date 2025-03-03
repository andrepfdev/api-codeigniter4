<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemPedidoModel extends Model
{
    protected $table            = 'itens_pedido';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pedido_id',
        'produto_id',
        'quantidade',
        'valor_unitario',
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
        'pedido_id'     => 'required|is_not_unique[pedidos.id]',
        'produto_id'    => 'required|is_not_unique[produtos.id]',
        'quantidade'    => 'required|integer',
        'valor_unitario' => 'required|decimal',
    ];
    protected $validationMessages   = [
        'pedido_id'     => [
            'required' => 'O campo Pedido é obrigatório.',
            'is_not_unique' => 'O Pedido informado não existe.',
        ],
        'produto_id'    => [
            'required' => 'O campo Produto é obrigatório.',
            'is_not_unique' => 'O Produto informado não existe.',
        ],
        'quantidade'    => [
            'required' => 'O campo Quantidade é obrigatório.',
            'integer' => 'O campo Quantidade deve ser um número inteiro.',
        ],
        'valor_unitario' => [
            'required' => 'O campo Valor Unitário é obrigatório.',
            'decimal' => 'O campo Valor Unitário deve ser um número decimal.',
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
