<?php

class FacebookClient {
  private $_token;

  public function __construct() {
    $this->_token = redis()->get('photo-booth-token');
  }

  public function saveToken($token) {
    $this->_token = $token;
    redis()->set('photo-booth-token', $token);
  }

  public function getPageToken($userToken) {
    $data = $this->get(Config::$pageID.'?fields=access_token', $userToken);
    $this->saveToken($data->access_token);
  }

  public function get($path, $token=false) {
    $ch = curl_init('https://graph.facebook.com/'.$path);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . ($token ?: $this->_token)
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    return json_decode($response);
  }

  public function post($path, $params, $token=false) {
    $ch = curl_init('https://graph.facebook.com/'.$path);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . ($token ?: $this->_token)
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    return json_decode($response);
  }

  public function upload($path, $filename) {
    $ch = curl_init('https://graph.facebook.com/'.$path);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . $this->_token
    ]);

    $params = [
      'photo' => new CURLFile($filename)
    ];
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    return json_decode($response);
  }
}
