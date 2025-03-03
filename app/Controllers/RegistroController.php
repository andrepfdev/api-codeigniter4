<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class RegistroController extends ResourceController
{
    public function __construct()
    {
        $this->model = new UserModel();
    }
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $data = $this->request->getPost();

        if ($this->validate($this->model->validationRules)) {
            $data = $this->request->getPost();
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $this->model->insert($data);

            $response = [
                'cabecalho' => [
                    'status' => 201,
                    'mensagem' => 'Usuário cadastrado com sucesso.'
                ],
                'retorno' => $data
            ];

            return $this->respond($response, 201);
        } else {

            $response = [
                'cabecalho' => [
                    'status' => 400,
                    'mensagem' => 'Erro ao cadastrar usuário.',
                    'erros' => $this->validator->getErrors()
                ],
                'retorno' => null
            ];

            return $this->respond($response, 400);
        }
    }
}
