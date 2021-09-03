<?php
/* includes/classes/Database.class.php
 * Johannes Nilsson (joni1307@student.miun.se) 
 * DT173G - Projekt, HT21
 */

require('../config.php');

class Database {
   // DB credentials
   private $db_host = DBHOST;
   private $db_user = DBUSER;
   private $db_pass = DBPASS;
   private $db_name = DBNAME;

   // Connection
   public $conn;

   public function connect() {
      // Close any previous connections
      $this->conn = null;

      // Try to connect using PDO
      try {
         $this->conn = new PDO('mysql:host' . $this->db_host . ';dbname=' . $this->db_name, $this->db_user, $this->db_pass);
         $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $this->conn->exec('set names utf8');
      } catch (PDOException $err) {
         echo json_encode(
            array(
            'message' => 'Kunde inte ansluta till databasen',
            'error' => $err->getMessage()
            )
         );

         return $this->conn;
      }
   }

   public function close() {
      $this->conn = null;
   }
}