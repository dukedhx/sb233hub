<?php 

require_once ('rst.php');

class writer{
private $filename, $size,$handle;
	public function __construct($fn){
$this->filename=$fn;
	}
  
	public function del()
	{
return delfile($this->filename);
	}

public function getsize(){
$this->size=filesize($this->filename);
	return $this->size;
}
private function close($h)
{
if($h)fclose($h);	
}
private function getfh($fn,$w=false)
{
return	fopen($fn, $w?'w':'r');
}
public function readall()
{
	return file_get_contents($this->filename);
}
public function writefile(){
global $buffer,$failure,$success;
try{
$this->handle = $this->getfh($this->filename);

$out=fopen('php://output', 'w');
$written=0;
do{
$contents = fread($this->handle, $buffer);
$written=fwrite($out, $contents);
}while(($this->size=$this->size-$written)>0);
$this->close($out);
return $success;
}catch(Exception $ex){return $failure;}
}

public function peek($peek)
{
	
$this->handle = $this->getfh($this->filename);
return fread($this->handle, $peek);
}

public function writecontent(&$contents){
	global $failure;
	try{
	$this->handle = $this->getfh($this->filename, true);
	return fwrite($this->handle, $contents);
}catch(Exception $ex){return $failure;}

}
function __destruct() {
	$this->close($this->handle);
}
}

class flremover extends bprocrst{
	private $path;
	public function __construct( $arrstr,$path,$updiv=null){
parent::__construct($arrstr,$updiv);
$this->path=$path;
	}
  protected function process($item)
  {    
        return getrst(delfile($this->path.$item),'','failed','does not exist');         
  }
}

function delfile($filename)
{
global $failure,$nonexist,$success;
	$answer=$success;
	try{
		if(file_exists($filename)){if(!unlink($filename))$answer=$failure;}else $answer=$nonexist;
		return $answer;}catch(Exception $ex){return $failure;}
	}

 function overwrite($patha,$pathb){
global $failure,$nonexist,$success;
	
	try{
return delfile($pathb)==$success?rename($patha, $pathb):$failure;
}catch(Exception $ex){return $failure;}}

?>