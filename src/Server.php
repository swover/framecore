<?php

namespace Swover\Framework;

class Server
{

    public static function run($method)
    {
        $config = self::getConfig();

        $class = new \Swover\Server($config);

        if (!method_exists($class, $method)) {
            die('Method error!' . PHP_EOL);
        }

        call_user_func_array([$class, $method], []);
    }

    private static function getConfig()
    {
        $config = [
            'server_type' => env('SERVER_TYPE'),
            'daemonize' => env('DAEMONIZE', false),
            'process_name' => env('PROCESS_NAME', env('APP_NAME')),
            'worker_num' => env('WORKER_NUM', 1),
            'task_worker_num' => env('TASK_WORKER_NUM', 1),
            'max_request' => env('MAX_REQUEST', 0),
            'log_file' => env('LOG_FILE', ROOT_DIR . '/runtime/' . env('APP_NAME') . '.log'),
            'entrance' => env('ENTRANCE')
        ];

        if ($config['server_type'] == 'http' || $config['server_type'] == 'tcp') {
            $config['host'] = env('HOST', '127.0.0.1');
            $config['port'] = env('PORT', '9501');
            $config['async'] = env('ASYNC', false);
            $config['signature'] = env('SIGNATURE', '');
            $config['trace_log'] = env('TRACE_LOG', true);
        }

        return $config;
    }

}
