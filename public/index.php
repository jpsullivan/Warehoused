<?php
/**
 * Set all the paths
 */
$app_path		= '../fuel/app/';
$package_path	= '../fuel/packages/';
$core_path		= '../fuel/core/';

/**
 * If you wish to display all errors for debugging purposes set this to true.  Leave this as false when in production.
 */
define('DEBUG', true);

/**
 * If you your server does not have a default timezone set, E_WARNING messages will be generated by PHP.  To resolve this
 * issue uncomment this line and change the timezone to fit your needs.
 */
//date_default_timezone_set('UTC');

/**
 * Define the internal encoding to use.
 *
 * @todo Re-evaluate how to handle this.
 */
define('INTERNAL_ENC', 'UTF-8');

/**
 * Website docroot
 */
define('DOCROOT', __DIR__.DIRECTORY_SEPARATOR);

( ! is_dir($app_path) and is_dir(DOCROOT.$app_path)) and $app_path = DOCROOT.$app_path;
( ! is_dir($core_path) and is_dir(DOCROOT.$core_path)) and $core_path = DOCROOT.$core_path;
( ! is_dir($package_path) and is_dir(DOCROOT.$package_path)) and $package_path = DOCROOT.$package_path;

define('APPPATH', realpath($app_path).DIRECTORY_SEPARATOR);
define('PKGPATH', realpath($package_path).DIRECTORY_SEPARATOR);
define('COREPATH', realpath($core_path).DIRECTORY_SEPARATOR);

// Bootup the core
require_once COREPATH.'bootstrap.php';

// Boot the app
require_once APPPATH.'bootstrap.php';

/* End of file index.php */