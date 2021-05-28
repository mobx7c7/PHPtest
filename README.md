# PHPtest
## Observações iniciais
- Foram utilizados os seguintes recursos:
    - Máquina com Windows 10.
    - Pacote XAMPP versão 7.4.14, no qual inclui:
        - PHP versão 7.4.13.
        - MariaDB versão 10.4.17.
    - Composer versão 2.0.12.
    - Git versão 2.30.1.windows.1.
- Limitei-me apenas em utilizar o servidor web embutido do **PHP** ao invés do **Apache** visando reduzir problemas com configuração.
- Todas as instruções abaixo foram escritas somente para plataforma Windows.
- Não foi testado em outros sistemas.

## Requisitos de instalação
- Faça o download e instale o pacote [XAMPP](https://www.apachefriends.org/pt_br/download.html)
- Faça o download e instale a ferramenta [Git](https://git-scm.com/downloads)
- Adicione a aplicação **PHP** _inclusa na instalação do XAMPP_ no ambiente do sistema (Geralmente fica em `C:\xampp\php`)
- Instale o gerenciador de pacotes **Composer**
    - Para instalar, execute o comando abaixo no prompt de comando
        ```sh
        php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
        ```

## Instruções de inicialização e execução
- Abra o _painel de controle do XAMPP_ e certifique:
    - Módulo _MySQL_ deve estar ativo.
    - Não é necessário módulo _Apache_ estar ativo.
- Abra uma janela do prompt de comando 
- **(Opcional)** Certifique se as aplicações estão presentes no ambiente
    ```
    git --version
    php --version
    composer --version
    ```
- Faça o clone do projeto e mude para a pasta logo em seguida
    ```
    git clone https://github.com/mobx7c7/phptest && cd phptest
    ```
- Execute a instalação do composer no projeto
    ```
    composer install
    ```
- Execute o script inicializador do arquivo dotenv e digite os dados pedidos em cada pergunta que aparecer no console
    ```
    php tools/init_dotenv.php
    ```
- Execute o script inicializador da base de dados
    ```
    php tools/init_db.php
    ```
- Para executar a aplicação, execute `serve.cmd` localizado na raiz do projeto.
    - Opção alternativa: Com a janela de comando ajustado na raiz do projeto, execute `php -S 127.0.0.1:8000 -t public`

## Solução de problemas
- **PHP** Não está presente no ambiente
    - Opção 1 (Permanente)
        - Adicione caminho para o `php.exe` na variável de ambiente `PATH` nas configurações avançadas do sistema (Ex: `C:\xampp\php`)
        - **Sistema > Configurações Avançadas do Sistema > Aba "Avançado" > Botão "Variáveis de Ambiente"**
    - Opção 2 (Temporária)
        - Com uma janela de prompt de comando aberta, execute `set PATH=%PATH%;<caminho_instalacao_php>`
