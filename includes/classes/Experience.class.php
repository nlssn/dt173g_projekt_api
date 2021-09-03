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

         // TODO: Here I should return the data of the created item.
      }

      // If anything fails, return false
      return false;
   }

   public function getAll() {
      // Set up the query
      $query = 'SELECT * FROM' . $this->db_table;
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Create array that can be sent as response
      $response = array();

      // Execute statement
      if($stmt->execute()) {
         // Count the results
         $count = $stmt->rowCount();

         // Nested array that will hold the actual data
         $response['data'] = array();

         // Save the amount of results
         $data['itemCount'] = $count;

         // If there are results, store them in $response['data']
         if($count > 0) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               extract($row);

               $item = array(
                  'id' => $id,
                  'title' => $title,
                  'type' => $type,
                  'location' => $location,
                  'description' => $description,
                  'date_start' => $date_start,
                  'date_end' => $date_end,
                  'created' => $created,
               );

               array_push($response['data'], $item);
            }
         }
      }

      // Return response
      /* TODO: This should be written
       * in a way so that the user can get both
       * a success response or a failed one..
       */
      return $response;
   }

   public function getOne($id) {
      // Set up the query
      $query = 'SELECT * FROM
                  ' . $this->db_table . '
               WHERE
                  id = :id
               LIMIT 1';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind input data to param
      $stmt->bindParam(':id', $id);

      // Create array that can be sent as response
      $response = array();

      // Execute statement
      if($stmt->execute()) {
         // Count the results
         $count = $stmt->rowCount();

         // If there are results, store them in $response['data']
         if($count > 0) {
            $response['data'] = $stmt->fetch(PDO::FETCH_ASSOC);
         } else {
            $response['data'] = array();
         }
      }
      
      // Return response
      /* TODO: This should be written
       * in a way so that the user can get both
       * a success response or a failed one..
       */
      return $response;
   }
}