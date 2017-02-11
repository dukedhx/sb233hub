<?php
error_reporting(E_ERROR);
require_once ('../includes/constants.php');

if($doauth)
require_once ('../includes/user.php');
require_once ('../includes/rst.php');
require_once ('../includes/io.php');



class fljsonifier extends jsonifier{
protected function jsonify($item)
{
global $jofn,$josize,$jotime;
$size=filesize($item);
$parts=explode('/',$item);
$filename=$parts[sizeof($parts)-1];
$time= date ("Y-m-d H:i:s", filemtime($item));
echo <<<EOT
{ "$jofn": "$filename", "$josize":"$size","$jotime":"$time"}
EOT;
}
}

if(!empty($_POST[$uphasfile]))
{

  set_time_limit(0);
$results= new resultset;

foreach ($_FILES[$upfile]["error"] as $key => $error) 
    if ($error == UPLOAD_ERR_OK) 
    {

    $filename=$oldname=$filepath.$_FILES[$upfile]["name"][$key];$rid=0;
    while(file_exists($filename)){$parts=explode('.',$oldname);$lpid=sizeof($parts)-2;$lpid=$lpid<0?0:$lpid;$parts[$lpid]=$parts[$lpid].'['.$rid++.']';$filename=implode('.',$parts);}
    
     if(   move_uploaded_file($_FILES[$upfile]["tmp_name"][$key], $filename))
        $results->add(success());
    else                     
    $results->add(fail($error,false));    
    }
       else
    $results->add(fail($error,false));
    $jsoner=new jsonifier;
$jsoner->outputJSON($results->array);
}
else{
  if(empty($_GET[$uphasfile]))
  {
if(empty($_GET[$getfile]))
{
  $rst=new fljsonifier;
  if(isset($_POST[$updel]))
  {
  $flrmer=new flremover($_POST[$updel],$filepath);
  $rst->outputJSON($flrmer->getrsts(),$joresentry,true);    
  }
  else

 $rst->outputEntities(glob($filepath.'*'),empty($_GET[$uppage])?0:(intval($_GET[$uppage])-1),empty($_GET[$uppp])?20:intval($_GET[$uppp]));

}
else
{
$sfn=$_GET[$getfile];
$filename = $filepath.$sfn;
if(file_exists($filename)){
  $writer=new writer($filename);
$size=$writer->getsize();

if(!isset($_GET[$fmode])||$_GET[$fmode]!=$fmraw){
  header('Content-type: application/force-download');
header("Content-Disposition: attachment; filename=\"$sfn\"");
}
else header('Content-type: '.mime_content_type($sfn));
header('Content-Transfer-Encoding: binary');
  header("Content-Length: $size");
$writer->writefile();
unset($writer);
}
else notfound(); 
}


}
else
{
   session_start();
var_dump($_SESSION[ini_get("session.upload_progress.prefix") .$_GET[$uphasfile]]);
}
}
?>