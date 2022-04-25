<?php

namespace Source\Model;

class Post {

  private int $id;

  private string $title;

  private string $content;

  private string $img;

  private string $date;

  public function getId(): int {
   return $this->id;
  }

  public function getTitle(): string {
   return $this->title;
  }

  public function getContent(): string {
   return $this->content;
  }

  public function getImg(): string {
   return $this->img;
  }

  public function getDate(): string {
   return $this->date;
  }

  public function setTitle($title): void {
   $this->title = $title;
  }

  public function setContent($content): void {
   $this->content = $content;
  }

  public function setImg($img): void {
   $this->img = $img;
  }
}
