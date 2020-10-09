<?php
	header("Content-Type: text/html;charset=utf-8");
	if(isset($_COOKIE["count"]))
	{
	$_COOKIE["count"]++;
	setcookie("count", $_COOKIE["count"], time()+600)
	;}
	else
	{
	setcookie("count", "1", time()+600)
	;}
	$tripNames=array(
		0 => "Moscow",
		1 => "Zelenogradsk",
		2 => "Los-Angeles",
		3 => "St. Petersburg",
		4 => "Krasnoyarsk",
		5 => "New York",
		6 => "Chicago",
	);
	$tripNames2=array(
		0 => "Kiev",
		1 => "Minsk",
		2 => "Warsaw",
		3 => "Vladivostok",
		4 => "Paris",
		5 => "London",
		6 => "Yorkshire",
	);
	$seatNames=array(
		0 => 10,
		1=> 20,
		2 => 15,
		3 => 14,
		4 => 12,
		5 => 16,
		6 => 17,
	);
	$tripIDs=array(
		0 => 40,
		1=> 20,
		2 => 30,
		3 => 31,
		4 => 45,
		5 => 56,
		6 => 22,
	);
	$datetimes=array(
		0 => 1551507025,
		1 => 1575939710,
		2 => 1570670410,
		3 => 1549794050,
		4 => 1571914240,
		5 => 1559212850,
		6 => 1557864050,
	);
	$tripTimes=array(
		0 => 30,
		1=> 40,
		2 => 25,
		3 => 31,
		4 => 18,
		5 => 26,
		6 => 26,
	);
	$routeIDs=array(
		0 => 15,
		1=> 14,
		2 => 13,
		3 => 16,
		4 => 19,
		5 => 20,
		6 => 21,
	);
	$name="";
	$name2="";
	$seat=0;
	$trip=0;
	$datetime="";
	$date="";
	$tripTime=0;
	$route=0;
	
	$n=7;
	
	$rowNum=0;
	$rows;
	$ticketPrice=0;
?>
<html>
	<head>
		
	</head>
	<body>
		<style>
			.order{
			border: 4px solid black;
			width: 768px;
			height: 810px;
			position: fixed;
			left: 50.88px;
			top: 104.004px;
			overflow: auto;
			}
			.sell{
			width: 400px;
			height: 810px;
			position: fixed;
			left: 850px;
			top: 104.004px;
			}
			.tickets{
			border: 4px solid black;
			width: 576px;
			height: 760px;
			position: fixed;
			left: 1293.12px;
			top: 104.004px;
			overflow: auto;
			}

		</style>
		<form action="cashier.php" method=post>
			<?php 
				 
				if(!$link = mysqli_connect("127.0.0.1", "root", "1234", 'mydb',3306))
				{
				echo "Все пропало!<br>";
				echo mysqli_connect_error(); die();
				;}


			?>
			<div class=order>
				<div><big>№	| Пункт назначения | Пункт отправления | Место | Номер рейса | Дата отправления |</big></div><br>
				<?php
					$ticketPrice=$_POST['prices'];
					for($i=0;$i<$n;$i++)
					{
						$name=$tripNames[$i];
						$name2=$tripNames2[$i];
						$seat=$seatNames[$i];
						$trip=$tripIDs[$i];
						$datetime=date("Y-m-d H:i:s",$datetimes[$i]);
						$date=date("Y-m-d",$datetimes[$i]);
						$tripTime=$tripTimes[$i];
						$route=$routeIDs[$i];
						
						echo ("<div><big>
						<input type=checkbox name=entries[] value={$i}>&nbsp;&nbsp;&nbsp;&nbsp;
						{$name}&nbsp;&nbsp;&nbsp;&nbsp;
						{$name2}&nbsp;&nbsp;&nbsp;&nbsp;
						{$seat}&nbsp;&nbsp;&nbsp;&nbsp;
						{$trip}&nbsp;&nbsp;&nbsp;&nbsp;
						{$date}&nbsp;&nbsp;&nbsp;&nbsp;
						</big></div><br><br>");
						
						
						if(isset($_POST['entries'][$i]))
						{
								mysqli_query($link, "START TRANSACTION");
								if(!$res = mysqli_query($link, "INSERT IGNORE INTO route SET route_id=".addslashes($route).", `departure place`='".addslashes($name)."',`destination place`='".addslashes($name2)."', `departure date`='".addslashes($date)."';"))
								{
									echo "Все пропало! route<br>";
									echo mysqli_error($link); die();
								;}
								if(!$res = mysqli_query($link, "INSERT IGNORE INTO trip SET `departure time/date`='".addslashes($datetime)."', `trip time`=".addslashes($tripTime).", `trip id`=".addslashes($trip).", route_route_id=".addslashes($route).";"))
								{
									echo "Все пропало! trip<br>";
									echo mysqli_error($link); die();
								;}
								if(!$res = mysqli_query($link, "INSERT IGNORE INTO ticket SET ticket_price=".addslashes($ticketPrice).", `trip_trip id`=".addslashes($trip).";"))
								{
									echo "Все пропало! ticket<br>";
									echo mysqli_error($link); die();
								;}
								if(!$res = mysqli_query($link, "INSERT IGNORE INTO bus SET bus_type='type 1', `places_number`=".addslashes($seat).", `trip_trip id`=".addslashes($trip).";"))
								{
									echo "Все пропало! bus<br>";
									echo mysqli_error($link); die();
								;}
								mysqli_query($link, "COMMIT;");

						}
					}
					
				?>
			</div>
			<div class=sell>
				<div style="width: 10%;height:3%;position: absolute;left: 40%;top: 25%;"><big>ЦЕНЫ:</big></div>
				<select style="width: 30%;height:3%;position: absolute;left: 35%;top: 30%;" name=prices>
					<option value=4000>4000 руб.</option>
					<option value=2500>2500 руб.</option>
					<option value=5000>5000 руб.</option>
					<option value=1000>1000 руб.</option>
					<option value=6000>6000 руб.</option>
				</select> <br>
				<input style="width: 26%;height:3%;position: absolute;left: 36%;top: 34%;" type=submit value="продать билет">
			</div>
			<form action="cashier.php" method=post>
			<div class=tickets>
				<div><big>№ билета | Цена | Номер рейса |</big></div><br>
				<?php
					if(!$res = mysqli_query($link, "SELECT * FROM ticket;"))
					{
						echo "Все пропало!<br>";
						echo mysqli_error(); die();
					;}
					else
					{
						$rows=mysqli_fetch_all($res);
						$rowNum=mysqli_num_rows($res);
						for($i=0;$i<$rowNum;$i++)
						{
							echo ("<div><big>");
							echo ("<input type=checkbox name=tickets[] value={$i}>");
							for($j=0;$j<3;$j++)
							{
								echo ("{$rows[$i][$j]}&nbsp;&nbsp;&nbsp;&nbsp;");
							}
							echo ("</div></big><br>");
							
							if(isset($_POST['tickets'][$i]))
							{
								if(!$res = mysqli_query($link, "DELETE FROM ticket WHERE ticket_id=".$rows[$i][0].";"))
								{
									echo "Все пропало!<br>";
									echo mysqli_error($link); die();
								;}
							}
						}
					}

				?>
			</div>
			<input style="position:fixed; left: 1300px; bottom: 50px;" type=submit name=deleteTicket value="Вернуть билеты из системы">
		</form>
		</form>
		
		
		
	</body>
</html>