xammp

https://www.apachefriends.org/pt_br/download.html


git bash 

https://git-scm.com/downloads


composer 


https://getcomposer.org/doc/00-intro.md



acesse a pasta htdocs dentro de xampp e clone o repositório usando o terminal do git bash.

comando para clonar 

git clone https://github.com/Mariluzzz/TestBaummer.git

após clonar, navegue ate a pasta do xampp/htdocs/TestBaummer copie o .env.exemple, renomeie somente como .env e substitua as
variáveis referente a conexão com o banco por essas abaixo.


DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gerenciamentoDeTarefas
DB_USERNAME=root
DB_PASSWORD=root
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci


abra um novo terminal na mesma pasta ( xampp/htdocs/TestBaummer) e execute o comando 

composer install 

após finalizado, execute 

composer update 

após isso, starte o apache e o mysql do xampp no painel de controle, estando rodando o mysql e o apache,

clique em admin, de mysql, ira abrir no browser localhost/phpadmin/index.php, localize a aba de contas usuário, clique nela.

Acesse o usuário root com o nome do host como localhost e clique em editar privilégios.
Após isso em "Change password", entre com a senha "root" e redigite-a "root". Clique em executar após isso.

Agora navegue até esse caminho xampp/phpMyAdmin e abra o arquivo config.inc.php, já no arquivo 
na linha 21, coloque a senha de como root, dessa forma 

$cfg['Servers'][$i]['password'] = 'root';

Recarregue a pagina do phpAdmin e voltará o funcionamento normalmente.

 
No terminal novamente, execute em xampp/htdocs/TestBaummer 

php artisan db:create

isso fará com que o banco e as tabelas sejam criadas, após isso 
execute 

php artisan key:generate

e após

php artisan serve 


e acesse a pagina e navegue pelos serviço do gerenciador de tarefas :)

