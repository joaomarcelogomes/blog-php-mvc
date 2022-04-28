<?php

namespace Source\Utils\Session\Admin;

use \Source\Model\Admin;

/**
 * classe responsável por administrar o login do admin
 */
class Login {
  /**
   * método responsável por iniciar a session caso não tenha sido iniciada previamente
   */
  private static function startSession(): void {
    if(session_status() != PHP_SESSION_ACTIVE) {
      session_start();
    }
  }
  /**
   * método responsável por executar o login
   * @param  Admin $admin
   * @return bool
   */
  public static function login($admin): bool {
    //cria nova sessão
    self::startSession();
    //define a sessão
    $_SESSION['admin'] = [];
    $_SESSION['admin']['user'] = [
      'id'    => $admin->getId(),
      'name'  => $admin->getName(),
      'email' => $admin->getEmail()
    ];
    //sucesso
    return true;
  }

  /**
   * método responsável por verificar se o usuário está logado
   * @return bool
   */
  public static function isLogged(): bool {
    self::startSession();
    return isset($_SESSION['admin']['user']['id']);
  }

  /**
   * método responsável por executar o logout do admin
   * @return boolean
   */
  public static function logout(){
    self::startSession();

    //desloga o usuário
    unset($_SESSION['admin']['user']);

    return true;
  }
  /**
   * método responsável por retornar o usuário logado
   * @return array
   */
  public static function getLogged(): array {
    self::startSession();
   return $_SESSION['admin']['user'];
  }
}
