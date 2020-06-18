# Aplicação 

Pré-requisitos:
Instalar o php(é necessário salvar o local do arquivo nas variáveis de sistema no caminho "path". Exemplo: C:\PHP7).
Instalar o phpunit(é necessário salvar o local do arquivo nas variáveis de ambiente, depois abra o cmd, abra a pasta do arquivo e insira o código @php "%~dp0phpunit.phar" %* > phpunit.cmd)

Para rodar a aplicação,abra o cmd, abra a pasta onde se encontra a aplicação e execute:  
    php -S localhost:8888 -t public public/index.php


Para importar os dados financeiros clique no botão "importar" que está na página principal. Ele irá direcionar para a página desejada. Após isso, clique em "escolher arquivo". É necessário que o arquivo importado esteja em formato txt, sendo formatado da seguinte maneira:       

    1--> Id
    2--> Número de Notas Fiscais
    3--> Número de Débitos
    TODOS DEVEM SER SEPARADOS APENAS POR ; E DEVEM SER DE UM POR VEZ.

     Exemplo: 1;4;6

|O SCRIPT DE DUMP DE ESTRUTURA E DADOS DO BANCO DE DADOSD ESTÁ NA PASTA scripts_dump
