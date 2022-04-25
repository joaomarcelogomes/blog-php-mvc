<?php

namespace Source\Utils\DB;
use \PDO;
use \PDOStatement;
use \PDOException;

class AccessClass {

  private PDO $conn;

  private string $table;

  public function __construct(string $table, Connection $conn){
   $this->table = $table;
   $this->conn = $conn->getConnection();
  }

  public function executeQuery(string $query, array $params = []): PDOStatement {
    try {
      $statement = $this->conn->prepare($query);
      $statement->execute($params);

      return $statement;
    } catch (PDOException $ex) {
      die('ERROR: ' . $ex->getMessage());
    }
  }

  public function insert(array $values): int {
    $fields = array_keys($values);
    $binds = array_pad([], count($fields) ,'?');

    $query = 'INSERT INTO ' . $this->table . ' ('. implode(',', $fields) .') VALUES (' . implode(',', $binds) . ')';

    $this->executeQuery($query, array_values($values));

    return $this->conn->lastInsertId();
  }

  public function select(string $where = null, string $order = null, string $limit = null, string $fields = '*'): PDOStatement {
    $where = isset($where) ? ' WHERE ' . $where : '';
    $order = isset($order) ? ' ORDER BY ' . $order : '';
    $limit = isset($limit) ? ' LIMIT ' . $limit : '';

    $query = 'SELECT ' . $fields . ' FROM ' . $this->table . $where . $order . $limit;

    return $this->executeQuery($query);
  }

  public function update(int $id, array $values): bool {
    $fields = array_keys($values);
    $query = 'UPDATE ' . $this->table . ' SET ' . implode('=?,', $fields) . '=? WHERE id=' .$id;

    $this->executeQuery($query,array_values($values));

    return true;
  }

  public function delete(int $id): bool {
    $query = 'DELETE FROM ' . $this->table . ' WHERE id=' . $id;

    $this->executeQuery($query);

    return true;
  }

}
