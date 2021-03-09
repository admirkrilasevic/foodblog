<?php

require_once dirname(__FILE__)."/../config.php";
class BaseDao
{
  private $connection;

  function __construct(){


    try {
      $this->connection = new PDO("mysql:host=".Config::DB_HOST.";dbname=".Config::DB_SCHEME, Config::DB_USERNAME, Config::DB_PASSWORD);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }

  }

  function insert(){

  }

  function update(){

  }

  function query(){

  }

  function query_unique(){

  }

}


 ?>
