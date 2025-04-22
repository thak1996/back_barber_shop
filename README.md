<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

```
# Comando de Permissão
sudo chown -R $USER:$USER .

# Buildar o projeto
docker-compose up -d --build

# Excluir os Containers
docker-compose down -v

# Executar comando dentro do container
docker-compose exec app <Comand>

#instalar dependencias
docker-compose exec app composer install

# Migrations e Seeders
docker-compose exec app php artisan migrate:fresh --seed

# Comando para entrar no container
docker-compose exec app bash

# Gerar informações do swagger
docker-compose exec app php artisan l5-swagger:generate

#Gerar Jwt
docker-compose exec app php artisan key:generate
```
