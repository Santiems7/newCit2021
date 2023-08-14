<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of config
 *
 * @author Santiems
 */
class Classconfig {
   Private $serverName = 'localhost';
   Private $userName = 'root';
   Private $password = '12011993';
   Private $dbName = 'cit2021';
   public $conn;
   
   // Función que abre la Classconfig con el servidor 
   public function openServer() {
      $this->conn = null;
      try {
          $this->conn = new mysqli($this->serverName, $this->userName, $this->password, $this->dbName);
          if ($this->conn->connect_error) {
              throw new Exception("Error al conectar con la base de datos: " . $this->conn->connect_error);
          }
      } catch (Exception $e) {
          echo $e->getMessage();
      }
      return $this->conn;
   }
  
   // Función que cierra la Classconfig con el servidor 
   public function closeServer() {
      mysqli_close($this->conn); // Cierra la conexión 
   }
}
