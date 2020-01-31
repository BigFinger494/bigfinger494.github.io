<?php
function login($db, $login, $password) {
	global $link;
	$link = mysqli_connect("localhost", $login, $password, $db);
	if (!$link) {
		echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
		echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
		if (!empty($_SESSION['login']) && !empty($_SESSION['password'])){
			unset($_SESSION['login'],$_SESSION['password']);
		}
		return false;
	}
	return true;
}
function window($header, $message, $x, $back, $ok) {
	echo "
		<table class='simple-little-table' cellspacing='0'>
		<tbody>
			<tr>
				<th>".$header."</th>
	";
	if ($x){
		echo "
			<th>
				<form method='post' action='admin.php'>
				<button type='submit' name='section' value='".$back."'>x</button>
				</form>
			</th>";
	}
	echo "
		</tr>
			<tr>
				<th>
					".$message
	;
	if ($ok){
		echo "
			<br>
			<form action='admin.php' method='POST'>
				<button type='submit' name='section' value='".$back."'>Ok</button>
			</form>
		";
	}
	echo "</th>";
	if ($x){
		echo "
			<th></th>
		";
	}
	echo "
			</tr>
		</tbody>
		</table>
	";
}
function images_size($tmp_name, $new_name, $resolution_width, $resolution_height, $max_size){

//проверяем размер файла
$image_size = filesize($tmp_name);
$image_size = floor($image_size / '1048576') ;
if($image_size <= $max_size) {

$params = getimagesize($tmp_name) ;
//проверяем ширину и высоту, нужно ли обрезание
if($params['0'] > $resolution_width || $params['1'] > $resolution_height) {
//пишем фото --------->
//получаем нужные переменные
switch ($params['2']) {
case 1: $old_img = imagecreatefromgif($tmp_name); break;
case 2: $old_img = imagecreatefromjpeg($tmp_name); break;
case 3: $old_img = imagecreatefrompng($tmp_name); break;
case 6: $old_img = imagecreatefromwbmp($tmp_name); break;
}
//вычисляем новые размеры
if($params['0'] > $params['1']) {
$size = $params['0'] ;
$resolution = $resolution_width;
}
else {
$size = $params['1'] ;
$resolution = $resolution_height;
}
$new_width = floor($params['0'] * $resolution / $size) ;
$new_height = floor($params['1'] * $resolution / $size) ;
//создаём новое изображение
$new_img = imagecreatetruecolor($new_width, $new_height) ;
imagecopyresampled ($new_img, $old_img, 0, 0, 0, 0, $new_width, $new_height, $params['0'], $params['1']) ;

//сохраняем новое изображение----->>>>>>
//определяем тип изображения
switch ($params['2']) {
case 1: $type = '.gif'; break;
case 2: $type = '.jpg'; break;
case 3: $type = '.png'; break;
case 6: $type = '.bmp'; break;
}
//Сохраняем
$new_name = "$new_name$type" ;
switch ($type) {
case '.gif': imagegif($new_img, $new_name); break;
case '.jpg': imagejpeg($new_img, $new_name, 100); break;
case '.bmp': imagejpeg($new_img, $new_name, 100); break;
case '.png': imagepng($new_img, $new_name); break;
}
$message = ('<font class="message">Изображение добавлено</font><br>') ;
imagedestroy($old_img);
}



//если не нужно обрезать-------------------->>>>>>>>>>>>>>>>>>>>>>>
else {
//сохраняем новое изображение----->>>>>>
//определяем тип изображения
switch ($params['2']) {
case 1: $type = '.gif'; break;
case 2: $type = '.jpg'; break;
case 3: $type = '.png'; break;
case 6: $type = '.bmp'; break;
}
//Сохраняем
$new_name = "$new_name$type" ;
copy($tmp_name, $new_name);
$message = ('<font class="message">Изображение добавлено</font><br>') ;
}
}
else $errors = ('<font class="error">Слишком большой размер</font><br>') ;


return($message);
return($errors);
}
?>