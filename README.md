# Projeto Conecta Huggy

## Clonar o Repositório

Para clonar o repositório do projeto, execute o seguinte comando:

```sh
git clone https://github.com/tiagomellobr/conecta-huggy.git
```

## Backend

1. Navegue até o diretório do backend:
    ```sh
    cd backend/
    ```

2. Instale as dependências:
    ```sh
    composer install
    ```

3. Inicie o docker:
    ```sh
        ./vendor/bin/sail up -d
    ```

4. Rode as migrations
    ```sh
        ./vendor/bin/sail artisan migrate
    ```

## Frontend

1. Navegue até o diretório do frontend:
    ```sh
    cd frontend/
    ```

2. Instale as dependências:
    ```sh
    npm i
    ```

3. Inicie o servidor:
    ```sh
    npm run dev
    ```

    4. Acesse a aplicação no navegador:
        [http://localhost:3000](http://localhost:3000)

## Documentação da API

Após iniciar o servidor do backend, você pode acessar a documentação do Swagger através da seguinte URL:
[http://localhost/api/documentation](http://localhost/api/documentation)