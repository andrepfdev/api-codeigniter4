# API de Teste Back-end PHP - CodeIgniter 4

Uma API REST com endpoints de clientes, produtos e pedidos desenvolvida com CodeIgniter 4 e MySQL.

![Badge](https://img.shields.io/badge/PHP-8.1-blue)
![Badge](https://img.shields.io/badge/CodeIgniter-4.3-red)
![Badge](https://img.shields.io/badge/MySQL-8.0-orange)

## Nota Pessoal

Gostei muito de desenvolver o projeto, assim pude conhecer a delicinha que é o Codeigniter 4, contúdo, lamento por não ter conseguido aproveitar a tempo estipulado para a realização do projeto. Passei mais tempo no hospital do que em casa. Fico feliz pela oportunidade e espero que gostem do resultado. No último momento, tive problemas com o JWT, por conta disso eu decidi não implementá-lo.

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
   git clone https://github.com/andrepfdev/api-codeigniter4.git
   cd api-codeigniter4
   ```
### Método A:

2. **Rode o script de instalação:**

 - Se para rodar o docker você usa o comando **docker compose**, sem espaço, use:
 
   Na dúvida? Digite o comando **docker compose version**. 
 
   **No Linux (docker compose):**
   
   ```bash
   chmod +x ./install.sh
   ```
   Depois:

   ```bash
   ./install.sh
   ```
      
- Mas, se para rodar você usa o comando **docker-compose**, tudo junto, use:
   
   Na dúvida? Digite o comando **docker-compose version**.

   **No Windows (docker-compose):**

   ```bash
   chmod +x ./install-wls.sh
   ```
   Depois:

   ```bash
   ./install-wsl.sh
   ```

**Pronto! Se tudo der certinho, você não precisará executar o Método B.**

Apenas siga as instruções geradas pelo script no seu terminal. 

### Método B:

**Execute o Método B apenas se o A não estiver funcionado corretamente.**

2. **Instale as dependências**
   ```bash
   composer-install
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

   Não pode esquecer da chave par o JWT que também vai no **.env**:

   ```ini
    JWT_SECRET = "minha_vaga_backend"
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
   - Para avitar erros devidos aos relacionamentos das tabelas, execute exatamente nesta ordem:

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

### Autenticação
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| POST | /api/registrar | Registra novo usuário |
| POST | /api/validar | Valida e gera token de autencicação |

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

### Usuários
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | /api/usuarios | Lista todos os usuários cadastrados |


### Diagrama do Banco de Dados

![Image](https://github.com/user-attachments/assets/711de36c-8580-4530-b9dd-e2357e4046a3)

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

## Vídeo - Testando os Endpoints

Com Swagger

https://github.com/user-attachments/assets/35083f7a-997a-4f34-b9c7-e753e53938f5

Com Postmam

https://github.com/user-attachments/assets/93f46c69-a23a-4d51-a3ee-4ba5f1011b18

### Consultar os endpoints

Para testar os endpoints da API, você pode utilizar ferramentas como [Postman](https://www.postman.com/) ou [Insomnia](https://insomnia.rest/). 

### Exemplos de Requisições e Respostas

#### Formato Padrão

##### Requisição
```json
{
   "parametros": {
      "campo1": "valor1",
      "campo2": "valor2"
   }
}
```

##### Resposta
```json
{
   "cabecalho": {
      "status": 200,
      "mensagem": "Dados retornados com sucesso"
   },
   "retorno": {
      // dados solicitados
   }
}
```

#### Exemplos por Endpoint

##### Clientes (`/api/clientes`)
- **GET**: Lista clientes (com paginação)
```http
GET /api/clientes?page=1&nome_razao_social=Carlos
Authorization: Bearer {seu_token}
```
```json
{
   "cabecalho": {
      "status": 200,
      "mensagem": "Clientes listados com sucesso"
   },
   "retorno": [
      {"id": 1, "nome_razao_social": "Carlos Silva", "cpf_cnpj": "12345678901"}
   ]
}
```

##### Produtos (`/api/produtos`)
- **POST**: Cria produto
```http
POST /api/produtos
Authorization: Bearer {seu_token}
```
```json
// Enviar
{
   "parametros": {
      "nome": "Produto X",
      "preco": 15.00
   }
}
```

##### Pedidos (`/api/pedidos`)
- **GET**: Lista pedidos filtrados
```http
GET /api/pedidos?status=Em%20Aberto
Authorization: Bearer {seu_token}
```
```json
{
   "cabecalho": {
      "status": 200,
      "mensagem": "Pedidos listados com sucesso"
   },
   "retorno": [
      {"id": 1, "cliente_id": 1, "status": "Em Aberto"}
   ]
}
```

##### Itens Pedido (`/api/itens-pedido`)
- **POST**: Adiciona item
```http
POST /api/itens-pedido
Authorization: Bearer {seu_token}
```
```json
// Enviar
{
   "parametros": {
      "pedido_id": 1,
      "produto_id": 1,
      "quantidade": 2
   }
}
```

#### Como Testar

1. Use Postman ou Insomnia
2. Endpoint base: `http://localhost:8080/api`
3. Headers padrão: 
   ```
   accept: application/json
   Content-Type: application/json
   ```
4. Para filtros, use query params:
   ```
   /api/clientes?nome_razao_social=Carlos
   /api/produtos?preco=15
   /api/pedidos?status=Pago
   ```
## Autor

André Pereira - [LinkedIn](https://www.linkedin.com/in/andrepf7/)

## Licença

Este projeto está licenciado sob a licença MIT - veja o arquivo [LICENSE](LICENSE) para mais detalhes.
