## Weather Api Service Integration

## Installation
- clone the repo
```
$ git clone https://github.com/mohamedgaber-intake40/weather-integration-task
```
- move to the project directory
```
$ cd weather-integration-task
```
- install required packages
```
$ ./docker/composer install
```

- copy environment variables file
```
$ cp .env.example .env
```

```
$ ./docker/php-artisan key:generate
```
- add services keys values in .env ,i have used these two services (**to ensure that change api service will not affect the code**)
  - [weatherbit](https://www.weatherbit.io/)
  - [open-meteo](https://open-meteo.com/)

to run the server (base url : http://localhost:8081)
```
$ docker compose up
```

to run test

```
$ ./docker/php-artisan test --order-by random
```

you can test the api by import postman collection file included in the repo.

- there is shell scripts helpers to run composer and php artisan command in the docker container
    - for composer use ./docker/composer
    - for artisan use ./docker/php-artisan
