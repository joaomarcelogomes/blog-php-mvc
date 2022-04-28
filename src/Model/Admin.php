<?php

namespace Source\Model;

/**
 * classe modelo de entidade de Admin
 */
class Admin {
  /**
   * id do admin
   * @var int
   */
  private int $id;
  /**
   * nome do admin
   * @var string
   */
  private string $name;
  /**
   * email de admin
   * @var string
   */
  private string $email;
  /**
   * senha do usuário
   * @var string
   */
  private string $password;
  
  public function getId(): int {
   return $this->id;
  }

  public function getName(): string {
   return $this->name;
  }

  public function getEmail(): string {
   return $this->email;
  }

  public function getPassword(): string {
   return $this->password;
  }
}
