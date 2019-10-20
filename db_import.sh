MYSQL_BIN='/e/xampp/mysql/bin/';
DB_DUMP_LOCATION='/e/xampp/htdocs/myProjects/birdboard/DB_dump/';

cd $MYSQL_BIN;
./mysql.exe -u root laravel_5-7 < /e/xampp/htdocs/myProjects/birdboard/DB_dump/users.sql
./mysql.exe -u root laravel_5-7 < /e/xampp/htdocs/myProjects/birdboard/DB_dump/categories.sql
./mysql.exe -u root laravel_5-7 < /e/xampp/htdocs/myProjects/birdboard/DB_dump/subcategories.sql
./mysql.exe -u root laravel_5-7 < /e/xampp/htdocs/myProjects/birdboard/DB_dump/items.sql
./mysql.exe -u root laravel_5-7 < /e/xampp/htdocs/myProjects/birdboard/DB_dump/stores.sql
./mysql.exe -u root laravel_5-7 < /e/xampp/htdocs/myProjects/birdboard/DB_dump/units.sql
./mysql.exe -u root laravel_5-7 < /e/xampp/htdocs/myProjects/birdboard/DB_dump/invoice_summaries.sql
./mysql.exe -u root laravel_5-7 < /e/xampp/htdocs/myProjects/birdboard/DB_dump/invoice_details.sql
./mysql.exe -u root laravel_5-7 < /e/xampp/htdocs/myProjects/birdboard/DB_dump/migrations.sql
./mysql.exe -u root laravel_5-7 < /e/xampp/htdocs/myProjects/birdboard/DB_dump/password_resets.sql
./mysql.exe -u root laravel_5-7 < /e/xampp/htdocs/myProjects/birdboard/DB_dump/telescope_entries.sql
./mysql.exe -u root laravel_5-7 < /e/xampp/htdocs/myProjects/birdboard/DB_dump/telescope_entries_tags.sql
./mysql.exe -u root laravel_5-7 < /e/xampp/htdocs/myProjects/birdboard/DB_dump/telescope_monitoring.sql