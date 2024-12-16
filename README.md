Manual de instalação do projeto 

        GERENCIADOR DE TAREFAS

1. Instale a lista de aplicações necessárias para uso do projeto.
Obs: caso já possua algumas das aplicações, não é necessário reinstala-la.

1.1 Xammp -> https://www.apachefriends.org/pt_br/download.html

1.2 git bash -> https://git-scm.com/downloads

1.3 composer -> https://getcomposer.org/doc/00-intro.md

2. Onde alocar o projeto em sua máquina.

2.1 Acesse a pasta htdocs dentro de xampp e clone o repositório usando o terminal do git bash.

*Comando para clonar ->        git clone https://github.com/Mariluzzz/TestBaummer.git

3. Configurando o banco de dados.

3.1 Após clonar, navegue ate a pasta do xampp/htdocs/TestBaummer copie o .env.exemple, renomeie somente como .env e substitua as
variáveis referente a conexão com o banco por essas abaixo.

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gerenciamentoDeTarefas
DB_USERNAME=root
DB_PASSWORD=root
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci

4. Instalando composer e dependências do projeto.

4.1 Abra um novo terminal na mesma pasta ( xampp/htdocs/TestBaummer) e execute o comando ->      composer install 

4.2 Após finalizado, execute ->        composer update 

5. Configurando apache para o banco de dados.
   
5.1 Após isso, starte o apache e o mysql do xampp no painel de controle, estando rodando o mysql e o apache,

![image](https://github.com/user-attachments/assets/434aa59b-e336-4d59-a7f4-8733ea7a0fc0)

5.2 Clique em admin, de mysql, ira abrir no browser localhost/phpadmin/index.php, localize a aba de contas usuário, clique nela.

![image](https://github.com/user-attachments/assets/c30c17be-b965-4f0a-a7d6-f60d8c5ef9bf)

5.2 Acesse o usuário root com o nome do host como localhost e clique em editar privilégios.
Após isso em "Change password", entre com a senha "root" e redigite-a "root". Clique em executar após isso.

![image](https://github.com/user-attachments/assets/82a5d8f9-803e-4edc-8278-543dba2c657f)


5.3 Agora navegue até esse caminho xampp/phpMyAdmin e abra o arquivo config.inc.php, já no arquivo 
na linha 21, coloque a senha de como root, dessa forma 

![image](https://github.com/user-attachments/assets/c0daf273-6e7e-4d6b-b857-a0e28b3c626a)

5.4 Recarregue a pagina do phpAdmin e voltará o funcionamento normalmente.

6. Subindo o banco de dados.
    
6.1 No terminal novamente, execute em xampp/htdocs/TestBaummer 

php artisan db:create

*isso fará com que o banco e as tabelas sejam criadas, após isso 
execute 

6.2 Crie sua key de navegação do laravel com o comando abaixo.

php artisan key:generate

7. Subindo o servidor.

7.1 Execute no terminal o comando abaixo e acesse a pagina e navegue pelos serviço do gerenciador de tarefas :)

php artisan serve 

*Geralmente o terminal retorna o link para acesso, como http://127.0.0.1:8000/



