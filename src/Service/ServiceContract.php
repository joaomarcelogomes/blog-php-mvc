<?php

namespace Source\Service;

/**
 * interface de serviços
 */
interface ServiceContract {
  /**
   * método responsável por inserir registro no banco
   * @param  Type $obj
   * @return integer
   */
  public function create($obj);
  /**
   * método responsável por listar os registros do banco
   * @param  string $order
   * @param  string $limit
   * @param  string $fields
   * @return array
   */
  public function list(string $order = null, string $limit = null, string $fields = '*');
  /**
   * método responsável por buscar 1 registro no banco
   * @param  int    $id
   * @return Type
   */
  public function load(int $id);
  /**
   * método responsável por atualizar um registro do banco
   * @param  int    $id
   * @param  array  $values
   * @return boolean
   */
  public function update(int $id, array $values);
  /**
   * método responsável por remover um registro do banco
   * @param  int    $id
   * @return boolean
   */
  public function delete(int $id);
}
