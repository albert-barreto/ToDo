# ToDo

It's a visual tool for organizing tasks at work and in life.

[Interactive project information](https://gitmemory.com/albert-barreto/ToDo)

## Development

### Prerequisites
Ensure you have the following tools in cmdline:
* PHP (view composer.json for required version)
* Composer ([installation instructions](https://getcomposer.org/doc/00-intro.md))
* Docker

### Run application

In the application directory of the project, download and install dependencies with composer:
```shell
cd application
composer -v install
```

Then, start your Docker environment from the docker directory:
```shell
cd docker
docker-compose up -d
```

## API
Try a `curl localhost/tasks/`, and see API working !!

## UI
In the browser `localhost/todo`

### Framework and libraries
Composer is used for Dependency management
- Config file: [composer.json]()
- Docs: [https://getcomposer.org/doc/01-basic-usage.md]()

Libraries inside PHP application:
- Symfony framework: [https://symfony.com/doc]()
- Twig:[https://twig.symfony.com/]()

### Code quality and standard
Symfony 5 [coding standards](https://symfony.com/doc/current/contributing/code/standards.html) \
PSR [PHP Standard Recommendation](https://www.php-fig.org/)
To help finding violation, we use [PHP Coding Standards Fixer](http://cs.sensiolabs.org/)

### Run tests
Run PHPUnit inside application folder:

```shell
./bin/phpunit tests
```

### PHP (PHP-FPM)
#### Composer is included
```shell
docker-compose run php-fpm composer
```
#### To run fixtures
```shell
docker-compose run php-fpm bin/console doctrine:fixtures:load
```
