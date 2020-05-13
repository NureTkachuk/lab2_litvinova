<?php 
  require_once __DIR__ . "/vendor/autoload.php";
  $name = $_GET["actor"];
  $actorFilms = (new MongoDB\Client) -> dbforlab -> actorFilm;
  $res = [];
  $cond = array("name" => $name);

  $cursor = $actorFilms -> find($cond);

  foreach($cursor as $document){
    array_push($res, $document["film"]);
    
    }
echo json_encode($res);
?>