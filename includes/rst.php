<?php 
require_once ('constants.php');

 header("Access-Control-Allow-Origin: *");

 class jsonifier{
protected $ename,$first=true;
public function __construct( $en=null){
global $joentry;
$this->ename=is_null($en)?$joentry:$en;
echo '{';
}

protected function iterate(&$array,$callp=false)
{
	$first=true;
foreach ($array as $item) 
$this->process($item,$first,$callp);
}

protected function process($item,&$first,$callp=false)
{
if(!$first)echo ',';
if($callp)$this->echojson($item);else $this->jsonify($item);
$first=false;
}

protected function jsonify($item)
{
$this->echojson($item);
}

private function echojson($item)
{
	echo json_encode($item);
}
public function outputEntities(&$farr,$page=0,$pp=10)
{
global $authrst,$doauth;
$length=sizeof($farr);
$start=$pp*$page;
if($start>=$length||$start<0){$start=0;$page=0;}
if(is_string($authrst))$this->outputUSER($authrst);
$this->outputPAGE($page+1,$length);

$this->outputJSON(array_slice($farr,$start,$pp));
}
private function echoJSONDelimits()
{
	if(!$this->first)echo ',';
	$this->first=false;
}
public function outputPAGE($cpage,$ctotal)
{
global $uppage,$uppp;
$this->echoJSONDelimits();
	echo "\"$uppage\":\"$cpage\",\"$uppp\":\"$ctotal\"";
}
public function outputUSER($user){
$this->echoJSONDelimits();
	
echo "\"user\":\"$user\"";
	
}
public function outputJSON(&$array,$name=null,$callp=false){
	if(is_null($name))$name=$this->ename;
$this->echoJSONDelimits();
	
echo " \"$name\":[";
$this->iterate($array,$callp);
echo ']';
}

function __destruct() {
echo '}';
	}
}


class result {

public $status,$msg;
public function __construct( $st,$mg=null ){
$this->status=$st; $this->msg=$mg;
}
}

class resultSet{
	public $array= array();

public function add($item){
	 array_push($this->array,$item);
}
}

abstract class bprocrst{
private $parts;
public function __construct( $arrstr,$adivstr=null){
	global $updiv;
$this->parts=explode(empty($adivstr)?$updiv:$adivstr,$arrstr);
}

abstract protected function process($item);

public function getrsts()
{
$rst=new resultSet;
foreach($this->parts as $item)
$rst->add($this->process($item));
return $rst->array;
}


}



function getrst($rst,$msgs=null,$msgf=null,$msgm=null)
{
	global $nonexist,$failure,$success;
	return $rst==$success?success($msgs):fail($rst==$failure?$msgf:$msgm);
}

function notfound(){
header('HTTP/1.1 404 Not Found'); 
exit;
}

function fail($msg=null,$exit=true){
global $jofail;
return new result($jofail,$msg);
}

function success($msg=null){
global $jook;
return new result($jook,$msg);
}

function echoresult($item)
{
global $joresponse,$jomessage;
echo <<<EOT
{ "$joresponse":"{$item->status}","$jomessage":"{$item->msg}"}
EOT;
}


?>