## Installation Instructions
- You have to confirm if vendor folder exists or not.
    - if not exist, run 'composer install' from the projects root folder.
    - From the projects root folder run 'php artisan key:generate'
- Create a MySQL database for the project
    - mysql -u root -p
    - create database temperature;
    - \q

- Run 'npm install'
- Run 'npm run dev'

- Copy .env.example to .env
    - cp .env.example .env
- Configure your .env file
    - APP_NAME="Temperature Logs"
    - DB_DATABASE=temperature
    - DB_USERNAME=root
    - DB_PASSWORD=
- From the projects root folder run 'php artisan migrate:fresh --seed'
- You can move the log files to /public/csv
    - The folder strucure should be like this "/public/csv/onsemi-02/logs/2020-08-17/logs.csv"
    - You can add many enterance folders and date folders
- Configuration Crontab
    - 0 * * * * cd "path of project root folder"  && php artisan scan:files
- Run 'php artisan scan:files'
- Run 'php artisan serve'
- Start server at http://localhost:8000

- SuperAdmin username: superadmin
- SuperAdmin Password: 123456

- Admin username: admin1
- Admin Password: 123456
