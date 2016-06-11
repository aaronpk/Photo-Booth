<?php
chdir('..');
include('vendor/autoload.php');

$fb = new FacebookClient();
$fb->getPageToken($_POST['token']);
