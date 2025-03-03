<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nome' => 'Cheeseburger',
                'descricao' => 'Pão, carne, queijo, alface, tomate e maionese',
                'preco' => 12.50,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'X-Bacon',
                'descricao' => 'Pão, carne, queijo, bacon, alface, tomate e maionese',
                'preco' => 15.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'X-Egg',
                'descricao' => 'Pão, carne, queijo, ovo, alface, tomate e maionese',
                'preco' => 14.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'X-Tudo',
                'descricao' => 'Pão, carne, queijo, presunto, bacon, ovo, alface, tomate e maionese',
                'preco' => 18.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Hot Dog',
                'descricao' => 'Pão, salsicha, purê de batata, milho, ervilha, batata palha e ketchup',
                'preco' => 10.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Misto Quente',
                'descricao' => 'Pão, presunto e queijo',
                'preco' => 8.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Bauru',
                'descricao' => 'Pão, carne, queijo, presunto, tomate e maionese',
                'preco' => 13.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Beirute',
                'descricao' => 'Pão sírio, carne, queijo, presunto, alface, tomate e maionese',
                'preco' => 20.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Hambúrguer de Frango',
                'descricao' => 'Pão, frango, queijo, alface, tomate e maionese',
                'preco' => 11.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Veggie Burger',
                'descricao' => 'Pão, hambúrguer de grão-de-bico, alface, tomate e maionese vegana',
                'preco' => 16.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($data as $produto) {
            $this->db->table('produtos')->insert($produto);
        }
    }
}
