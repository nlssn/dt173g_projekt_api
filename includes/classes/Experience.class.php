<?php
/* includes/classes/Experience.class.php
 * Johannes Nilsson (joni1307@student.miun.se) 
 * DT173G - Projekt, HT21
 */

class Experience {
   // Connection
   private $conn;

   // DB table
   private $db_table = 'experience';

   // DB Columns
   public $id;
   public $title;
   public $type;
   public $location;
   public $description;
   public $date_start;
   public $date_end;
   public $created;

   public function __construct($db) {
      $this->conn = $db;
   }

   public function create() {
      // Set up the query
      $query = 'INSERT INTO
                  ' . $this->db_table . '
               SET
                  title = :title,
                  type = :type,
                  location = :location,
                  description = :description
                  date_start = :date_start,
                  date_end = :date_end';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Sanitize input
      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->type = htmlspecialchars(strip_tags($this->type));
      $this->location = htmlspecialchars(strip_tags($this->location));
      $this->description = htmlspecialchars(strip_tags($this->description));

      // Bind input data to params
      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':type', $this->type);
      $stmt->bindParam(':location', $this->location);
      $stmt->bindParam(':description', $this->description);
      $stmt->bindParam(':date_start', $this->date_start);
      $stmt->bindParam(':date_end', $this->date_end);

      // Execute statement
      if($stmt->execute()) {
         return true;
      }

      // If anything fails, return false
      return false;
   }
}