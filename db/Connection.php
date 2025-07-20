<?php

namespace Database;

use Database\DatabaseConfiguration;
use PDO;
use PDOException;

class Connection extends PDO
{
    private static ?Connection $instance = null;
    
    public function __construct(
        string $dsn,
        string $user,
        string $secret
    )
    {
        parent::__construct($dsn, $user, $secret);
    }

    public static function getInstance(): Connection 
    {
        if(! isset(self::$instance)){
            try {
                self::$instance = new Connection(
                    DatabaseConfiguration::LOCALHOST,
                    DatabaseConfiguration::USER,
                    DatabaseConfiguration::SECRET
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                error_log($e->getMessage() . PHP_EOL, 3, "/var/tmp/erp-conn-err.log");            
            }
        }    
        return self::$instance;
    }

}