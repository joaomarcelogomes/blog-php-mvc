<?php

require 'vendor/autoload.php';

use \Source\Service\PostService;
use \Source\Model\Post;

$post = new Post();
$post->setTitle('Ola');
$post->setContent('Esta é uma descrição de post');

$service = new PostService();

echo "<pre>";
print_r($service->load(2));
echo "</pre>"; exit;
