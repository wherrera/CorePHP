<?php

if(file_exists('config/settings.php')) {
    require_once 'config/settings.php';
} else if(file_exists('config/prod.settings.php')) {
    require_once 'config/prod.settings.php';
} else if(file_exists('config/stage.settings.php')) {
    require_once 'config/stage.settings.php';
} else {
    require_once 'config/default.settings.php';
}

require_once 'framework/core.class.php';
