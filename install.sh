#!/bin/bash

echo "🚀 Iniciando instalação do projeto API de Gestão de Pedidos..."

# Verificar se o Docker está instalado
if ! command -v docker &> /dev/null; then
    echo "❌ Docker não está instalado. Por favor, instale o Docker primeiro."
    exit 1
fi

# Verificar se o Docker Compose está instalado
if ! command -v docker compose &> /dev/null; then
    echo "❌ Docker Compose não está instalado. Por favor, instale o Docker Compose primeiro."
    exit 1
fi

# sudo chmod -R 777 ../api-codeigniter4
sudo apt install php-curl php-xml php-mbstring php-zip

#composer install
echo "📦 Instalando Composer..."
composer install

# Intalar JWT via Composer
echo "Instalado o JWT para Autenticação com token..."
composer require firebase/php-jwt
sleep 3

# Criar arquivo .env
echo "📝 Configurando arquivo .env..."
touch .env

# Configurar .env
cat > .env << EOL
CI_ENVIRONMENT = development

database.default.hostname = db
database.default.database = ci4
database.default.username = ci4user
database.default.password = ci4pass
database.default.DBDriver = MySQLi
database.tests.DBPrefix =
database.default.port = 3306

JWT_SECRET = "minha_vaga_backend"
EOL

# # Chave no .env
# echo "🔑 Gerando chave..."
# php spark key:generate
# sleep 2
# echo "🔑 Chave gerada com sucesso!"

# Subir containers Docker
echo "🐳 Iniciando containers Docker..."
docker compose up -d

# Aguardar o MySQL iniciar completamente
echo "⏳ Aguardando MySQL inicializar..."
sleep 7

# Aplicar permissões para rodar as migrations e os seeders
echo "🔑 Aplicando permissões..."
docker compose exec app bash -c "chmod -R 777 /app/writable"

# Executar migrations
echo "🔄 Executando migrations..."
docker compose exec app bash -c "php spark migrate --force"

# Executar seeders
echo "🌱 Executando seeders..."
docker compose exec app bash -c "php spark db:seed ClienteSeeder"
docker compose exec app bash -c "php spark db:seed ProdutoSeeder"
docker compose exec app bash -c "php spark db:seed PedidoSeeder"
docker compose exec app bash -c "php spark db:seed ItemPedidoSeeder"

echo "✅ Instalação concluída!"
echo "🌐 A API está disponível em: http://localhost:8080"
echo "
Endpoints disponíveis:
- GET    /api/clientes
- GET    /api/produtos
- GET    /api/pedidos
- GET    /api/itens_pedido

Para testar a API:
curl http://localhost:8080/api/produtos?page=1&id=1
"