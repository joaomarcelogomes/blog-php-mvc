<?php

namespace Source\Service;

interface ServiceContract {
  public function create($obj);
  public function list(string $order = null, string $limit = null, string $fields = '*');
  public function load(int $id);
  public function update(int $id, array $values);
  public function delete(int $id);
}
