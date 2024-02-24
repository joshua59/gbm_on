<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$active_group = 'default';
$active_record = TRUE;

//dev
$db['default']['hostname'] = '10.14.152.87';
$db['default']['username'] = 'gbmon';
$db['default']['password'] = 'J4N64NLUP4L461';
$db['default']['database'] = 'gbm_new_dev';

//staging
// $db['default']['hostname'] = '10.1.18.200';
// $db['default']['username'] = 'gbm_apps';
// $db['default']['password'] = 'Beru@ngG3ndut!!';
// $db['default']['database'] = 'gbm_staging';

//GBM Dev TEST
// $db['default']['hostname'] = '10.14.153.156';
// $db['default']['username'] = 'gbmon_test';
// $db['default']['password'] = 'T3ST_p@ssword';
// $db['default']['database'] = 'gbm_test';

//prod
// $db['default']['hostname'] = '10.1.18.206';
// $db['default']['username'] = 'app_gbmo';
// $db['default']['password'] = 'T3rkendal14pik+';
// $db['default']['password'] = 'J4N64N.LUP4.L461.C0Y';
// $db['default']['database'] = 'gbm_prod';

$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['port']     = 3306;
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;
/*
  | -------------------------------------------------------------------
  | DATABASE CONNECTIVITY SETTINGS
  | -------------------------------------------------------------------
  | This file will contain the settings needed to access your database.
  |
  | For complete instructions please consult the 'Database Connection'
  | page of the User Guide.
  |
  | -------------------------------------------------------------------
  | EXPLANATION OF VARIABLES
  | -------------------------------------------------------------------
  |
  | ['hostname'] The hostname of your database server.
  | ['username'] The username used to connect to the database
  | ['password'] The password used to connect to the database
  | ['database'] The name of the database you want to connect to
  | ['dbdriver'] The database type. ie: mysql.  Currently supported:
  mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
  | ['dbprefix'] You can add an optional prefix, which will be added
  |        to the table name when using the  Active Record class
  | ['pconnect'] TRUE/FALSE - Whether to use a persistent connection
  | ['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
  | ['cache_on'] TRUE/FALSE - Enables/disables query caching
  | ['cachedir'] The path to the folder where cache files should be stored
  | ['char_set'] The character set used in communicating with the database
  | ['dbcollat'] The character collation used in communicating with the database
  |        NOTE: For MySQL and MySQLi databases, this setting is only used
  |          as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
  |        (and in table creation queries made with DB Forge).
  |          There is an incompatibility in PHP with mysql_real_escape_string() which
  |          can make your site vulnerable to SQL injection if you are using a
  |          multi-byte character set and are running versions lower than these.
  |          Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
  | ['swap_pre'] A default table prefix that should be swapped with the dbprefix
  | ['autoinit'] Whether or not to automatically initialize the database.
  | ['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
  |             - good for ensuring strict SQL while developing
  |
  | The $active_group variable lets you choose which connection group to
  | make active.  By default there is only one group (the 'default' group).
  |
  | The $active_record variables lets you determine whether or not to load
  | the active record class
 */

/* End of file database.php */
/* Location: ./application/config/database.php */