<?php
chdir('..');
include('vendor/autoload.php');

$files = glob('web/final/*.jpg') + glob('web/uploaded/*.jpg');

$random = $files[array_rand($files)];

header('Content-type: application/json');

if(preg_match('/web\/(final|uploaded)\/(.+)/', $random, $match)) {
  echo json_encode([
    'type' => $match[1],
    'filename' => $match[2]
  ]);
}
