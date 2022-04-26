<?php

namespace Source\Http;

class Response {

  /**
   * código de status http da resposta
   * @var int
   */
  private int $statusCode;

  /**
   * tipo de conteúdo da resposta
   * @var string
   */
  private string $contentType;

  /**
   * conteúdo da resposta
   * @var mixed
   */
  private mixed $content;

  /**
   * headers da resposta
   * @var array
   */
  private array $headers = [];

  /**
   * método construtor responsável por setar as variáveis
   * @param int    $statusCode
   * @param mixed  $content
   * @param string $contentType
   */
  public function __construct(int $statusCode, mixed $content, string $contentType = 'text/html'){
   $this->statusCode = $statusCode;
   $this->content = $content;
   $this->setContentType($contentType);
  }

  /**
   * método responsável por setar o tipo de conteúdo e adicioná-lo nos headers
   * @param string $contentType
   */
  private function setContentType($contentType): void {
    $this->contentType = $contentType;
    $this->addHeader('Content-type', $contentType);
  }

  /**
   * método responsável por adicionar headers
   * @param string $name
   * @param string $value
   */
  private function addHeader(string $name, string $value): void {
    $this->headers[$name] = $value;
  }

  /**
   * método responsável por enviar a resposta ao navegador
   */
  public function sendResponse(): void {
    //envio do status
    http_response_code($this->statusCode);
    //envio dos headers
    foreach ($this->headers as $key => $value) {
      header($key.': '.$value);
    }
    //impressão de conteúdo
    switch ($this->contentType) {
      case 'text/html':
        echo $this->content;
        break;
    }
  }

}
