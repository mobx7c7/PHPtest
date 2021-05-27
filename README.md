# PHPtest

## Instruções de inicialização
- Abra uma janela de prompt de comando no local do projeto
- Execute a instalação do composer no projeto
    ```sh
    composer install
    ```
- Execute o script inicializador do arquivo dotenv e digite os dados pedidos em cada pergunta que aparecer no console
    ```sh
    php tools/init_dotenv.php
    ```
- Execute o script inicializador da base de dados
    ```sh
    php tools/init_db.php
    ```
## Instruções de execução
- Usando servidor embutido (no local do projeto)
    ```sh
    php -S 127.0.0.1:8000 -t public
    ```
