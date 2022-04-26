<?php

namespace Source\Utils\DB;

use \PDO;
use \PDOException;

/**
 * classe responsável pela conexão com o banco
 */
class Connection {
  /**
   * host do banco
   * @var string
   */
  const DB_HOST = 'localhost';
  /**
   * nome do banco
   * @var string
   */
  const DB_NAME = 'blog';
  /**
   * username de acesso ao banco
   * @var string
   */
  const DB_USER = 'root';
  /**
   * senha de acesso ao banco
   * @var string
   */
  const DB_PASS = 'fogonocampo';
  /**
   * conexão
   * @var PDO
   */
  private PDO $conn;

  /**
   * método construtor, responsável por chamar o método que inicia conexão
   */
  public function __construct(){
   $this->setConnection();
  }

  /**
   * método responsável por iniciar a conexão
   */
  private function setConnection(): void {
   try {
     $this->conn = new PDO('mysql:host='.self::DB_HOST.';dbname='.self::DB_NAME,self::DB_USER,self::DB_PASS);
     $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
   } catch (PDOException $ex) {
     die('ERROR: ' . $ex->getMessage());
   }
  }

  /**
   * método responsável por retornar a conexão com o banco
   * @return PDO
   */
  public function getConnection(): PDO {
    return $this->conn;
  }
}
