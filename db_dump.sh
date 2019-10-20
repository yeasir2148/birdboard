MYSQL_BIN='/e/xampp/mysql/bin/';

cd $MYSQL_BIN;
./mysqldump.exe -u root --no-create-info laravel_5-7 categories > /e/xampp/htdocs/myProjects/birdboard/DB_dump/categories.sql;
./mysqldump.exe -u root --no-create-info laravel_5-7 subcategories > /e/xampp/htdocs/myProjects/birdboard/DB_dump/subcategories.sql;
./mysqldump.exe -u root --no-create-info laravel_5-7 items > /e/xampp/htdocs/myProjects/birdboard/DB_dump/items.sql;
./mysqldump.exe -u root --no-create-info laravel_5-7 stores > /e/xampp/htdocs/myProjects/birdboard/DB_dump/stores.sql;
./mysqldump.exe -u root --no-create-info laravel_5-7 units > /e/xampp/htdocs/myProjects/birdboard/DB_dump/units.sql;
./mysqldump.exe -u root --no-create-info laravel_5-7 invoice_summaries > /e/xampp/htdocs/myProjects/birdboard/DB_dump/invoice_summaries.sql;
./mysqldump.exe -u root --no-create-info laravel_5-7 invoice_details > /e/xampp/htdocs/myProjects/birdboard/DB_dump/invoice_details.sql;
./mysqldump.exe -u root --no-create-info laravel_5-7 migrations > /e/xampp/htdocs/myProjects/birdboard/DB_dump/migrations.sql;
./mysqldump.exe -u root --no-create-info laravel_5-7 users > /e/xampp/htdocs/myProjects/birdboard/DB_dump/users.sql;
./mysqldump.exe -u root --no-create-info laravel_5-7 telescope_entries > /e/xampp/htdocs/myProjects/birdboard/DB_dump/telescope_entries.sql;
./mysqldump.exe -u root --no-create-info laravel_5-7 telescope_entries_tags > /e/xampp/htdocs/myProjects/birdboard/DB_dump/telescope_entries_tags.sql;
./mysqldump.exe -u root --no-create-info laravel_5-7 telescope_monitoring > /e/xampp/htdocs/myProjects/birdboard/DB_dump/telescope_monitoring.sql;
./mysqldump.exe -u root --no-create-info laravel_5-7 password_resets > /e/xampp/htdocs/myProjects/birdboard/DB_dump/password_resets.sql;