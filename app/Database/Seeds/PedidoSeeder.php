<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PedidoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'status' => 'Em Aberto',
                'cliente_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'status' => 'Pago',
                'cliente_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'status' => 'Cancelado',
                'cliente_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'status' => 'Em Aberto',
                'cliente_id' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'status' => 'Pago',
                'cliente_id' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($data as $pedido) {
            $this->db->table('pedidos')->insert($pedido);
        }
    }
}
