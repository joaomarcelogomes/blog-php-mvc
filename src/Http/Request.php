<?php

namespace Source\Http;

class Request {

  /**
   * headers de requisição
   * @var array
   */
  private array $headers = [];

  /**
   * método http da requisição
   * @var string
   */
  private string $method = '';

  /**
   * variáveis do método post
   * @var array
   */
  private array $postVars = [];

  /**
   * uri da requisição
   * @var string
   */
  private string $uri = '';

  /**
   * parametros de query da uri
   * @var array
   */
  private array $queryParams = [];

  /**
   * router da requisição
   * @var Router
   */
  private Router $router;

  /**
   * método construtor responsável por inicializar as variáveis
   */
  public function __construct($router){
   $this->router      = $router;
   $this->queryParams = $_GET ?? [];
   $this->postVars    = $_POST ?? [];
   $this->method      = $_SERVER['REQUEST_METHOD'] ?? '';
   $this->headers     = getallheaders();
   $this->setUri();
  }

  /**
   * método responsável por setar a uri de request (sem parametros de query)
   */
  private function setUri(): void {
   $xUri = explode('?', $_SERVER['REQUEST_URI']);

   $this->uri = $xUri[0];
  }

  public function getRouter(): Router {
   return $this->router;
  }

  public function getUri(): string {
   return $this->uri;
  }

  public function getHeaders(): array {
   return $this->headers;
  }

  public function getPostVars(): array {
   return $this->postVars;
  }

  public function getMethod(): string {
   return $this->method;
  }

  public function getQueryParams(): array {
   return $this->queryParam;
  }


}
