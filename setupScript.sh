hostname="localhost"
echo "Input database name (just pick something): "
read database_name
echo "Input new database user Username: "
read username
echo "Input new database user Password: "
read password

echo "Creating User..."
mysql -e "CREATE USER $username IDENTIFIED BY '$password'"
echo "Creating database..."
mysql -e "CREATE DATABASE $database_name"
mysql  $database_name < createdb.sql
mysql -e "GRANT ALL PRIVILEGES ON $database_name.* TO $username"

echo "Writing WebStoryGen dbconf.ini..."
sed -i.bak s/HOSTNAME/$hostname/g dbconf.ini
sed -i.bak s/DATABASE_NAME/$database_name/g dbconf.ini
sed -i.bak s/USERNAME/$username/g dbconf.ini
sed -i.bak s/PASSWORD/$password/g dbconf.ini
rm dbconf.ini.bak
echo "Setup completed successfully! If dependencies are instlled and Apache is properly configured, WebStoryGen should be ready to go."
