<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ItemPedidoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'pedido_id' => 1,
                'produto_id' => 5,
                'quantidade' => 9,
                'valor_unitario' => 100.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'pedido_id' => 2,
                'produto_id' => 4,
                'quantidade' => 2,
                'valor_unitario' => 200.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'pedido_id' => 3,
                'produto_id' => 1,
                'quantidade' => 3,
                'valor_unitario' => 300.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'pedido_id' => 4,
                'produto_id' => 2,
                'quantidade' => 1,
                'valor_unitario' => 400.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'pedido_id' => 5,
                'produto_id' => 3,
                'quantidade' => 5,
                'valor_unitario' => 500.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($data as $itemPedido) {
            $this->db->table('itens_pedido')->insert($itemPedido);
        }
    }
}
