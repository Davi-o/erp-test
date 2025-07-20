<?php
namespace Database;

use PDO;

class DatabaseConfiguration {
    const PATH_TO_SQLITE_DB = __DIR__."/database.db";
    const LOCALHOST = "mysql:host=localhost;dbname=erp";
    const USER = "root";
    const SECRET = "1234";
}