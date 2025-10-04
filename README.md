Installation

1. Clone the repository

git clone git@github.com:rizunchik/test_app_laravel_docker.git

2. Run docker

docker compose up -d

3. Check or change:

    - file docker-compose.yml

        MYSQL_DATABASE

    If a database with that name already exists, change the name.

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

4. Open browser

    http://localhost:8080/ or http://localhost:your_port/

    Link on Telescope Jobs

    http://localhost:8080/telescope/jobs


