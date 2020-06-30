<!DOCTYPE html>
<head>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Google Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">

<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
</head>

<body>
<h1>Test</h1>
<canvas id="lineChart"></canvas>


</body>



<?php

$humidArray = array();
$tempArray = array();
$moistureArray = array();

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://platform.antares.id:8443/~/antares-cse/antares-id/antaresChallenge/sensors?fu=1&ty=4",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "X-M2M-Origin: 017c7e810b75e05b:0932f32db0c81348",
    "Accept: application/json"
  ),
));

$responseId = curl_exec($curl);

curl_close($curl);


$response2Id = json_decode($responseId,true);
//print_r($response2);
$valueId = $response2Id["m2m:uril"];



foreach($valueId as $dataUrl){
$url = "https://platform.antares.id:8443/~".$dataUrl;

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "X-M2M-Origin: 017c7e810b75e05b:0932f32db0c81348",
    "Content-Type: application/json;ty=4",
    "Accept: application/json"
  ),
));


$response = curl_exec($curl);
$response2 = json_decode($response,true);
//print_r($response2);
$newValue = $response2["m2m:cin"]["con"];
$sensorValue = json_decode($newValue, true);
if(isset($sensorValue["Humidity"])){

$humid =$sensorValue["Humidity"];
$temp =$sensorValue["Temperature"];
$mois = $sensorValue["Moisture"];
array_push($humidArray, $humid);
array_push($tempArray, $temp);
array_push($moistureArray, $mois);

}
else {

}
curl_close($curl);











}


















//Getting Value Data
/*


$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://platform.antares.id:8443/~/antares-cse/antares-id/antaresChallenge/sensors/la",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "X-M2M-Origin: 017c7e810b75e05b:0932f32db0c81348",
    "Content-Type: application/json;ty=4",
    "Accept: application/json"
  ),
));


$response = curl_exec($curl);
$response2 = json_decode($response,true);
//print_r($response2);
$newValue = $response2["m2m:cin"]["con"];
$sensorValue = json_decode($newValue, true);
if(empty($sensorValue["Humidity"])){
echo $sensorValue["Humidity"];
echo $sensorValue["Temperature"];
echo $sensorValue["Moisture"];
}
else{
    echo "Salahhh broooo";
}

curl_close($curl);

*/
?>
<script>
//line
var ctxL = document.getElementById("lineChart").getContext('2d');
var myLineChart = new Chart(ctxL, {
type: 'line',
data: {
labels: [<?php foreach($humidArray as $key=>$value){
  echo $key;
  echo ",";
}?>],
datasets: [{
label: "My First dataset",
data: [
  <?php foreach($humidArray as $humid){
    echo $humid;
    echo ",";
  
  } ?>
],
backgroundColor: [
'rgba(105, 0, 132, .2)',
],
borderColor: [
'rgba(200, 99, 132, .7)',
],
borderWidth: 2
},
{
label: "My Second dataset",
data: [<?php foreach($tempArray as $temp)
{
  echo $temp;
  echo ",";

}?>],
backgroundColor: [
'rgba(0, 137, 132, .2)',
],
borderColor: [
'rgba(0, 10, 130, .7)',
],
borderWidth: 2
},
{
label: "My Second dataset",
data: [<?php foreach($moistureArray as $mois)
{
  echo $mois;
  echo ",";

}?>],
backgroundColor: [
'rgba(0, 137, 132, .2)',
],
borderColor: [
'rgba(0, 10, 130, .7)',
],
borderWidth: 2
}
]
},
options: {
responsive: true
}
});
</script>
</html>
