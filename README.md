![Carefy](https://th.bing.com/th/id/OIP.1IYWqsN38X1AsZjkrq0nrwHaEK?w=301&h=180&c=7&r=0&o=5&pid=1.7)


Este projeto foi realizado para fins avaliatórios.


## 🚀 Começando

Essas instruções permitirão que você obtenha uma cópia do projeto em operação na sua máquina local para fins de desenvolvimento e teste.


### 📋 Pré-requisitos

Tenha o docker, o php^8.2 e o composer instalados e configurados em sua máquina
https://docs.docker.com/engine/install/
https://getcomposer.org/download/

Faça o clone do projeto em sua máquina

```
git clone https://github.com/Abnerugeda/carefy-app.git
```

### 🔧 Instalação

- Renomeie o arquivo .env.example para .env
- O projeto rodará na porta 80.
- Qualquer alteração de variáveis de ambiente poderá ser alterada em .env

Sendo comuns mudanças:

```
APP_URL=http://localhost
APP_PORT=8989
DB_PORT=3306
DB_DATABASE=carefy_app
DB_USERNAME=root
DB_PASSWORD=
```

Adicionar variaveis:
```
WWWGROUP=1000
WWWUSER=1000
PWD=1000

```
obs: caso alguma alteração seja feita em .env, certifique-se de que o docker-compose esteja condizente.

### Subir projeto no docker

```
composer install
./vendor/bin/sail up
```
### instalação Swagger

```
composer require symfony/yaml:^6.4
composer require "darkaonline/l5-swagger"
php artisan l5-swagger:generate

```
##### O swagger abrirá em http://[seu host]:[sua porta]/api/documentation

