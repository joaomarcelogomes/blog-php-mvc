<?php

namespace Source\Utils\DB;

class Pagination {

  private int $limit;

  private int $results;

  private int $pages;

  private int $currentPage;

  public function __construct($results, $limit = 10, $currentPage = 1){
   $this->results = $results;
   $this->limit = $limit;
   $this->currentPage = (is_numeric($currentPage) && $currentPage > 0) ? $currentPage : 1;
   $this->setPages();
  }

  private function setPages(): void {
   $this->pages = $this->results > 0 ? ceil($this->results / $this->limit) : 1;

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

  public function getPages(): array {
    if($this->pages == 1) return [];

    $pages = [];
    for($i = 1; $i <= $this->pages; $i++) {
      $pages[] = [
        'page'    => $i,
        'current' => $this->currentPage
      ];
    }
    return $pages;
  }

}
