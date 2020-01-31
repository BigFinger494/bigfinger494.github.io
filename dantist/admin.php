<!DOCTYPE html>
<html>
<head>
    <title>Панель администратора</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<style>
	
		input[type=text] {
			padding:5px; 
			border:2px solid #ccc; 
			-webkit-border-radius: 5px;
			border-radius: 5px;
		}
		input[type=text]:focus {
			border-color:#333;
		}
		textarea {
			padding:5px; 
			border:2px solid #ccc; 
			-webkit-border-radius: 5px;
			border-radius: 5px;
		}
		textarea:focus {
			border-color:#333;
		}
		input[type=number] {
			padding:5px; 
			border:2px solid #ccc; 
			-webkit-border-radius: 5px;
			border-radius: 5px;
		}
		input[type=number]:focus {
			border-color:#333;
		}
		input[type=file] {
			padding:5px; 
			border:2px solid #ccc; 
			-webkit-border-radius: 5px;
			border-radius: 5px;
		}
		input[type=file]:focus {
			border-color:#333;
		}
		input[type=password] {
			padding:5px; 
			border:2px solid #ccc; 
			-webkit-border-radius: 5px;
			border-radius: 5px;
		}
		input[type=password]:focus {
			border-color:#333;
		}
		input[type=submit] {
			padding:5px 15px; 
			background:#ccc; 
			border:0 none;
			cursor:pointer;
			-webkit-border-radius: 5px;
			border-radius: 5px; 
		}
		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
			width: 25%;
			background-color: #f1f1f1;
			position: fixed;
			height: 100%;
			overflow: auto;
		}
		li button {
			display: block;
			color: #000000;
			padding: 8px 16px;
			text-decoration: none;
			height: 40px;
			float:none;;width:100%;margin:0!important;
		}
		li button.active {
		background-color: #4CAF50;
		color: white;
		}
		li button:hover:not(.active) {
		background-color: #555;
		color: white;
		}
		figure img {
			width: 1%; /* Ширина в процентах */
		}
	</style>
