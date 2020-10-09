<?php 
	header("Content-Type: text/html;charset=utf-8");
	
	$pass=$_POST['password'];
	$login=$_POST['login'];
	if($login =='admin' && $pass == 'admin')
	{
		$newURL="http://test1.ru/admin.php";
		header('Location: '.$newURL);
	}
	elseif($login =='cashier' && $pass == 'cashier')
	{
		$newURL="http://test1.ru/cashier.php";
		header('Location: '.$newURL);
	}
	else
	{
		echo("Неправильное имя пользователя или пароль");
	}
		
?>