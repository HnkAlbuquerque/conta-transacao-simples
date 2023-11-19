# Objective Api

## Objetivo

- Crie um sistema de gestão bancária por meio de uma API, composta por dois endpoints:
"/conta" e "/transacao". O endpoint "/conta" deve fornecer informações sobre o número da
conta e o saldo. O endpoint "/transacao" será responsável por realizar diversas operações
financeiras.


- Os endpoints devem ter o seguintes padrões de entrada e saída no formato json:
Use as seguintes siglas para as formas de pagamento:
P => Pix
C => Cartão de Crédito
D => Cartão de Débito


## Dependencias
- Docker

## Tecnologias
- PHP
- Laravel
- MySQL

## Iniciando o projeto

### Clonar Repositório
```bash
git clone https://github.com/HnkAlbuquerque/objective-php.git
```

### Antes de rodar o docker certifique que você tenha as seguintes portas disponíveis em seu ambiente
```bash
NGINX: 7000
MYSQL: 9306
PHP: 9004
```

### Executar o docker
```bash
docker-compose up -d --build
```

### Rode o composer para instalar as dependencias
```bash
docker-compose exec php composer install
```

### Arquivo de ambiente
```bash
docker-compose exec php cp .env.example .env
```

### Configure a conexão com o banco de dados no seu .env
```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=db_app
DB_USERNAME=db_app
DB_PASSWORD=root
```

### Aplicações laravel precisam de uma chave de aplicação
```bash
docker-compose exec php php artisan key:generate
```

### Execute as migrations
```bash
docker-compose exec php php artisan migrate
```

### Popule o banco de dados para realizar transações
```bash
docker-compose exec php php artisan db:seed DatabaseSeeder
```

### Execute os testes
```bash
docker-compose exec php php artisan test
```

## Sobre a API
- Você poderá acessar a aplicação a partir do host http://localhost:7000
### Transação
Faça uma requisição `POST` para `api/transacao`

### Payload

Informe um payload JSON no seguinte formato abaixo
```json
{
  "forma_pagamento": "D",
  "conta_id": "1001",
  "valor": 100
}
```
`forma_pagamento` -> P = Pix | D = Débito | C = Crédito

`conta_id` -> ID da conta

`valor` -> Valor da transação

### Resposta do Payload
Se tudo ocorrer bem será retornado a resposta abaixo
```json
{
  "saldo": "397.00"
}
```

### Retornar apenas uma transação
Faça uma requisição `GET` para `api/conta/{conta_id}` onde `{conta_id}` é o ID da conta.
```json
{
  "conta_id": "1001",
  "saldo": "397.00"
}
```

### Em caso de ERROS
Erros são retornados no formato abaixo onde `message` poderá ser mais de uma
```json
{
    "errors": {
        "message": "error message"
    }
}
```