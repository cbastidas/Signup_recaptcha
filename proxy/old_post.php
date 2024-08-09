<?php
if( isset($_POST['RegisteredForTax']) ){
 $_POST['RegisteredForTax']=filter_var($_POST['RegisteredForTax'], FILTER_VALIDATE_BOOLEAN); 
}
if( isset($_POST['ReceivePromotions']) ){
 $_POST['ReceivePromotions']=filter_var($_POST['ReceivePromotions'], FILTER_VALIDATE_BOOLEAN); 
}
$postData = $_POST;
//print_r(json_encode($postData,true));

$postData=json_encode($postData);


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api-gate-shared01.netrefer.com/v3/org/6BB63825-D7D7-4580-8E67-43CACBC89C55/signup/newAffiliate",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>$postData,
  CURLOPT_HTTPHEADER => array(
    "APIKey: iK0aMMWObOPVSAvW1k56nxqrwVgwPGC4O5298UtKPycRq5nZxeIsu2zzWzLXTaF3Y74Io1gZudJeXJgSmmO7ow==",
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);
$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

$data=json_decode($response, true);
if(sizeof($data)==0){
    $data["Message"]=$response;
}
$data["status"]=$http_code;
$json = json_encode( $data );
print $json;
?>