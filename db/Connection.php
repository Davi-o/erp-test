<?php

namespace Database;

use Database\DatabaseConfiguration;
use PDO;

class Connection extends PDO
{
    private static ?Connection $instance = null;
    
    public function __construct(
        string $dsn,
        string $user = null,
        string $secret = null
    )
    {
        parent::__construct($dsn, $user, $secret);
    }

    public static function getInstance(): Connection 
    {
        if(! isset(self::$instance)){
            try {
                self::$instance = new Connection("sqlite:".DatabaseConfiguration::PATH_TO_DB);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\Throwable $th) {
                error_log($th, 3, "/var/tmp/erp-conn-err.log");
            }
        }    
        return self::$instance;
    }

}