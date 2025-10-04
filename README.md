Installation

1. Clone the repository

git clone git@github.com:rizunchik/test_app_laravel_docker.git

2. cd test_app_laravel_docker

<p color="red">If you go straight to step 5, standard passwords will be used.</p>

3. Create .env

    cp .env.example .env

4. Set password in .env

    DB_PASSWORD, 
    DB_ROOT_PASSWORD

5. Check or change:

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

6. Run docker

    docker compose up -d

7. Open browser

    http://localhost:8080/ or http://localhost:your_port/

    Link on Telescope Jobs

    http://localhost:8080/telescope/jobs


