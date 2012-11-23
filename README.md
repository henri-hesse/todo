Todos is a small application for keeping track of tasks that need to be done.
It runs on web server (PHP + MySQL) and is build on Yii PHP framework & AngularJS JavaScript framework.

Dev install howto:

1. Copy all files to a folder with web access
2. Make sure these folders exist and that they (and the files inside) are writable by the web server process.
	- protected/runtime/
	- css/
3. Update database connection details in protected/config/main.php. You may set database name, username and password.
4. Create an empty database (with the same name as in step 3) and run the SQL statements found in protected/data/schema.mysql.sql for this database.

That's it! Point your browser to the index.php (found in the root folder) and start by registering a new user.