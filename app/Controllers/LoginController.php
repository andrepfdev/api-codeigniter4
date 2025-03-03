<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use Firebase\JWT\JWT;

class LoginController extends ResourceController
{
    protected $model;

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
        $json = $this->request->getJSON();

        if (json_last_error() !== JSON_ERROR_NONE || $json === null) {
            $response = [
                'cabecalho' => [
                    'status' => 400,
                    'mensagem' => 'JSON inválido ou não fornecido.',
                ],
                'retorno' => null,
            ];
            return $this->respond($response, 400);
        }

        if (!isset($json->email) || !isset($json->password)) {
            $response = [
                'cabecalho' => [
                    'status' => 400,
                    'mensagem' => 'Email e senha são obrigatórios.',
                ],
                'retorno' => null,
            ];
            return $this->respond($response, 400);
        }

        $email = $json->email;
        $password = $json->password;

        $user = $this->model->where('email', $email)->first();

        if ($user === null) {
            $response = [
                'cabecalho' => [
                    'status' => 404,
                    'mensagem' => 'Usuário não encontrado.',
                ],
                'retorno' => null,
            ];
            return $this->respond($response, 404);
        }

        $passwordVerify = password_verify($password, $user['password']);
        if (!$passwordVerify) {
            $response = [
                'cabecalho' => [
                    'status' => 401,
                    'mensagem' => 'Senha inválida.',
                ],
                'retorno' => null,
            ];
            return $this->respond($response, 401);
        }

        $key = getenv('JWT_SECRET');
        $iat = time();
        $exp = $iat + 3600;
        $payload = [
            'iat' => $iat,
            'exp' => $exp,
            'data' => [
                'email' => $user['email']
            ]
        ];
        $jwt = JWT::encode($payload, $key, 'HS256');

        $response = [
            'cabecalho' => [
                'status' => 200,
                'mensagem' => 'Usuário autenticado com sucesso.'
            ],
            'retorno' => [
                'token' => $jwt
            ]
        ];
        return $this->respond($response, 200);
    }

    public function login()
    {
        $users = $this->request->getPost();

        $email = $users['email'];
        $password = $users['password'];

        $user = $this->model->where('email', $email)->first();

        if (!$user === null) {
            $response = [
                'cabecalho' => [
                    'status' => 404,
                    'mensagem' => 'Usuário não encontrado.',
                ],
                'retorno' => null,
            ];

            return $this->respond($response, 404);
        }


        $passwordVerify = password_verify($password, $user['password']);

        if (!$passwordVerify) {
            $response = [
                'cabecalho' => [
                    'status' => 401,
                    'mensagem' => 'Senha inválida.',
                ],
                'retorno' => null,
            ];

            return $this->respond($response, 401);
        }

        $key = getenv('JWT_SECRET');
        $iat = time();
        $exp = $iat + 3600;
        $payload = [
            'iat' => $iat,
            'exp' => $exp,
            'data' => [
                'email' => $user['email']
            ]
        ];

        $jwt = \Firebase\JWT\JWT::encode($payload, $key, 'HS256');

        $response = [
            'cabecalho' => [
                'status' => 200,
                'mensagem' => 'Usuário autenticado com sucesso.'
            ],
            'retorno' => [
                'token' => $jwt
            ]
        ];

        return $this->respond($response, 200);
    }
}
