<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// $dev_data = array('id'=>'-1','firstname'=>'Developer','lastname'=>'','username'=>'dev_oretnom','password'=>'5da283a2d990e8d8512cf967df5bc0d0','last_login'=>'','date_updated'=>'','date_added'=>'');
// if(!defined('dev_data')) define('dev_data',$dev_data);

if(!defined('base_url')) define('base_url','https://php.smallartspremiacoes.com/');
if(!defined('base_app')) define('base_app', str_replace('\\','/',__DIR__).'/' );
if(!defined('DB_SERVER')) define('DB_SERVER',"localhost");
if(!defined('DB_USERNAME')) define('DB_USERNAME',"u529293500_novo");
if(!defined('DB_PASSWORD')) define('DB_PASSWORD',"SmallArts333444#");
if(!defined('DB_NAME')) define('DB_NAME',"u529293500_novo");

?>