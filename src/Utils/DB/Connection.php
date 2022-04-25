<?php

namespace Source\Utils\DB;

use \PDO;
use \PDOException;

class Connection {

  const DB_HOST = 'localhost';

  const DB_NAME = 'blog';

  const DB_USER = 'root';

  const DB_PASS = 'fogonocampo';

  private PDO $conn;

  public function __construct(){
   $this->setConnection();
  }

  private function setConnection(): void {
   try {
     $this->conn = new PDO('mysql:host='.self::DB_HOST.';dbname='.self::DB_NAME,self::DB_USER,self::DB_PASS);
     $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
   } catch (PDOException $ex) {
     die('ERROR: ' . $ex->getMessage());
   }
  }

  public function getConnection(): PDO {
    return $this->conn;
  }
}
