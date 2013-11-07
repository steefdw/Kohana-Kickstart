<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/Kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Europe/Amsterdam');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}
else
{
  Kohana::$environment = ($_SERVER['SERVER_NAME'] !== 'localhost') ? Kohana::PRODUCTION : Kohana::DEVELOPMENT;
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
	'base_url'   => (Kohana::$environment !== Kohana::PRODUCTION) ? '/kickstart/public' : '', // base URL in development and production
  'index_file' => FALSE,
  'errors'     => (Kohana::$environment !== Kohana::PRODUCTION), // in production: no errors
  'profile'    => (Kohana::$environment !== Kohana::PRODUCTION), // in production: no profiling
  'caching'    => (Kohana::$environment === Kohana::PRODUCTION), // in production: turn cache on  
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
* Cookie
*/
// Set the magic salt to add to a cookie
Cookie::$salt = Kohana::$config->load('appconfig.cookie_salt');
// Set the number of seconds before a cookie expires
Cookie::$expiration = Kohana::$config->load('appconfig.cookie_lifetime');
// Restrict the path that the cookie is available to
Cookie::$path = '/';
// Restrict the domain that the cookie is available to
//Cookie::$domain = 'www.mysite.com'; // <--------------- please set this for production environments
// Only transmit cookies over secure connections
//Cookie::$secure = TRUE;
// Only transmit cookies over HTTP, disabling Javascript access
Cookie::$httponly = TRUE;

/**
 * Set the default language
 */
// check cookie first
$lang = Cookie::get('lang');

// if no cookie, rely on accept_language
if (empty($lang) AND isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
{
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
}

// default to en if language not supported or empty
if ( ! in_array($lang, Kohana::$config->load('appconfig.language')))
{
    $lang = I18n::lang();
}

// set language
I18n::lang($lang);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'auth'       => MODPATH.'auth',       // Basic authentication
	'database'   => MODPATH.'database',   // Database access
	'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	'email'      => MODPATH.'email',      // Email module      : https://github.com/Luwe/Kohana-Email, ko3.3: https://github.com/dfox288/kohana-email
	'pagination' => MODPATH.'pagination', // Pagination module : https://github.com/kloopko/kohana-pagination
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */ 
/* Roles */     
Route::set('user', 'user(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory'     => 'user',
        'controller'    => 'user',
        'action'        => 'index',
    ));        
Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory'     => 'admin',
        'controller'    => 'admin',
        'action'        => 'index',
    ));
Route::set('login', 'login')
    ->defaults(array(
        'controller'    => 'account',
        'action'        => 'login',
    ));
Route::set('logout', 'logout')
    ->defaults(array(
        'controller'    => 'account',
        'action'        => 'logout',
    ));
Route::set('default', '(<controller>(/<action>(/<id>)))')
    ->defaults(array(
      'controller' => 'pages',
      'action'     => 'index',
    ));
//echo Debug::vars( Route::all() );
