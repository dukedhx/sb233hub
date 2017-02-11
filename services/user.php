<?php
error_reporting(E_ERROR);

require_once ('../includes/user.php');
if(getRole(getUserFilename($_SERVER['PHP_AUTH_USER']))!=$adminrole)
{
	header('HTTP/1.0 403 Forbidden');
	exit;
}

if(empty($_POST[$usrparam])&&empty($_POST[$updel]))

echo json_encode(getUsers());

else
{
	$rstobj=fail('Not all required params set!');
	
		if(!empty($_POST[$updel]))
		{
			$rsts=array();
			foreach(explode(',', $_POST[$updel]) as $username)
			 {
			  $rst=	delUser($username);
array_push($rsts, $rst);
			 }
	$rstobj=success(implode(',',$rsts));

		}


	if(!empty($_POST[$pwparam])){
		$username;
if(!empty($_POST[$usrparam])){
	if(getUserFilename( $_POST[$usrparam]))

	
	$rstobj=fail('Username already exists: '+$_POST[$usrparam]);
	else $username=$_POST[$usrparam];
	}

if(!empty($_POST[$updel]))

	$username=$_POST[$updel];

if(!empty($username) ){
$rst=addUser($username,$_POST[$pwparam],$_POST[$roleparam],empty($_POST[$updel]));
$rstobj=$rst?success($rst):fail($rst);
}
}else if(!empty($_POST[$roleparam])&&!empty($_POST[$usrparam]))
		{

			$rst=updateRole($_POST[$usrparam],$_POST[$roleparam]);
	$rstobj=$rst?success($rst):fail($rst);

		}


	
	echoresult($rstobj);
	
}
?>