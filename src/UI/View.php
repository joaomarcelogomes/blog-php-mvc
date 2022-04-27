<?php

namespace Source\UI;

class View {

  /**
   * método responsável por retornar o conteúdo de uma view
   * @param  string $path
   * @return string
   */
  private static function getContentView($path): string {
    $file = __DIR__ . '/../../resources/view/' . $path . '.html';
    
    return file_exists($file) ? file_get_contents($file) : '';
  }

  /**
   * método responsável por renderizar o conteúdo de uma view
   * @param  string $path
   * @return string
   */
  public static function render($path, $vars = []): string {
    $content = self::getContentView($path);

    $keys = array_keys($vars);

    $keys = array_map(function($item) {
      return '{{'.$item.'}}';
    }, $keys);

    return str_replace($keys,array_values($vars),$content);
  }

}
