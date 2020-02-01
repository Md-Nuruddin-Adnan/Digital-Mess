<?php
define('HOSTNAME', 'localhost');
define('USERNMAE', 'root');
define('PASSWORD', '');
define('DATABASE_NAME', 'digital_mess');

$db_connect = mysqli_connect(HOSTNAME, USERNMAE, PASSWORD, DATABASE_NAME);

?>