<?php
error_reporting(E_ERROR);
require_once ('../includes/constants.php');

if($doauth)
require_once ('../includes/user.php');

//require_once ('../includes/dbc.php');


require_once ('../includes/rst.php');
require_once ('../includes/io.php');


class txremover extends bprocrst{
	private $dbc;
	public function __construct( $arrstr,$dbc){

parent::__construct($arrstr);
$this->dbc=$dbc;
}
  protected function process($item)
  {    
    return getrst($this->dbc->del($item),'','failed','does not exist');    
  }
}

class txjsonifier extends jsonifier{
protected function iterate(&$array,$callp){
	if($callp)parent::iterate($array);else{
	$first=true;
while($item = mysql_fetch_assoc($array))
parent::process($item,$first);}
}
}



class fllijsonifier extends jsonifier{
protected function jsonify($item)
{global $upid,$jotime, $peek;
	$filename=basename($item);
	$time= date ("Y-m-d H:i:s", filemtime($item));
	
echo <<<EOT
{ "$upid": "$filename", "$jotime":"$time"}
EOT;
}
}

class textprv
{

	public $id,$text;
		public function __construct($id,$txt){
$this->id=$id;$this->text=$txt;
	}

}

if(empty($_POST[$uptext]))
{
	if(empty($_POST[$updparam]))
	{

	if(empty($_GET[$txsvfile])){
		$rst=new fllijsonifier;
	if(!empty($_POST[$updel]))
	{
$flrmer=new flremover($_POST[$updel],$textpath,',');
		$rst->outputJSON($flrmer->getrsts(),$joresentry,true);


}else
$rst->outputEntities(glob($textpath.'*'),$page=empty($_GET[$uppage])?0:(intval($_GET[$uppage])-1),empty($_GET[$uppp])?10:intval($_GET[$uppp]));

}
else
{
	//$rst=new txjsonifier;
//$dbc=new dbhelper;
//if(isset($_GET[$updel]))
//{
//$txrmer=new txremover($_GET[$updel],$dbc);
//$rst->outputJSON($txrmer->getrsts(),$joresentry,true);
//}
//$result=$dbc->getText($page,$pp);
//if($result)
//$rst->outputJSON($result);unset($rst);
//mysql_free_result($result);
//unset($dbc);
}
}

else{
	try{
		$writer=new writer($textpath.$_POST[$updparam]);
	echo $writer->readall();
	unset($writer);
}catch(exception $e){
	echoresult(fail($e));
}
}
}

else
{

if(empty($_POST[$txsvfile])&&!empty($_POST[$updparam])){
try{
$savtxtname=$textpath.($_POST[$updparam].substr(0,200)).' '.time();
if(!empty($_POST[$updel]))
{
delfile($textpath.$_POST[$updel]);
	}
$writer=new writer($savtxtname);
$writer->writecontent($_POST[$uptext]);
unset($writer);
}catch(exception $e){
	echoresult(fail($e));
}
}else{

	//$dbc=new dbhelper;
//$id=$dbc->insert($_POST[$uptext],empty($_POST[$upcond])?null:$_POST[$upcond]);
//unset($dbc);
}
echoresult(success());
}


?>