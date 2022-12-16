<?php
class Database
{
  // DB Params
  private $user = 'library';
  private $password = '0E5k4N5m';
  private $database = 'library';
  private $host = 'localhost';
  private $port = 8889;
  private $conn;

  // DB Connect
  public function connect()
  {
    $this->conn = null;
    $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);

    return $this->conn;
  }
}
