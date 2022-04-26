<?php

namespace Source\Utils\DB;
use \PDO;
use \PDOStatement;
use \PDOException;

/**
 * classe responsável por instanciar um novo DAO
 */
class AccessClass {

  /**
   * conexão com o banco
   * @var PDO
   */
  private PDO $conn;

  /**
   * nome da tabela a ser manipuladad
   * @var string
   */
  private string $table;

  /**
   * construtor responsável por instanciar nome de tabela e conexão
   * @param string     $table
   * @param Connection $conn
   */
  public function __construct(string $table, Connection $conn){
   $this->table = $table;
   $this->conn = $conn->getConnection();
  }

  /**
   * método responsável por executar as queries preparadas
   * @param  string       $query
   * @param  array        $params
   * @return PDOStatement
   */
  public function executeQuery(string $query, array $params = []): PDOStatement {
    try {
      $statement = $this->conn->prepare($query);
      $statement->execute($params);

      return $statement;
    } catch (PDOException $ex) {
      die('ERROR: ' . $ex->getMessage());
    }
  }

  /**
   * método responsável por executar os inserts
   * @param  array $values
   * @return int
   */
  public function insert(array $values): int {
    $fields = array_keys($values);
    $binds = array_pad([], count($fields) ,'?');

    $query = 'INSERT INTO ' . $this->table . ' ('. implode(',', $fields) .') VALUES (' . implode(',', $binds) . ')';

    $this->executeQuery($query, array_values($values));

    return $this->conn->lastInsertId();
  }

  /**
   * método responsável por executar os selects
   * @param  string       $where
   * @param  string       $order
   * @param  string       $limit
   * @param  string       $fields
   * @return PDOStatement
   */
  public function select(string $where = null, string $order = null, string $limit = null, string $fields = '*'): PDOStatement {
    $where = isset($where) ? ' WHERE ' . $where : '';
    $order = isset($order) ? ' ORDER BY ' . $order : '';
    $limit = isset($limit) ? ' LIMIT ' . $limit : '';

    $query = 'SELECT ' . $fields . ' FROM ' . $this->table . $where . $order . $limit;

    return $this->executeQuery($query);
  }

  /**
   * método responsável pela execução dos updates
   * @param  int   $id
   * @param  array $values
   * @return bool
   */
  public function update(int $id, array $values): bool {
    $fields = array_keys($values);
    $query = 'UPDATE ' . $this->table . ' SET ' . implode('=?,', $fields) . '=? WHERE id=' .$id;

    $this->executeQuery($query,array_values($values));

    return true;
  }

  /**
   * método responsável pelos deletes
   * @param  int  $id
   * @return bool
   */
  public function delete(int $id): bool {
    $query = 'DELETE FROM ' . $this->table . ' WHERE id=' . $id;

    $this->executeQuery($query);

    return true;
  }

}
