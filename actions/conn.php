<?php

class dbconn {

  private $server;
  private $username;
  private $pass;
  private $db;
  private $charset;

  public function connect(){
    $this->server = "localhost";
    $this->username = "";
    $this->pass = "";
    $this->db = "";
    $this->charset = "utf8mb4";

    try {
      $dsn = "mysql:host=".$this->server.";dbname=". $this->db.";charset=".$this->charset;
      $pdo = new PDO($dsn, $this->username, $this->pass);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    } catch (PDOException $e) {
      echo "Connection Failed: ". $e->getMessage();
    }
  }

}

?>
