<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('SYSTEM_MESSAGE_TYPE_UNAUTHORIZED', 1);
define('SYSTEM_MESSAGE_TYPE_OBJECT_NOT_FOUND', 2);
define('SYSTEM_MESSAGE_TYPE_MENU_HAS_CONTENT', 3);
define('SYSTEM_MESSAGE_TYPE_FILE_UPLOAD_ERROR', 4);
define('SYSTEM_MESSAGE_TYPE_FILE_NOT_FOUND', 5);

define('CONTENT_TYPE_STATIC', 1);
define('CONTENT_TYPE_DYNAMIC', 2);
define('CONTENT_TYPE_URL', 3);

define('CONTENT_STATUS_ACTIVE', 1);
define('CONTENT_STATUS_CANCELED', 2);

define('MENU_TYPE_HEADER', 1);
define('MENU_TYPE_FOOTER', 2);

define('NEWS_MENU_ID', 40);
define('FOOTER_NEWS_MENU_ID', 6);
define('BLOGS_MENU_ID', 55);
define('CONTACT_MENU_ID', 71);

define('ATTRIBUTE_NO_DISPLAY_DYNAMIC_CONTENT', 5);
define('ATTRIBUTE_MAIN_PAGE_NAME', 'home');

define('FACEBOOK_URL', 'https://www.facebook.com/PHR.HumanRights');
define('TWITTER_URL', 'https://twitter.com/NGOPHR');
define('YOUTUBE_URL', 'https://www.youtube.com/channel/UCNojoeg6h-g4eZuzmtAdH0Q');

define('EU_URL', 'http://europa.eu/index_en.htm');
define('CONTACT_URL', '/home/content?menu_id=71');

define('SEND_TO_EMAIL_ADDRESS', 'phr.georgia@gmail.com');
define('SEND_CC_EMAIL_ADDRESS', '');

/* End of file constants.php */
/* Location: ./application/config/constants.php */