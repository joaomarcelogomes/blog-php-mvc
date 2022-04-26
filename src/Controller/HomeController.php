<?php

namespace Source\Controller;
use \Source\UI\View;

class HomeController extends PageController {

  public static function getHome(): string {
   $content = View::render('pages/home', [
     'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
   ]);
  
   return parent::getPage('HOME', $content);
  }

}
