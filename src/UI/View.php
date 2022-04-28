<?php

namespace Source\UI;

/**
 * classe de view
 */
class View {

  /**
   * método responsável por retornar o conteúdo de uma view
   * @param  string $path
   * @return string
   */
  private static function getContentView($path): string {
    //monta o diretório total do arquivo html
    $file = __DIR__ . '/../../resources/view/' . $path . '.html';
    //se o arquivo existir, o retorna;
    return file_exists($file) ? file_get_contents($file) : '';
  }

  /**
   * método responsável por renderizar o conteúdo de uma view
   * @param  string $path
   * @return string
   */
  public static function render($path, $vars = []): string {
    //pega o conteúdo do arquivo ;
    $content = self::getContentView($path);
    //pega as chaves das variáveis do array
    $keys = array_keys($vars);
    //altera as chaves para o padrão dos arquivos html
    $keys = array_map(function($item) {
      return '{{'.$item.'}}';
    }, $keys);
    //retorna a página com o conteúdo pronto
    return str_replace($keys,array_values($vars),$content);
  }

}
