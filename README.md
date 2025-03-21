
# TestHub

A web app built with Laravel and FilamentPHP to manage tests.


## Requirements

- Docker


## Run Locally

Clone project

```bash
  git clone https://github.com/DanielTavares33/test-management.git
```

#### Go to the project directory

```bash
  cd test-management
```

#### Generate .env file

```bash
  cp .env.example .env
```

#### Build docker containers

```bash
  docker compose up
```

#### Enter docker container

```bash
  docker exec -it testhub-php bash
```

#### Run migrations and seed database (inside container)

```bash
  php artisan migrate --seed
```

#### Generate app key (inside container)

```bash
  php artisan key:generate
```


## Login Locally

- User: admin@admin.com
- Password: admin

