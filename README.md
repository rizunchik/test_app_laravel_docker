Installation

1. Clone the repository

git clone git@github.com:rizunchik/test_app_laravel_docker.git

2. Run docker

docker compose up -d

3. Check or change:

    - file .env

        DB_DATABASE

    - file docker-compose.yml

        MYSQL_DATABASE

    The values ​​must be the same. If a database with that name already exists, change the name.

    - file docker-compose.yml

        nginx:
            ports:
            - 8080:80
        db:
            ports:
            - 3306:3306
        node:
            ports: 
            - 5173:5173

        If ports are busy, change it before ":".

4. Run migrations

docker compose exec app php artisan migrate

5. Open browser

    http://localhost:8080/ or http://localhost:your_port/


