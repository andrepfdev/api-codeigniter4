<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ClienteController extends ResourceController
{
    public function __construct()
    {
        $this->model = new ClienteModel();
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

        $clientes = $this->model->paginate(5);
        $pager = $this->model->pager;

        if (empty($clientes)) {
            $response = [
                'cabecalho' => [
                    'status' => 404,
                    'mensagem' => 'Nenhum cliente encontrado.'
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
            'retorno' => $clientes,
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
        $cliente = $this->model->find($id);

        if ($cliente === null) {
            $response = [
                'cabecalho' => [
                    'status' => 404,
                    'mensagem' => 'Cliente não encontrado.'
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
            'retorno' => $cliente
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
            return $this->failValidationErrors('Parâmetros não fornecidos.', 400);
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

        if (!isset($json['parametros']) || empty($json['parametros'])) {
            return $this->failValidationErrors('Parâmetros não fornecidos.', 400);
        }

        $data = $json['parametros'];

        if ($this->model->update($id, $data) === false) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respond($data);
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
        $cliente = $this->model->find($id);

        if ($cliente === null) {
            return $this->failNotFound('Cliente não encontrado.', 404);
        }

        $db = \Config\Database::connect();
        $hasOrders = $db->table('pedidos')->where('cliente_id', $id)->countAllResults() > 0;
        if ($hasOrders) {
            return $this->fail('Cliente não pode ser excluído pois está sendo usado em outras tabelas.', 400);
        }

        $this->model->delete($id);

        $response = [
            'cabecalho' => [
                'status' => 200,
                'mensagem' => 'Cliente deletado com sucesso'
            ],
            'retorno' => $cliente
        ];

        return $this->respondDeleted($response);
    }
}
