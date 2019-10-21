if [ -z $1 ]
then
   echo "MySql bin path not provided";
   exit 1;
elif [ -z $2 ]
then
   echo "Import file location not provided";
   exit 2;

fi

MYSQL_BIN=$1;
DB_NAME=$2;
#echo $1; exit 0;
CURRENT_PATH=`pwd`;
DB_DUMP_LOCATION="${CURRENT_PATH}/DB_dump";
# echo $DB_DUMP_LOCATION; exit 0;
cd $MYSQL_BIN;
./mysql.exe -u root ${DB_NAME} < "${DB_DUMP_LOCATION}/users.sql"
./mysql.exe -u root ${DB_NAME} < "${DB_DUMP_LOCATION}/categories.sql"
./mysql.exe -u root ${DB_NAME} < "${DB_DUMP_LOCATION}/subcategories.sql"
./mysql.exe -u root ${DB_NAME} < "${DB_DUMP_LOCATION}/items.sql"
./mysql.exe -u root ${DB_NAME} < "${DB_DUMP_LOCATION}/stores.sql"
./mysql.exe -u root ${DB_NAME} < "${DB_DUMP_LOCATION}/units.sql"
./mysql.exe -u root ${DB_NAME} < "${DB_DUMP_LOCATION}/invoice_summaries.sql"
./mysql.exe -u root ${DB_NAME} < "${DB_DUMP_LOCATION}/invoice_details.sql"
#./mysql.exe -u root ${DB_NAME} < "${DB_DUMP_LOCATION}/migrations.sql"
./mysql.exe -u root ${DB_NAME} < "${DB_DUMP_LOCATION}/password_resets.sql"
./mysql.exe -u root ${DB_NAME} < "${DB_DUMP_LOCATION}/telescope_entries.sql"
./mysql.exe -u root ${DB_NAME} < "${DB_DUMP_LOCATION}/telescope_entries_tags.sql"
./mysql.exe -u root ${DB_NAME} < "${DB_DUMP_LOCATION}/telescope_monitoring.sql"