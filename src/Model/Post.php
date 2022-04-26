<?php

namespace Source\Model;

class Post {
  /**
   * id do objeto Post
   * @var integer
   */
  private int $id;

  /**
   * titulo do post
   * @var string
   */
  private string $title;

  /**
   * conteúdo do post
   * @var string
   */
  private string $content;

  /**
   * url da imagem do post
   * @var string
   */
  private string $img;

  /**
   * data de postagem/atualização
   * @var string (date)
   */
  private string $date;

  /**
   * método responsável por retornar o id
   * @return int
   */
  public function getId(): int {
   return $this->id;
  }

  /**
   * método responsável por retornar o título
   * @return string
   */
  public function getTitle(): string {
   return $this->title;
  }

  /**
   * método responsável por retornar o conteúdo
   * @return string
   */
  public function getContent(): string {
   return $this->content;
  }

  /**
   * método responsável por retornar a imagem
   * @return string
   */
  public function getImg(): string {
   return $this->img;
  }

  /**
   * método responsável por retornar a data
   * @return string
   */
  public function getDate(): string {
   return $this->date;
  }

  /**
   * método responsável por setar o título
   * @param string $title
   */
  public function setTitle($title): void {
   $this->title = $title;
  }

  /**
   * método responsável por setar o conteúdo
   * @param [type] $content
   */
  public function setContent($content): void {
   $this->content = $content;
  }

  /**
   * método responsável por setar a imagem
   * @param [type] $img
   */
  public function setImg($img): void {
   $this->img = $img;
  }
}
