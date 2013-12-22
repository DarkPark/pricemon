<?php
/**
 * Main init file
 */

set_time_limit(0);

date_default_timezone_set('Europe/Kiev');

error_reporting(E_ALL ^ E_DEPRECATED);

define('EOL', "\n");
define('app_path_root', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
define('app_path_db',   app_path_root . 'db'       . DIRECTORY_SEPARATOR);
define('app_path_lib',  app_path_root . 'lib'      . DIRECTORY_SEPARATOR);
define('app_path_logs', app_path_root . 'logs'     . DIRECTORY_SEPARATOR);
define('app_path_pub',  app_path_root . 'public'   . DIRECTORY_SEPARATOR);
define('app_path_temp', '/dev/shm/pricemon/');
define('app_log_file',  app_path_logs . date('Ym') . '.log');

include app_path_lib . 'firephp/fb.php';
include app_path_lib . 'sqlite.php';
include app_path_lib . 'tools.php';
include app_path_lib . 'simple_html_dom.php';

// general init timestamp
$time_start = time();

// curl post data for login
$curl_auth = array('log'=>'RaulBox', 'pass'=>'123456');

// create temp dir if not exist
if ( !is_dir(app_path_temp) ) {
	umask(0);
	mkdir(app_path_temp, 0777);
}

// db connection
try {
	$dbh = new PDO('sqlite:' . app_path_db . 'pricemon.sqlite');
	//$dbh->query('PRAGMA encoding = "UTF-8"');
} catch ( PDOException $e ) {
	die('Connection failed: ' . $e->getMessage());
}

?>