</head>
<body>
	<?php
	include("functions.php");$db="docplomb";
	@session_start();
	if(isset($_POST['del'])){
		//unset($_SESSION['LOG']);
		unset ($_SESSION['password']);
		unset ($_SESSION['login']);
	} //else
	if(isset($_POST['login']) && isset($_POST['password'])) {

		$_SESSION['login'] = $_POST['login'];

		$_SESSION['password'] = $_POST['password'];

	}
	$LOG = false;
	if(isset($_SESSION['login']) && isset($_SESSION['password'])) {
		if(login($db,$_SESSION['login'],$_SESSION['password'])) {
			//Боковая панель
			echo "
				<ul class='vertical'>
					<form action='admin.php' method='POST'>
					<li><button type='submit' name='section' value='staff'>Сотрудники</button></li>
					<li><button type='submit' name='section' value='services'>Услуги</button></li>
					<li><button type='submit' name='section' value='contacts'>Контакты</button></li>
					<li><button type='submit' name='section' value='promos'>Акции</button></li>
					</form>
					
				</ul>
				<div style='margin-left:25%;padding:1px 16px;height:1000px;'>
				<form method='post' action='admin.php'>
				<p align='right'><button type='submit' name='del' value='-1'>Выйти из учетной записи</button></p>
				</form>
			";
			//подразделы
			if (!empty($_POST['section'])){
				//Отобразить таблицу с сотрудниками
				if ($_POST['section']=='staff'){
					$sql="SELECT * FROM staff";
					if(@@login($db, $_SESSION['login'], $_POST['password'])){
						$result=mysqli_query($GLOBALS['link'], $sql);
						$nrows=mysqli_num_rows($result);
						echo "
							<h1>Сотрудники</h1><br>
							<table class='simple-little-table' cellspacing='0'>
							<tbody>
								<tr>
									<th>Фамилия</th>
									<th>Имя</th>
									<th>Отчество</th>
									<th>Специальность</th>
									<th>Фото</th>
									<th></th>
									<th>
										<form action='admin.php' method='POST'>
										<button type='submit' name='staff_add' value='staff_add'>Добавить</button>
										</form>
									</th>
								</tr>
						";
						for ($i=0;$i<$nrows; $i++) {
							$assoc=mysqli_fetch_assoc($result);
							echo "
								<tr>
									<td>".$assoc['surname']."</td>
									<td>".$assoc['name']."</td>
									<td>".$assoc['patronym']."</td>
									<td>".$assoc['speciality']."</td>
									<td><img src='./uploaded_files/200px".$assoc['picture']."' style='size:75%;' ></td>
									<form action='admin.php' method='POST'>
										<td><button type='submit' name='staff_edit' value='".$assoc['empID']."'>Редактировать</button></td>
										<td><p align='center'><button type='submit' name='staff_delete' value='".$assoc['empID']."'>Удалить</button></p></td>
									</form>
								</tr>
							";
						}
						echo "	
							</tbody>
							</table>
							<br>
						";
					}
				}
				//Отобразить таблицу с услугами
				if ($_POST['section']=='services') {
					$sql="SELECT * FROM services";
					if(@login($db, $_SESSION['login'], $_POST['password'])){
						$result=mysqli_query($GLOBALS['link'], $sql);
						$nrows=mysqli_num_rows($result);
						echo "
							<h1>Услуги</h1><br>
							<table class='simple-little-table' cellspacing='0'>
							<tbody>
								<tr>
									<th>Услуга</th>
									<th>Описание</th>
									<th>Цена</th>
									<th></th>
									<th>
										<form action='admin.php' method='POST'>
										<button type='submit' name='serv_add' value='serv_add'>Добавить</button>
										</form>
									</th>
								</tr>
						";
						for ($i=0;$i<$nrows; $i++) {
							$assoc=mysqli_fetch_assoc($result);
							echo "
								<tr>
									<td>".$assoc['service']."</td>
									<td style='width:200px;word-break: break-all;'>".$assoc['description']."</td>
									<td>".$assoc['price']."</td>
									<form action='admin.php' method='POST'>
										<td><button type='submit' name='serv_edit' value='".$assoc['serID']."'>Редактировать</button></td>
										<td><p align='center'><button type='submit' name='serv_delete' value='".$assoc['serID']."'>Удалить</button></p></td>
									</form>
								</tr>
							";
						}
						echo "	
							</tbody>
							</table>
							<br>
						";
					}
				}
				//Отобразить контакты
				if ($_POST['section']=='contacts') {
					$sql="SELECT * FROM contacts";
					if(@login($db, $_SESSION['login'], $_POST['password'])){
						$result=mysqli_query($GLOBALS['link'], $sql);
						$nrows=mysqli_num_rows($result);
						echo "
							<table class='simple-little-table' cellspacing='0'>
							<tbody>
								<tr>
									<th>Контакты</th>
								</tr>
						";
						for ($i=0;$i<$nrows; $i++) {
							$assoc=mysqli_fetch_assoc($result);
							echo "
								<tr>
									<td>
										Время работы: с ".$assoc['time_start']." до ".$assoc['time_end']."<br><br>
										Адрес: ".$assoc['address']."<br><br>
										Телефоны:<br><br>
										".$assoc['phones']."<br><br>
										<form action='admin.php' method='POST'>
											<p align='center'><button type='submit' name='con_edit' value='".$assoc['conID']."'>Редактировать</button></p>
										</form>
									</td>
								</tr>
							";
						}
						echo "	
					    	</tbody>
					    	</table>
					    	<br>
					    ";
					}
				}
			}
			//Окно редактирования сотрудника
			if (!empty($_POST['staff_edit'])){
				$sql="SELECT * FROM staff WHERE empID = ".$_POST['staff_edit'];
				if(@login($db, $_SESSION['login'], $_POST['password'])){
					$result=mysqli_query($GLOBALS['link'], $sql);
					$nrows=mysqli_num_rows($result);
					for ($i=0;$i<$nrows; $i++) {
						$assoc=mysqli_fetch_assoc($result);
						window("Редактировать сотрудника",
							"<form method='post' id='emp_ed' action='admin.php'>
								<input type='text' placeholder='Фамилия' 
									name='surname' 
									value='".$assoc['surname']."'
									required><br><br>
								<input type='text' placeholder='Имя' 
									name='name' 
									value='".$assoc['name']."'
									required><br><br>
								<input type='text' placeholder='Отчество' 
									name='patronym' 
									value='".$assoc['patronym']."'
									><br><br>
								<input type='text' placeholder='Специальность' 
									name='speciality' 
									value='".$assoc['speciality']."'
									required><br><br>
								<p ALIGN='center'><button type='submit' name='emp_ed' value='".$_POST['staff_edit']."'>Редактировать</button>
								<br><br></p>
							</form>", true, "staff", false);
					}
				}
			}
			//Обновить информацию о сотруднике
			if (!empty($_POST['emp_ed'])){
				$sql="UPDATE staff SET 
					  surname = '".$_POST['surname']."', 
					  name = '".$_POST['name']."', 
					  patronym = '".$_POST['patronym']."', 
					  speciality = '".$_POST['speciality']."' 
					  WHERE empID = ".$_POST['emp_ed'];
				if(@login($db, $_SESSION['login'], $_POST['password'])){
					$result=mysqli_query($GLOBALS['link'], $sql);
					if ($result){
						window("Успех","Сотрудник успешно отредактирован", false, "staff", true);
					} else {
						window("Ошибка","Произошла ошибка при редактировании", false, "staff", true);
					}
				}
			}
			//Окно подтверждения удаления сотрудника
			if (!empty($_POST['staff_delete'])){
				window("Вы действительно хотите удалить этого сотрудника?", 
					"<form action='admin.php' method='POST'>
						<button type='submit' name='emp_del' value='".$_POST['staff_delete']."'>Да</button>
						<button type='submit' name='section' value='staff'>Нет</button>
					</form>", false, "staff", false
				);
			}
			//Удаление сотрудника
			if (!empty($_POST['emp_del'])){
				
				if(@login($db, $_SESSION['login'], $_POST['password'])){
					$sql="SELECT picture FROM staff 
					  WHERE empID = ".$_POST['emp_del'];
					$fileName = mysqli_fetch_assoc(mysqli_query($GLOBALS['link'], $sql))['picture'];
					@unlink($fileName);
					@unlink("200px".$fileName);
					$sql="DELETE FROM staff 
					  WHERE empID = ".$_POST['emp_del'];
					$result=mysqli_query($GLOBALS['link'], $sql);
					if ($result){
						window("Успех","Сотрудник успешно удален", false, "staff", true);
					} else {
						window("Ошибка","Произошла ошибка при удалении", false, "staff", true);
					}
				}
			}
			//Окно добавления сотрудника
			if (!empty($_POST['staff_add'])){
				window("Добавить сотрудника",
					"<form enctype='multipart/form-data' method='post' action='admin.php'>
						<input type='text' placeholder='Фамилия'  style='width: 100%;'
							name='surname' 
							required><br><br>
						<input type='text' placeholder='Имя' 	style='width: 100%;'
			    			name='name' 
			    			required><br><br>
			    		<input type='text' placeholder='Отчество'  style='width: 100%;'
			    			name='patronym' 
			    			><br><br>
			    		<input type='text' placeholder='Специальность'  style='width: 100%;'
			    			name='speciality' 
			    			required>
						<br><br>
						<input type='hidden' name='MAX_FILE_SIZE' value='1048576' />
						Выберите фото сотрудника (Не более 1 МБ): <br><input name='photo' type='file' accept='image/*,image/jpeg' style='width: 100%;' />
						<br><br>
						<p align='center'><input type='submit' name='emp_add' value='Добавить сотрудника'  /></p>
			    	</form>", true, "staff", false
				);
			}
			//Добавление сотрудника
			if (!empty($_POST['emp_add'])){
				$fileTmpPath = $_FILES['photo']['tmp_name'];
				$fileName = $_FILES['photo']['name'];
				$fileSize = $_FILES['photo']['size'];
				$fileType = $_FILES['photo']['type'];
				$fileNameCmps = explode(".", $fileName);
				$fileExtension = strtolower(end($fileNameCmps));
				$fName = md5(time() . $fileName);
				$newFileName = $fName . '.' . $fileExtension;
				$uploadFileDir = './uploaded_files/';
				$dest_path = $uploadFileDir . $newFileName;
				$pic = true;
				if(!move_uploaded_file($fileTmpPath, $dest_path))
				{
					window("Ошибка","Ошибка при загрузке фото", false, "staff", true);
					//$dest_path = $uploadFileDir . 'default.png';
					$pic = false;
				}
				$sql="INSERT INTO staff 
					  (surname, name, patronym, speciality, picture)  
					  VALUES(
						'".$_POST['surname']."', 
						'".$_POST['name']."', 
						'".$_POST['patronym']."', 
						'".$_POST['speciality']."', 
						'".$newFileName."'
					  )";
				if(@login($db, $_SESSION['login'], $_POST['password']) && $pic){
					$tmp_name = 'uploaded_files/'.$newFileName;
					$new_name = 'uploaded_files/200px'.$fName; //без расширения
					$resolution_width = '200';
					$resolution_height = '200';
					$max_size = '10';
					$message = images_size($tmp_name, $new_name, $resolution_width, $resolution_height, $max_size);
					$result=mysqli_query($GLOBALS['link'], $sql);
					if ($result){
						window("Успех","Сотрудник успешно добавлен", false, "staff", true);
					} else {
						window("Ошибка","Произошла ошибка при добавлении", false, "staff", true);
					}
				}
			}
			///////////////////////////////////////////////////////////////////////////////////
			//Окно добавления услуги
			if (!empty($_POST['serv_add'])){
				window("Добавить услугу",
					"<form enctype='multipart/form-data' method='post' action='admin.php'>
						<input type='text' placeholder='Название'  style='width: 100%;'
							name='service' 
							required><br><br>
						<p>Описание<br>
			    		<textarea rows='5' style='width: 100%;'
			    			name='description' 
			    			required></textarea></p>
						<p>Цена<br>
						<input type='number' value='1000' min='0' step='500' style='width: 100%;'	
							name='price' 	
							required></p><br><br>
						<p align='center'><input type='submit' name='s_add' value='Добавить услугу'  /></p>
			    	</form>", true, "services", false
				);
			}
			//Добавление услуги
			if (!empty($_POST['s_add'])){
				$sql="INSERT INTO services 
					  (service, description, price)  
					  VALUES(
						'".$_POST['service']."', 
						'".$_POST['description']."', 
						'".$_POST['price']."'
					  )";
				if(@login($db, $_SESSION['login'], $_POST['password'])){
					$result=mysqli_query($GLOBALS['link'], $sql);
					if ($result){
						window("Успех","Услуга успешно добавлена", false, "services", true);
					} else {
						window("Ошибка","Произошла ошибка при добавлении", false, "services", true);
					}
				}
			}
			//Окно подтверждения удаления услуги
			if (!empty($_POST['serv_delete'])){
				window("Вы действительно хотите удалить эту услугу?", 
					"<form action='admin.php' method='POST'>
						<button type='submit' name='s_del' value='".$_POST['serv_delete']."'>Да</button>
						<button type='submit' name='section' value='services'>Нет</button>
					</form>", false, "services", false
				);
			}
			//Удаление услуги
			if (!empty($_POST['s_del'])){
				
				if(@login($db, $_SESSION['login'], $_POST['password'])){
					$sql="DELETE FROM services
					  WHERE serID = ".$_POST['s_del'];
					$result=mysqli_query($GLOBALS['link'], $sql);
					if ($result){
						window("Успех","Услуга успешно удален", false, "services", true);
					} else {
						window("Ошибка","Произошла ошибка при удалении", false, "services", true);
					}
				}
			}
			//Окно редактирования услуги
			if (!empty($_POST['serv_edit'])){
				$sql="SELECT * FROM services WHERE serID = ".$_POST['serv_edit'];
				if(@login($db, $_SESSION['login'], $_POST['password'])){
					$result=mysqli_query($GLOBALS['link'], $sql);
					$nrows=mysqli_num_rows($result);
					for ($i=0;$i<$nrows; $i++) {
						$assoc=mysqli_fetch_assoc($result);
						window("Редактировать услугу",
							"<form method='post' id='serv_ed' action='admin.php'>
								<input type='text' placeholder='Название'  style='width: 100%;'
									name='service' 
									value=".$assoc['service']." 
									required><br><br>
								<p>Описание<br>
								<textarea rows='5' style='width: 100%;'
									name='description' 
									required>".$assoc['description']."</textarea></p>
								<p>Цена<br>
								<input type='number' min='0' step='500' style='width: 100%;'
									name='price' 	
									value=".$assoc['price']." 
									required></p><br><br>
								<p ALIGN='center'><button type='submit' name='s_ed' value='".$_POST['con_edit']."'>Редактировать</button>
								<br><br></p>
							</form>", true, "services", false);
					}
				}
			}
			//Обновить информацию о услуги
			if (!empty($_POST['s_ed'])){
				$sql="UPDATE services SET 
					  service = '".$_POST['service']."', 
					  description = '".$_POST['description']."', 
					  price = '".$_POST['price']."' 
					  WHERE serID = ".$_POST['s_ed'];
				if(@login($db, $_SESSION['login'], $_POST['password'])){
					$result=mysqli_query($GLOBALS['link'], $sql);
					if ($result){
						window("Успех","Услуга успешно отредактирован", false, "services", true);
					} else {
						window("Ошибка","Произошла ошибка при редактировании", false, "services", true);
					}
				}
			}
			///////////////////////////////////////////////////////////////////////////////////
			//Окно редактирования контактов
			if (!empty($_POST['con_edit'])){
				$sql="SELECT * FROM contacts WHERE conID = ".$_POST['con_edit'];
				if(@login($db, $_SESSION['login'], $_POST['password'])){
					$result=mysqli_query($GLOBALS['link'], $sql);
					$nrows=mysqli_num_rows($result);
					for ($i=0;$i<$nrows; $i++) {
						$assoc=mysqli_fetch_assoc($result);
						window("Редактировать контакты",
							"<form method='post' id='con_ed' action='admin.php'>
								<input type='text' placeholder='Время открытия'  style='width: 100%;'
									name='time_start' 
									value=".$assoc['time_start']." 
									required><br><br>
								<input type='text' placeholder='Время закрытия'  style='width: 100%;'
									name='time_end' 
									value=".$assoc['time_end']." 
									required><br><br>
								<p>Адрес<br>
								<textarea rows='5' style='width: 100%;'
									name='address' 
									required>".$assoc['address']."</textarea></p><br><br>
								<p>Телефоны<br>
								<textarea rows='5' style='width: 100%;'
									name='phones' 
									required>".$assoc['phones']."</textarea></p>
								<input type='text' placeholder='Email'  style='width: 100%;'
									name='email' 
									value=".$assoc['email']." 
									required><br><br>
								<p ALIGN='center'><button type='submit' name='c_ed' value='".$_POST['con_edit']."'>Редактировать</button>
								<br><br></p>
							</form>", true, "contacts", false);
					}
				}
			}
			//Обновить контакты
			if (!empty($_POST['c_ed'])){
				$sql="UPDATE contacts SET 
					  time_start = '".$_POST['time_start']."', 
					  time_end = '".$_POST['time_end']."', 
					  address = '".$_POST['address']."',
					  phones = '".$_POST['phones']."', 					  
					  email = '".$_POST['email']."' 
					  WHERE conID = ".$_POST['c_ed'];
				if(@login($db, $_SESSION['login'], $_POST['password'])){
					$result=mysqli_query($GLOBALS['link'], $sql);
					if ($result){
						window("Успех","Контакты успешно отредактированы", false, "contacts", true);
					} else {
						window("Ошибка","Произошла ошибка при редактировании", false, "contacts", true);
					}
				}
			}
			echo "
				</div>
			";
			$LOG = true;
		}
	} if (!$LOG)
	{
		echo "
			<table class='simple-little-table' cellspacing='0' style='margin:auto;'>
			<tbody>
				<tr>
					<th>Войти в панель администратора</th>
				</tr>
				<tr>
					<th>
						<form method='post' id='login-form' action='admin.php'>
							<input type='text' placeholder='Логин' 
								name='login' required><br><br>
							<input type='password' placeholder='Пароль'
								name='password' ><br><br>
							<p ALIGN='center'><input type='submit' value='Войти' class='button7'></p>
						</form>
					</th>
				</tr>
			</tbody>
			</table>
		";
	}
	?>
</body>
</html>