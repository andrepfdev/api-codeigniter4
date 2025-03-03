<?php

namespace App\Controllers;

use App\Models\ItemPedidoModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ItemPedidoController extends ResourceController
{
    public function __construct()
    {
        $this->model = new ItemPedidoModel();
    }
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $filters = $this->request->getGet();

        if (!empty($filters)) {
            unset($filters['page'], $filters['per_page']);
            $this->model->like(array_filter($filters));
        }

        $itensPedido = $this->model->paginate(5);
        $pager = $this->model->pager;

        if (empty($itensPedido)) {
            $response = [
                'cabecalho' => [
                    'status' => 404,
                    'mensagem' => 'Nenhum item de pedido encontrado.'
                ],
                'retorno' => null
            ];
            return $this->respond($response, 404);
        }

        $response = [
            'cabecalho' => [
                'status' => 200,
                'mensagem' => 'Dados retornados com sucesso'
            ],
            'retorno' => $itensPedido,
            'paginate' => [
                'currentPage' => $pager->getCurrentPage() ?: 1,
                'pageCount' => $pager->getPageCount() ?: 1,
                'perPage' => $pager->getPerPage() ?: 1,
                'total' => $pager->getTotal() ?: 0
            ]
        ];

        return $this->respond($response);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $itemPedido = $this->model->find($id);

        if ($itemPedido === null) {
            $response = [
                'cabecalho' => [
                    'status' => 404,
                    'mensagem' => 'Item de pedido não encontrado.'
                ],
                'retorno' => null
            ];
            return $this->respond($response, 404);
        }

        $response = [
            'cabecalho' => [
                'status' => 200,
                'mensagem' => 'Dados retornados com sucesso'
            ],
            'retorno' => $itemPedido,
        ];

        return $this->respond($response);
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $json = $this->request->getJSON(true);

        if (!isset($json['parametros'])) {
            return $this->failValidationErrors('Parâmetros não informados.', 400);
        }

        $data = $json['parametros'];

        if ($this->model->insert($data) === false) {
            return $this->failValidationErrors($this->model->errors(), 400);
        }

        return $this->respondCreated(['cabecalho' => ['status' => 201, 'mensagem' => 'Dados retornados com sucesso.', 'retorno' => $data]]);
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $json = $this->request->getJSON(true);

        if (!isset($json['parametros'])) {
            return $this->failValidationErrors('Parâmetros não informados.', 400);
        }

        $data = $json['parametros'];

        if ($this->model->update($id, $data) === false) {
            return $this->failValidationErrors($this->model->errors(), 400);
        }

        return $this->respond(['cabecalho' => ['status' => 200, 'mensagem' => 'Item de pedido atualizado com sucesso.', 'retorno' => $data]]);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $itemPedido = $this->model->find($id);

        if ($itemPedido === null) {
            $response = [
                'cabecalho' => [
                    'status' => 404,
                    'mensagem' => 'Item de pedido não encontrado.'
                ],
                'retorno' => null
            ];
            return $this->respond($response, 404);
        }

        $this->model->delete($id);

        $response = [
            'cabecalho' => [
                'status' => 200,
                'mensagem' => 'Item de pedido excluído com sucesso.'
            ],
            'retorno' => $itemPedido
        ];

        return $this->respondDeleted($response);
    }
}
