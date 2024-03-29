<?php

namespace Source\Utils\DB;

/**
 * classe responsável por administrar a paginação
 */
class Pagination {
  /**
   * número de itens por página
   * @var int
   */
  private int $limit;
  /**
   * resultados
   * @var int
   */
  private int $results;
  /**
   * número total de páginas resultado
   * @var int
   */
  private int $pages;
  /**
   * página atual
   * @var int
   */
  private int $currentPage;

  public function __construct($results, $limit = 10, $currentPage = 1){
   $this->results = $results;
   $this->limit = $limit;
   $this->currentPage = (is_numeric($currentPage) && $currentPage > 0) ? $currentPage : 1;
   $this->setPages();
  }

  /**
   * seta o número de páginas
   */
  private function setPages(): void {
   $this->pages = $this->results > 0 ? ceil($this->results / $this->limit) : 1;
   //seta a página atual
   $this->currentPage = $this->currentPage <= $this->pages ? $this->currentPage : $this->pages;
  }

  /**
   * calcula e retorna o sql de limit
   * @return string
   */
  public function getLimit(): string {
    //calcula o offset exemplo (0,10);
    $offset = ($this->limit * ($this->currentPage - 1));

    //retorna a sql pronta
    return $offset.','.$this->limit;
  }
  /**
   * método responsável por retornar as páginas do app
   * @return array
   */
  public function getPages(): array {
    if($this->pages == 1) return [];
    //inicia um array onde serão inseridas as páginas
    $pages = [];
    //para cada página, adiciona no array com as chaves 'page' e 'current',
    //onde 'page' é o numero da página e 'current' verifica se a mesma é a página atual
    for($i = 1; $i <= $this->pages; $i++) {
      $pages[] = [
        'page'    => $i,
        'current' => $i === $this->currentPage
      ];
    }
    return $pages;
  }

}
