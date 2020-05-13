<?php 
  require_once __DIR__ . "/vendor/autoload.php";
  
  $collection = (new MongoDB\Client) -> dbforlab -> films;
  $res = [];
  $cond = array("year" => 2020 );
  $cursor = $collection -> find($cond);

  foreach($cursor as $document){
    array_push($res, $document["title"]);
    
    }
echo json_encode($res);
?>