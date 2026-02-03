<?php

class Database {
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {
            try {
                // Adapte avec tes identifiants Wamp
                self::$instance = new PDO(
                    "mysql:host=localhost;dbname=tom_troc;charset=utf8", 
                    "root", 
                    ""
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}