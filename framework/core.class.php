<?php
require_once 'database.class.php';
require_once 'mysqldatabase.class.php';
require_once 'databasemanager.class.php';
require_once 'session.class.php';
require_once 'controller.class.php';
require_once 'paginator.class.php';
require_once 'validation.class.php';
require_once 'dateutility.class.php';
require_once 'http.class.php';
require_once 'mimetypes.class.php';

date_default_timezone_set(Settings::DEFAULT_TIMEZONE);

define('LINK_ROOT','/index.php/');
define('ER_DUP_ENTRY',1062);

class Core {
    const PASSWORD_SALT = "";
}
?>