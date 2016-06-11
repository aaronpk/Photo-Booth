<?php
chdir('..');
include('vendor/autoload.php');

# get access token from redis
$fb = new FacebookClient();

# Check that the access token is still valid
$me = $fb->get('me');

if(property_exists($me, 'error')) {
  echo "################################\n";
  echo $me->error->message."\n";
  die(1);
}

echo "Signed in as " . $me->name . "\n";
echo $me->link . "\n\n";

# watch folder and upload to facebook

while(true) {
  $files = glob('web/final/*.jpg');

  foreach($files as $file) {
    echo "Uploading " . $file . "\n";
    $result = $fb->upload(Config::$albumID.'/photos', $file);

    if(property_exists($result, 'post_id')) {
      echo "https://www.facebook.com/" . $result->post_id . "\n";
      rename($file, str_replace('/final/','/uploaded/', $file));
    } else {
      echo "################################\n";
      echo "Error uploading photo:\n";
      print_r($result);
      die(1);
    }
  }

  echo "\n";
  echo "Waiting for more photos...\n";
  sleep(10);
}
