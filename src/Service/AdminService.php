<?php

namespace Source\Service;

use \Source\Model\Admin;
use \Source\Utils\DB\AccessClass;
use \Source\Utils\DB\Connection;
use \PDO;

/**
 * classe de serviço de Admin, responsável por executar as operações de CRUD
 * relacionadas a esta classe
 */
class AdminService {

  /**
   * data access object
   * @var AccessClass
   */
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
     * @param  Admin $admin
     * @return int
     */
    public function create($admin): int {
      return $this->dao->insert([
        'name'     => $admin->getName(),
        'email'    => $admin->getEmail(),
        'password' => $admin->getPassword()
      ]);
    }

}
