<?php

namespace App\Controllers;

use App\Models\ProdutoModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ProdutoController extends ResourceController
{
    public function __construct()
    {
        $this->model = new ProdutoModel();
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $filters = $this->request->getGet();

        // Apanhei para chegar nesse código, mas acho que ficou bom
        if (!empty($filters)) {
            unset($filters['page'], $filters['per_page']);
            $this->model->like(array_filter($filters));
        }

        $produtos = $this->model->paginate(5);
        $pager = $this->model->pager;

        if (empty($produtos)) {
            $response = [
                'cabecalho' => [
                    'status' => 404,
                    'mensagem' => 'Nenhum produto encontrado.'
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
            'retorno' => $produtos,
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
        $produto = $this->model->find($id);

        if ($produto === null) {
            $response = [
                'cabecalho' => [
                    'status' => 404,
                    'mensagem' => 'Produto não encontrado.'
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
            'retorno' => $produto
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
            return $this->fail('Nenhum dado foi informado.', 400);
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
        $produto = $this->model->find($id);

        if ($produto === null) {
            return $this->fail('Produto não encontrado.', 404);
        }

        $this->model->delete($produto);

        $response = [
            'cabecalho' => [
                'status' => 200,
                'mensagem' => 'Produto excluído com sucesso.'
            ],
            'retorno' => $produto
        ];

        return $this->respondDeleted($response);
    }
}
