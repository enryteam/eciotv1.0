<?php

class session_redis
{

    function __construct()
    {
        $redis_config = pc_base::load_config('cache', 'redis');
        ini_set("session.save_handler", "redis");
        ini_set("session.save_path", "tcp://" . $redis_config['hostname'] . ":" . $redis_config['port']);
        session_start();
    }
}
?>