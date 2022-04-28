<?php

namespace Source\Service;

use \Source\Model\Admin;
use \Source\Utils\DB\AccessClass;
use \Source\Utils\DB\Connection;
use \PDO;

class AdminService {

  private AccessClass $dao;

  public function __construct(){
   $this->dao = new AccessClass('admin', new Connection);
  }
  /**
   * responsável por retornar um usuário através do seu email
   * @param  string $email
   * @return Admin
   */
  public function getAdmin(string $email): Admin {
    return $this->dao->select('email=\''.$email.'\'')->fetchObject(Admin::class);
  }

    /**
     * implementação do método responsável pela inserção no banco
     * @param  Admin $post
     * @return int
     */
    public function create(array $admin = []): int {
      return $this->dao->insert([
        'name'     => $admin['name'],
        'email'    => $admin['email'],
        'password' => password_hash($admin['password'], PASSWORD_DEFAULT)
      ]);
    }

}
