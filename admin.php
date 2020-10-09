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
	if(!$link = mysqli_connect("127.0.0.1", "root", "1234", 'mydb',3306))
		{
			echo "Все пропало!<br>";
			echo mysqli_connect_error(); die();
		;}
?>
<html>
	<head>
		
	</head>
	<body>
		<style>
			.DB_trip{
			width: 480px;
			height: 966px;
			position: fixed;
			left: 0px;
			top: 0px;
			}
			.DB_bus{
			width: 480px;
			height: 966px;
			position: fixed;
			left: 1440px;
			top: 0px;
			}
			.DB_route{
			width: 480px;
			height: 966px;
			position: fixed;
			left: 480px;
			top: 0px;
			}
			.DB_driver{
			width: 480px;
			height: 966px;
			position: fixed;
			left: 960px;
			top: 0px;
			}
			.DB_Delete{
			border: 4px solid black;
			width: 80%;
			height: 50%;
			position: relative;
			left: 7%;
			top: 5%;
			}
			.DB_DeleteEntries{
			border: 4px solid black;
			width: 92%;
			height: 70%;
			position: relative;
			left: 3%;
			top: 5%;
			overflow: auto;
			}
			.DB_InsertAll{
			width: 1890px;
			height: 324px;
			position: fixed;
			left: 10px;
			top: 590px;
			}
			.DB_Insert{
			border: 4px solid black;
			width: 384px;
			height: 289.8px;
			position: relative;
			top:15px;
			margin-left: 2%;
			margin-right: 2%;
			display: inline-block;
			}

		</style>
		<div class=DB_trip>
			<form action="admin.php" method=post>
				<div class=DB_Delete>
					<div style="position:absolute;left:42%;top:1%">РЕЙСЫ</div>
					<div class=DB_DeleteEntries>
						<div>| Время отбытия | Номер рейса | Время в пути | Номер маршрута |</div><br>
						<?php
							if(!$res = mysqli_query($link, "SELECT * FROM trip;"))
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
									
									if(isset($_POST['entries'][$i]))
									{
										mysqli_query($link, "START TRANSACTION");
										if(!$res = mysqli_query($link, "DELETE FROM trip WHERE `trip id`=".$rows[$i][1].";"))
										{
											echo "Все пропало!trip<br>";
											echo mysqli_error($link); die();
										;}
										mysqli_query($link, "COMMIT;");
									}
									
									echo ("<div><big>");
									echo ("<input type=checkbox name=entries[] value={$i}>&nbsp;");
									for($j=0;$j<4;$j++)
									{
										echo ("{$rows[$i][$j]}&nbsp;&nbsp;&nbsp;&nbsp;");
									}
									echo ("</div></big><br>");
									
								}
							}
						?>
					</div>
					<input style="position:absolute;left:35%;top:90%" type=submit value="Удалить записи">
				</div>
			</form>
		</div>
		<div class=DB_route>
			<form action="admin.php" method=post>
				<div class=DB_Delete>
					<div style="position:absolute;left:38%;top:1%">МАРШРУТЫ</div>
					<div class=DB_DeleteEntries>
						<div>| Номер маршрута | Пункт отбытия | Пункт прибытия | Дата отбытия |</div><br>
						<?php
							if(!$res = mysqli_query($link, "SELECT * FROM route;"))
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
									
									if(isset($_POST['entries'][$i]))
									{
										mysqli_query($link, "START TRANSACTION");
										if(!$res = mysqli_query($link, "DELETE FROM route WHERE route_id=".$rows[$i][0].";"))
										{
											echo "Все пропало!<br>";
											echo mysqli_error($link); die();
										;}
										mysqli_query($link, "COMMIT;");
									}
									
									echo ("<div><big>");
									echo ("<input type=checkbox name=entries[] value={$i}>&nbsp;");
									for($j=0;$j<4;$j++)
									{
										echo ("{$rows[$i][$j]}&nbsp;&nbsp;&nbsp;&nbsp;");
									}
									echo ("</div></big><br>");
									
								}
							}
						?>
					</div>
					<input style="position:absolute;left:35%;top:90%" type=submit value="Удалить записи">
				</div>
			</form>
		</div>
		<div class=DB_driver>
			<form action="admin.php" method=post>
				<div class=DB_Delete>
					<div style="position:absolute;left:39%;top:1%">ВОДИТЕЛИ</div>
					<div class=DB_DeleteEntries>
						<div>| Номер водителя | Имя водителя | Номер рейса |</div><br>
						<?php
							if(!$res = mysqli_query($link, "SELECT * FROM driver;"))
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
									
									if(isset($_POST['entries'][$i]))
									{
										mysqli_query($link, "START TRANSACTION");
										if(!$res = mysqli_query($link, "DELETE FROM driver WHERE driver_id=".$rows[$i][0].";"))
										{
											echo "Все пропало!<br>";
											echo mysqli_error($link); die();
										;}
										mysqli_query($link, "COMMIT;");
									}
									
									echo ("<div><big>");
									echo ("<input type=checkbox name=entries[] value={$i}>&nbsp;");
									for($j=0;$j<4;$j++)
									{
										echo ("{$rows[$i][$j]}&nbsp;&nbsp;&nbsp;&nbsp;");
									}
									echo ("</div></big><br>");
									
								}
							}
						?>
					</div>
					<input style="position:absolute;left:35%;top:90%" type=submit value="Удалить записи">
				</div>
			</form>
		</div>
		<div class=DB_bus>
			<form action="admin.php" method=post>
				<div class=DB_Delete>
					<div style="position:absolute;left:39%;top:1%">АВТОБУСЫ</div>
					<div class=DB_DeleteEntries>
						<div>| Номер автобуса | Вид автобуса | количество мест | Номер рейса |</div><br>
						<?php
							if(!$res = mysqli_query($link, "SELECT * FROM bus;"))
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
									
									if(isset($_POST['entries'][$i]))
									{
										mysqli_query($link, "START TRANSACTION");
										if(!$res = mysqli_query($link, "DELETE FROM bus WHERE bus_id=".$rows[$i][0].";"))
										{
											echo "Все пропало!<br>";
											echo mysqli_error($link); die();
										;}
										mysqli_query($link, "COMMIT;");
									}
									
									echo ("<div><big>");
									echo ("<input type=checkbox name=entries[] value={$i}>&nbsp;");
									for($j=0;$j<4;$j++)
									{
										echo ("{$rows[$i][$j]}&nbsp;&nbsp;&nbsp;&nbsp;");
									}
									echo ("</div></big><br>");
									
								}
							}
						?>
					</div>
					<input style="position:absolute;left:35%;top:90%" type=submit value="Удалить записи">
				</div>
			</form>
		</div>
		<div class=DB_InsertAll>
			<form action="admin.php" method=post>
				<div class=DB_Insert>
					<div style="position:absolute;left:5%;top:10%">Время отправления</div>
					<input value="2000-01-01T00:00" style="position:absolute; left:5%;top:20%" type="datetime-local" name="trip_datetime">
					<div style="position:absolute;left:5%;top:30%">Номер рейса</div>
					<input value="1" style="position:absolute;left:5%;top:40%" type=text name="trip_id">
					<div style="position:absolute;left:50%;top:10%">Время в рейсе</div>
					<input value="10" style="position:absolute;left:50%;top:20%" type=text name="trip_time">
					<div style="position:absolute;left:50%;top:30%">Номер маршрута</div>
					<input value="1" style="position:absolute;left:50%;top:40%" type=text name="trip_route_id">
				</div>				
				
				<div class=DB_Insert>
					<div style="position:absolute;left:5%;top:10%">Пункт отправления</div>
					<input value="Moscow" style="position:absolute; left:5%;top:20%" type=text name="dep_place">
					<div style="position:absolute;left:5%;top:30%">Номер маршрута</div>
					<input value="1" style="position:absolute;left:5%;top:40%" type=text name="route_id">
					<div style="position:absolute;left:50%;top:10%">Пункт прибытия</div>
					<input value="St. Petersburg" style="position:absolute;left:50%;top:20%" type=text name="dest_place">
					<div style="position:absolute;left:50%;top:30%">Дата отправления</div>
					<input value="2000-01-01" style="position:absolute;left:50%;top:40%" type=date name="route_date">
				</div>
				
				<div class=DB_Insert>
					<div style="position:absolute;left:5%;top:10%">Имя водителя</div>
					<input value="Ivanov Ivan Ivanovich" style="position:absolute;left:5%;top:20%" type=text name="driver_name">
					<div style="position:absolute;left:5%;top:30%">Номер водителя</div>
					<input value="1" style="position:absolute;left:5%;top:40%" type=text name="driver_id">
					<div style="position:absolute;left:50%;top:10%">Номер рейса</div>
					<input value="1" style="position:absolute;left:50%;top:20%" type=text name="driver_trip_id">
				</div>
				
				<div class=DB_Insert>
					<div style="position:absolute;left:5%;top:10%">Вид автобуса</div>
					<input value="type 1" style="position:absolute;left:5%;top:20%" type=text name="bus_type">
					<div style="position:absolute;left:5%;top:30%">Номер автобуса</div>
					<input value="1" style="position:absolute;left:5%;top:40%" type=text name="bus_id">
					<div style="position:absolute;left:50%;top:10%">Количество мест</div>
					<input value="20" style="position:absolute;left:50%;top:20%" type=text name="number_places">
					<div style="position:absolute;left:50%;top:30%">Номер рейса</div>
					<input value="1" style="position:absolute;left:50%;top:40%" type=text name="bus_trip_id">
					
				</div>
				<input style="position:absolute;left:46.5%;top:103%" type=submit value="Добавить запись">
				<?php
					$tripDatetime=$_POST['trip_datetime'];
					$tripId=$_POST['trip_id'];
					$tripTime=$_POST['trip_time'];
					$tripRouteId=$_POST['trip_route_id'];
					$depPlace=$_POST['dep_place'];
					$routeId=$_POST['route_id'];
					$destPlace=$_POST['dest_place'];
					$routeDate=$_POST['route_date'];
					$driverName=$_POST['driver_name'];
					$driverId=$_POST['driver_id'];
					$driverTripId=$_POST['driver_trip_id'];
					$busType=$_POST['bus_type'];
					$busId=$_POST['bus_id'];
					$numberPlaces=$_POST['number_places'];
					$busTripId=$_POST['bus_trip_id'];
					
					if(isset($tripDatetime, $tripId, $tripRouteId, $depPlace, $routeId, $destPlace, $routeDate, $driverName, $driverId, $driverTripId, $busType, $numberPlaces, $busTripId))
					{
						$tripDatetime = date("Y-m-d H:i:s", strtotime($tripDatetime));
						
						mysqli_query($link, "START TRANSACTION");
						if(!$res = mysqli_query($link, "INSERT IGNORE INTO route SET route_id=".addslashes($routeId).", `departure place`='".addslashes($depPlace)."',`destination place`='".addslashes($destPlace)."', `departure date`='".addslashes($routeDate)."';"))
						{
							echo "Все пропало! route<br>";
							echo mysqli_error($link); die();
						;}
						if(!$res = mysqli_query($link, "INSERT IGNORE INTO trip SET `departure time/date`='".addslashes($tripDatetime)."', `trip time`=".addslashes($tripTime).", `trip id`=".addslashes($tripId).", route_route_id=".addslashes($tripRouteId).";"))
						{
							echo "Все пропало! trip<br>";
							echo mysqli_error($link); die();
						;}
						if(!$res = mysqli_query($link, "INSERT IGNORE INTO bus SET bus_id='".addslashes($busId)."' , bus_type='".addslashes($busType)."', `places_number`=".addslashes($numberPlaces).", `trip_trip id`=".addslashes($busTripId).";"))
						{
							echo "Все пропало! bus<br>";
							echo mysqli_error($link); die();
						;}
						if(!$res = mysqli_query($link, "INSERT IGNORE INTO driver SET driver_id='".addslashes($driverId)."', driver_name='".addslashes($driverName)."', `trip_trip id`=".addslashes($driverTripId).";"))
						{
							echo "Все пропало! driver<br>";
							echo mysqli_error($link); die();
						;}
						mysqli_query($link, "COMMIT;");
					}
					
				?>
			</form>
		</div>
	</body>
</html>