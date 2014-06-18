<?php
    define("CONFIGFILE", "DBConfig.ini");

    class database extends PDO{
        /**
        * Create an Instance of DB handlerDB Handler with a Extends to PDO Native PHP Class
        *
        * @param string $database
        * @param string $server
        */
        function __construct($database = "geodisplay", $server = "myDB"){
            if (!$settings = parse_ini_file(CONFIGFILE, TRUE)) throw new exception('Unable to open ' . CONFIGFILE . '.');
            $dsn = $settings[$server]["driver"].':host='.$settings[$server]["host"].';dbname='.$database;
            parent::__construct($dsn,$settings[$server]["user"],$settings[$server]["password"],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        }
    }
?>