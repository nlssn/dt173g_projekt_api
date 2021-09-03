<?php
/* api/experience.php
 * Johannes Nilsson (joni1307@student.miun.se) 
 * DT173G - Projekt, HT21
 */

// Set headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT');

// Required files
require_once('../includes/classes/Database.class.php');
require_once('../includes/classes/Experience.class.php');

// Save the request method for later use
$method = $_SERVER['REQUEST_METHOD'];


// If a param of ID is set, save that too
if(isset($_GET['id'])) {
   $id = $_GET['id'] != '' ? $_GET['id'] : null;
}

// Database instance
$database = new Database();
$db = $database->connect();

// Instantiate a new experience object
$experience = new Experience($db);


// Depending on which request method is used,
// call the appropriate class method.
switch($method) {
   case 'GET':
      if(!isset($id)) {
         $data = $experience->getAll();
      } else {
         $data = $experience->getOne($id);
      }

      $count = sizeof($data);

      if($count > 0) {
         http_response_code(200); // OK
         $response = array(
            'type' => 'success',
            'message' => $count === 1 ? 'Found 1 result' : 'Found ' . $count . ' results',
            'itemCount' => $count,
            'items' => $data
         );
      } else {
         http_response_code(404); // Not found
         $response = array(
            'type' => 'error',
            'message' => isset($id) ? 'Found no item with id ' . $id  : 'No results found',
            'itemCount' => $count,
            'items' => $data
         );
      }
      
      break;
/*
   case "POST":
      $data = json_decode(file_get_contents("php://input"));

      $experience->title = $data->title;
      $experience->location = $data->location;
      $experience->description = $data->description;
      $experience->category = $data->category;
      $experience->date_start = $data->date_start;
      $experience->date_end = $data->date_end;

      if($experience->createExperience()) {
         http_response_code(201); // Created
         $result = array("message" => "Ny erfarenhet tillagd"); 
      } else {
         http_response_code(503); // Server error
         $result = array("message" => "Kunde inte lägga till erfarenhet");
      }

      break;
   case "PUT":
      if(!isset($id)) {
         http_response_code(510); // Not extended
         $result = array("message" => "Ett id krävs");
      } else{
         $data = json_decode(file_get_contents("php://input"));

         $experience->title = $data->title;
         $experience->location = $data->location;
         $experience->description = $data->description;
         $experience->category = $data->category;
         $experience->date_start = $data->date_start;
         $experience->date_end = $data->date_end;

         if(!$experience->updateExperience($id)) {
            http_response_code(503); // OK
            $result = array("message" => "Kunde inte uppdater erfarenhet");
         } else {
            http_response_code(200); // OK
            $result = array("message" => "Erfarenhet uppdaterad");
         }
      }
      
      break;
   case "DELETE":
      if(isset($id)) {
         if($experience->deleteExperience($id)) {
            http_response_code(200); // OK
            $result = array("message" => "Erfarenhet raderad");
         } else {
            http_response_code(503); // Server error
            $result = array("message" => "Kunde inte radera erfarenhet");
         }
      } else {
         http_response_code(510); // Not extended
         $result = array("message" => "Ett id krävs");
      }
      break;
*/
}

// Echo the result as JSON
echo json_encode($response);

// Close DB connection
$db = $database->close();