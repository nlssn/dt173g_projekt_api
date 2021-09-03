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