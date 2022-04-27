<?php

namespace Source\Utils\Session\Admin;

class Login {

  private static function startSession(): void {
    if(session_status() != PHP_SESSION_ACTIVE) {
      session_start();
    }
  }

  public static function login($admin): bool {
    //cria nova sessão
    self::startSession();
    //define a sessão
    $_SESSION['admin']= [
      'id'    => $admin->getId(),
      'name'  => $admin->getName(),
      'email' => $admin->getEmail()
    ];
    //sucesso
    return true;
  }

  public static function isLogged(): bool {
    return (bool) $_SESSION['admin']['id'];
  }
}
