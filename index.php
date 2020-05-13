<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>  
</head>
<body>

<div id = "carier-div">

  <form name ="carier">
  <lable>Get films on "кассета": </lable>
  <input type="button" onclick = "getcarier()" value="ОК">
  </form> 
  <table style="border: 1px solid"><tr><th> Film </th></tr>
  <tbody id = "carier-table"></tbody>
  </table>
  <table style="border: 1px solid"><tr><th> Last request </th></tr>
  <tbody id = "carierRecent-table"></tbody>
  </table>
</div>


<div id ="actor-div">

  <form name ="actor">
    <lable>Get films by actor: </lable>
  <?php 
  echo "<select id= 'actor'><option> Актер </option>";
  require_once __DIR__ . "/vendor/autoload.php";

  $actorFilms = (new MongoDB\Client) -> dbforlab -> actorFilm;
  
  $list = $actorFilms->find();

  foreach ($list as $actor) {
    
    echo '<option value="'.$actor["name"].'">'.$actor["name"].'</option>';
  }
  echo "</select>";
  ?>
    <input type="button" onclick = "getItemsByactor()" value="ОК">
</form> 


<table style="border: 1px solid"><tr><th> Films </th></tr>
  <tbody id = "actor-table"></tbody>
  </table>
  <table style="border: 1px solid"><tr><th> Last request </th></tr>
  <tbody id = "actorRecent-table"></tbody>
  </table>

</div>

<div id = "new-films-div">

<form name ="new">
    <lable>Get new films: </lable>
    <input type="button" onclick = "getnew()" value="ОК">
</form> 

<table style="border: 1px solid"><tr><th> Films </th></tr>
<tbody id = "new-table"></tbody>
</table>

<table style="border: 1px solid"><tr><th> Last request </th></tr>
<tbody id = "newResent-table"></tbody>
</table>

</div>


<script>
const ajax = new XMLHttpRequest();

function getcarier(){

    ajax.onreadystatechange = updatecarier;
    ajax.open("GET", "getFilmsByCarier.php");
    ajax.send(null);
}

  function updatecarier(){
    if(ajax.readyState === 4){
      if(ajax.status === 200){
        let text = document.getElementById('carier-table');
        let res = ajax.responseText;
        let resHtml ="";
        let newReq = [];
    
        let lastReqHtml ="";
        let lastReq = JSON.parse(localStorage.getItem("carier"));

        res = JSON.parse(res);
        res.forEach(vendor =>{
         resHtml += "<tr><td style = 'border: 1px solid'>" + vendor +"</td></tr>";
         newReq.push(vendor);
        });

      if(lastReq == null){
        lastReqHtml +="<tr><td style = 'border: 1px solid'> there are no recent reqs </td></tr>";
        document.getElementById("carierRecent-table").innerHTML = lastReqHtml;
      }else{
        lastReq.forEach(vendor =>{
        lastReqHtml +="<tr><td style = 'border: 1px solid'>" + vendor +"</td></tr>";
      });
        document.getElementById("carierRecent-table").innerHTML = lastReqHtml;
    }   
      localStorage.setItem("carier", JSON.stringify(newReq)); 
      text.innerHTML = resHtml;
      }
    }
  }

function getItemsByactor(){
let actor = document.getElementById("actor").value;
ajax.onreadystatechange = updateItems;
ajax.open("GET", "getFilmsByActor.php?actor="+ actor);
ajax.send(null);
}

function updateItems(){
if(ajax.readyState === 4){
  if(ajax.status === 200){
    let text = document.getElementById('actor-table');
    let res = ajax.responseText;
    let resHtml ="";
    let newReq = [];
    
    let lastReqHtml ="";
    let lastReq = JSON.parse(localStorage.getItem("actorItems"));

    res = JSON.parse(res);
    res.forEach(item =>{
    resHtml += "<tr><td style = 'border: 1px solid'>" + item +"</td></tr>";
    newReq.push(item);
    });
    
    if(lastReq == null){
        lastReqHtml +="<tr><td style = 'border: 1px solid'> there are no recent reqs </td></tr>";
        document.getElementById("actorRecent-table").innerHTML = lastReqHtml;
    }else{
        lastReq.forEach(item =>{
        lastReqHtml +="<tr><td style = 'border: 1px solid'>" + item +"</td></tr>";
     });
        document.getElementById("actorRecent-table").innerHTML = lastReqHtml;
    }    
    localStorage.setItem("actorItems", JSON.stringify(newReq)); 
    text.innerHTML = resHtml;
  }
}
}

function getnew(){

ajax.onreadystatechange = updateUnexisted;
ajax.open("GET", "getNewFilms.php");
ajax.send(null);
}

function updateUnexisted(){
if(ajax.readyState === 4){
  if(ajax.status === 200){
    let text = document.getElementById('new-table');
    let res = ajax.responseText;
    let newReq = [];
    let lastReqHtml ="";
    let lastReq = JSON.parse(localStorage.getItem("new"));
    let resHtml ="";

    res = JSON.parse(res);
    
    res.forEach(film =>{
     resHtml += "<tr><td style = 'border: 1px solid'>" + film +"</td></tr>";
     newReq.push(film);
    });

    if(lastReq == null){
        lastReqHtml +="<tr><td style = 'border: 1px solid'> there are no recent reqs </td></tr>";
        document.getElementById("newResent-table").innerHTML = lastReqHtml;
    }else{
        lastReq.forEach(film =>{
        lastReqHtml +="<tr><td style = 'border: 1px solid'>" + film +"</td></tr>";
     });
        document.getElementById("newResent-table").innerHTML = lastReqHtml;
    }    

  localStorage.setItem("new", JSON.stringify(newReq));
  text.innerHTML = resHtml;
  }
}
}
</script>
</body>
</html>
