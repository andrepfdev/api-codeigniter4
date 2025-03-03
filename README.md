# API de Teste Back-end PHP - CodeIgniter 4

Uma API REST com endpoints de clientes, produtos e pedidos desenvolvida com CodeIgniter 4 e MySQL.

![Badge](https://img.shields.io/badge/PHP-8.1-blue)
![Badge](https://img.shields.io/badge/CodeIgniter-4.3-red)
![Badge](https://img.shields.io/badge/MySQL-8.0-orange)

## Sobre o Projeto

Esta API foi desenvolvida como parte de um desafio técnico para a posição de Programador Back-end Júnior. O sistema permite gerenciar clientes, produtos e pedidos de compra, seguindo os seguintes requisitos:

### Desafio 1 (Caráter eliminatório)
- CRUD de Clientes (CPF/CNPJ, Nome/Razão Social);
- CRUD de Produtos;
- CRUD de Pedidos de compra com status (Em Aberto, Pago, Cancelado).

### Desafio 2 (Caráter não eliminatório)
- Implementar paginação e filtro de dados nos endpoints;
- Implementar autenticação JWT com data de expiração.

## Tecnologias Utilizadas

- **PHP 8.1**
- **CodeIgniter 4.6**
- **MySQL 8.0**
- **JWT para autenticação**
- **Docker para ambiente de desenvolvimento**

## Instalação e Configuração

### Usando Docker

1. **Clone o repositório**
   ```bash
   git clone https://github.com/andrepfdev/prova-backend-ci4.git
   cd prova-backend-ci4
   ```
### Método A:

2. **Rode o script de instalação:**
    ```bash
    sudo chmod +x install.sh
    ```
    ```bash
    ./install.sh
    ```
**Se tudo correr bem, você não precisará executar o Método B.**
Apenas siga as instruções geradas pelo script no seu terminal. 

### Método B:

**Execute o Método B apenas se o A não estiver funcionado corretamente.**

2. **Instale as dependências**
   ```bash
   composer install
   ```

3. **Copie e configure o ambiente**
   ```bash
   cp env .env
   ```
   Edite o arquivo `.env` com as configurações do banco de dados:
   ```ini
    database.default.hostname = db
    database.default.database = ci4
    database.default.username = ci4user
    database.default.password = ci4pass
    database.default.DBDriver = MySQLi
    database.tests.DBPrefix =
    database.default.port = 3306
   ```
   Também deve alterar o modo de produção para:
    ```ini
    CI_ENVIRONMENT = development
   ```

4. **Suba os containers**
   ```bash
   docker-compose up -d
   ```

5. **Acesse o container do PHP**
   ```bash
   docker-compose exec app bash
   ```

6. **Execute as migrations**
   ```bash
   php spark migrate
   ```

7. **Execute os seeders (dados iniciais)**
   ```bash
   php spark db:seed ProdutoSeeder
   php spark db:seed ClienteSeeder
   php spark db:seed PedidoSeeder
   php spark db:seed ItemPedidoSeeder
   ```

A API estará disponível em `http://localhost:8080`.

## Observação

Para rodar qualquer comando `php spark`, é necessário primeiro acessar o container do Docker:
```bash
   docker-compose exec app bash
```

## Autenticação JWT

- Para acessar os endpoints protegidos, é necessário incluir o token JWT no header:
  ```http
  Authorization: Bearer {seu_token}
  ```

## Endpoints

### Clientes
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | /api/clientes | Lista todos os clientes |
| GET | /api/clientes/{id} | Obtém um cliente específico |
| POST | /api/clientes | Cria um novo cliente |
| PUT | /api/clientes/{id} | Atualiza um cliente existente |
| DELETE | /api/clientes/{id} | Remove um cliente |

### Produtos
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | /api/produtos | Lista todos os produtos |
| GET | /api/produtos/{id} | Obtém um produto específico |
| POST | /api/produtos | Cria um novo produto |
| PUT | /api/produtos/{id} | Atualiza um produto existente |
| DELETE | /api/produtos/{id} | Remove um produto |

### Pedidos
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | /api/pedidos | Lista todos os pedidos |
| GET | /api/pedidos/{id} | Obtém um pedido específico |
| POST | /api/pedidos | Cria um novo pedido |
| PUT | /api/pedidos/{id} | Atualiza um pedido existente |
| DELETE | /api/pedidos/{id} | Remove um pedido |

### Itens Pedidos
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | /api/itens-pedido | Lista todos os itens-pedido |
| GET | /api/itens-pedido/{id} | Obtém um itens-pedido específico |
| POST | /api/itens-pedido | Cria um novo itens-pedido |
| PUT | /api/itens-pedido/{id} | Atualiza um itens-pedido existente |
| DELETE | /api/itens-pedido/{id} | Remove um itens-pedido |

## Paginação e Filtros

### Paginação
Para utilizar a paginação nos endpoints de listagem, utilize o parâmetro `page` na query string:
```http
GET localhost:8080/api/clientes?nome_razao_social=Carlos
```

### Filtros
Os dados podem ser filtrados por qualquer campo. Para isso, passe os parâmetros desejados na query string. Exemplo:
```http
GET localhost:8080/api/produtos?preco=15
```
Parâmetros comuns de filtro:
- `nome_razao_social` (filtra pelo nome do produto ou cliente);
- `cpf_cnpj` (filtra clientes por CPF/CNPJ);
- `preco` (filtra produtos por preço);
- `status` (filtra pedidos por status: `Em Aberto`, `Pago`, `Cancelado`).

## Autor

Seu Nome - [LinkedIn](https://www.linkedin.com/in/andrepf7/)

## Licença

Este projeto está licenciado sob a licença MIT - veja o arquivo [LICENSE](LICENSE) para mais detalhes.
