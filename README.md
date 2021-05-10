DR Consultoria Jurídica


Instalação na plataform de hospedagem (Hostoo.io)

Para adaptar a estrutura da hospedagem para uma aplicação Laravel realize o procedimento abaixo:

1) Crie uma nova pasta na raiz da sua hospedagem (fora da pasta public_html) e mova todos os arquivos da sua aplicação Laravel para dentro dela;
2) Se possível, deixe a pasta public_html vazia;
3) Mude o nome da pasta public_html para outro nome (por exemplo, public_html_bkp);
4) Acesse sua hospedagem via SSH;
5) Na linha de comando (SSH) execute os seguintes comandos:

ln -s ~/[APP_LARAVEL]/public ~/public_html

Substitua [APP_LARAVEL] pelo nome da pasta onde está a sua aplicação Laravel (na raiz da hospedagem).

O comando vai criar uma nova pasta "public_html", mas agora como link simbólico para a pasta "public" de sua aplicação Laravel. Caso não saiba como realizar a configuração, você pode solicitar via ticket que a equipe técnica realiza para você.


Instalação do Projeto 

1 - git clone https://github.com/franric/dr_juridico.git

2 - composer require

3 - composer install --optimize-autoloader --no-dev

4 - php artisan config:cache

5 - php artisan route:cache

6 - php artisan view:cache

7 - fazer backup do banco de dados " Se ouver"

