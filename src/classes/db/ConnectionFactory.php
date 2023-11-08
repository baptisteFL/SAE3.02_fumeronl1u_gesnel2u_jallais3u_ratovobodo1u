<?php

namespace iutnc\touiteur\db;

use Exception;
use PDO;

require_once "vendor/autoload.php";
class ConnectionFactory{

    private static $configTab = [];
    public static $bdd;



    public static function setConfig($file){
        self::$configTab = @parse_ini_file($file);
    }

    public static function makeConnection(){
        try{
            self::setConfig("db.config.ini");
            $bdd = @new PDO(self::$configTab['dsn'], self::$configTab['user'], self::$configTab['password']);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$bdd = $bdd;
        }catch(Exception $e){
            $bdd = new PDO("mysql:host=localhost;dbname=sae", "root", "");
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$bdd = $bdd;
        }
    }

}