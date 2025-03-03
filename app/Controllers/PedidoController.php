<?php

namespace App\Controllers;

use App\Models\PedidoModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PedidoController extends ResourceController
{
    public function __construct()
    {
        $this->model = new PedidoModel();
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

        $pedidos = $this->model->paginate(5);
        $pager = $this->model->pager;

        if (empty($pedidos)) {
            $response = [
                'cabecalho' => [
                    'status' => 404,
                    'mensagem' => 'Nenhum pedido encontrado.'
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
            'retorno' => $pedidos,
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
        $pedido = $this->model->find($id);

        if ($pedido === null) {
            $response = [
                'cabecalho' => [
                    'status' => 404,
                    'mensagem' => 'Pedido não encontrado.'
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
            'retorno' => $pedido
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
            return $this->failValidationErrors('Parâmetros não informados.');
        }

        $data = $json['parametros'];

        if (!$this->model->insert($data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respondCreated($data);
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
            return $this->failValidationErrors('Parâmetros não informados.');
        }

        $data = $json['parametros'];

        if (!$this->model->update($id, $data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respondUpdated($data);
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
        $pedido = $this->model->find($id);

        if ($pedido === null) {
            return $this->fail('Pedido não encontrado.', 404);
        }

        $db = \Config\Database::connect();
        $hasOrder = $db->table('itens_pedido')->where('pedido_id', $id)->countAllResults();
        if ($hasOrder > 0) {
            return $this->fail('Pedido não pode ser excluído, pois possui itens associados.', 400);
        }

        $this->model->delete($id);

        $response = [
            'cabecalho' => [
                'status' => 200,
                'mensagem' => 'Pedido excluído com sucesso.'
            ],
            'retorno' => $pedido
        ];

        return $this->respondDeleted($response);
    }
}
