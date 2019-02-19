<?php

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }
        if (strlen($value) > 1 && substr($value, 0, 1) == '"' && substr($value, 0, -1) == '"') {
            return substr($value, 1, -1);
        }
        return $value;
    }
}

(function () {
    \Ruesin\Utils\Config::loadPath(ROOT_DIR . '/config/');
    try {
        $dotenv = \Dotenv\Dotenv::create(ROOT_DIR);
        $dotenv->overload();
        $require = array_filter(explode(',', str_replace(' ', '', env('REQUIRE_ENV'))));
        $require = array_unique(array_merge($require, ['APP_NAME', 'SERVER_TYPE', 'ENTRANCE']));
        $dotenv->required($require);
    } catch (Dotenv\Exception\InvalidPathException $e) {
        die($e->getMessage());
    }
})();
