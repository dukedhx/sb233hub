<?php
require_once ('constants.php');
require_once ('io.php');
$trycount=10;
function counttry(&$tries){
usleep(500);
return $tries--;
}
function handleErr($ex)
{
  header('HTTP/1.0 500 Internal Server Error');
    echo  $ex;
    exit;
}
function handleUava()
{
  header('HTTP/1.0 503 Service Unavailable');
    echo 'Service Unavailable';
    exit; 
}
function validateUser($username,$pin)
{
    $filename=getUserFilename($username);
   if(empty($filename))
    return false;
$origin;
try{
$origin=file_get_contents($filename);
return matchString($pin,$origin);
}catch(Exception $ex)
{
    handleErr( $ex);
}    
}
function decodeUser($encoded,$nos){
  $arr=array();
  $po=0;
foreach(str_split($nos) as $no){
  $c=(int)(base64_decode(substr($encoded,$po,$no)));
 
array_push($arr,$c);
$po+=(int)$no;
}
return implode(array_map("chr", $arr));
}
function encodeUser($username){
 $arr= unpack('C*',$username);
 $encoded='';
 $nos='';
 foreach($arr as $c){
 $str=base64_encode(strval($c));
$encoded=$encoded.$str;
$nos=$nos.(strlen($str));
}
return array('encoded'=> $encoded,'nos'=>$nos);
}
function getUserString($filename,$encoded,$nos)
{
return  $filename.','.$encoded.','.$nos;
}
function getUsers()
{
  global $userpath,$sbrole,$adminrole;
  try{
  $userfile=fopen($userpath.'users','r');
  
 $userfiletmp;
 
  if(!$userfile||!($userfiletmp=fopen($userpath.'users.tmp','w')))
  

       handleUava();
     

$line;
$users=array();
 while (($line = fgets($userfile)) !== false&&!(empty($line))) {
$parts=explode(',', $line);
if(count($parts)>2){

  $username=str_replace("\0", "", decodeUser($parts[1],$parts[2]));
  if(!isset($users[$username]))
  {
  $role=getRole($parts[0]);
  $filename=$parts[0];
  if(!file_exists($userpath.$filename))
  {
if(!file_exists($userpath.($filename=createUserFilename($username,($role=$role==$sbrole?$adminrole:$sbrole)))))
    $filename='';
    $overwrite=true;
  
  }
  if(!empty($filename)){
fputs($userfiletmp,getUserString($filename,$parts[1],$parts[2])."\r\n");
$users[$username]=$role;
}
} else $overwrite=true;
} else $overwrite=true;
}
 fclose($userfile);
 fclose($userfiletmp);
$tries=$trycount;
  while($overwrite)  
  $overwrite=!overwrite($userpath.'users.tmp',$userpath.'users')||counttry($tries);
delfile($userpath.'users.tmp');

return $users;
}
catch(Exception $ex){handleErr( $ex);}

}
function updateRole($username,$role)
{
  global $failure,$userpath;
  $filename= getUserFilename($username);
 
  return empty($filename)?$failure: rename( $filename, $userpath.md5($username).'.'.md5($role));

}
function getUserFilename($username)
{
  global $userpath;
    $username=md5($username);
foreach(glob($userpath.'*') as $item){

    
        $parts=explode('/',$item);
if(strpos($parts[sizeof($parts)-1], $username)===0)

    return $item;

    
}
}
function createUserFilename($username,$role)
{

  return empty($username)?'':(md5($username).'.'.md5(empty($role)?$sbrole:$role));
}
function addUser($username,$pin,$role=0,$writeuser=true)
{
  global $sbrole,$userpath;

$pin=md5($pin);
$filename=createUserFilename($username,$role);
$filepath=$userpath.$filename;
$writer=new writer($filepath);
$rst= $writer->writecontent($pin);
unset($writer);
$userobj=encodeUser($username);
if($writeuser)
if(!($rst= file_put_contents($userpath.'users', getUserString($filename,$userobj['encoded'],$userobj['nos'])."\r\n", FILE_APPEND)))
 delfile($filepath);
return $rst;
}
function delUser($username)
{
return delfile(getUserFilename($username));
}
function getRole($filename)
{
  global $adminrole,$sbrole;
   $parts=explode('.', $filename);

   if(sizeof($parts)<2)return $sbrole;

    return matchString($adminrole,$parts[sizeof($parts)-1])?$adminrole:$sbrole;
}

function matchString($input,$origin)
{
    return md5($input)==$origin;
}
function challenge(){
   
 header('WWW-Authenticate: Basic realm="Are you a sb?"');
    header('HTTP/1.0 401 Unauthorized');
  $authrst=$authcancel;
 exit;

}






if (empty($_SERVER['PHP_AUTH_USER'])) 
    challenge();
else
$authrst=validateUser($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW'])?$_SERVER['PHP_AUTH_USER']:$authfail;


if($authrst<0)
{
    challenge();
    exit;
}

?>