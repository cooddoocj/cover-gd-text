<?php

error_reporting(0);

require __DIR__.'/vendor/autoload.php';

use GDText\Box;
use GDText\Color;

if (isset($_POST['submit'])) {

	if (empty($_POST['tacpham'])) {
		exit('Error!');
	}

	// lay cover
	if (!empty($_POST['mau'])) {
		$mau = $_POST['mau'];
	} else {
		$mau = random_array(array('trang', 'do', 'toi'));
	}
	$covers = glob("images/covers/" . $_POST['theloai'] . "__" . $mau . "_*.jpg");
	$img_path = random_array($covers);

	$im = imagecreatefromjpeg($img_path);
	$tacpham = get_title($_POST['tacpham'], true);
	$tacgia = get_title($_POST['tacgia'], true);

	$tacgia_line = substr_count($tacgia, " ");
	if ($tacgia_line <= 4) {
		$tacgia_size = 40;
	} elseif ($tacgia_line == 5) {
		$tacgia_size = 35;
	} elseif ($tacgia_line == 6) {
		$tacgia_size = 32;
	} else {
		$tacgia_size = 30;
	}

	$tacpham_line = substr_count($tacpham, " ");

	// check so chu
	if ($tacpham_line > 12 || $tacgia_line > 10) {
		exit('Tác phẩm < 12 chữ, tác giả < 10 chữ');
	}

	// kiem hiep
	if ($_POST['theloai'] == 'kiem_hiep') {

		if ($mau == 'toi') {
			$tacpham_color = array(255, 0, 0);
			$tacpham_shadow = array(128, 0, 0);
		} elseif ($mau == 'trang') {
			$tacpham_color = array(204, 51, 0);
			$tacpham_shadow = array(51, 51, 51);			
		} elseif ($mau == 'do') {
			$tacpham_color = array(0, 204, 0);
			$tacpham_shadow = array(0, 102, 0);			
		}

		if ($tacpham_line < 4) {

			if ($tacpham_line == 0 || $tacpham_line == 1) {
				$tacpham_size = 120;
			} elseif ($tacpham_line == 2) {
				$tacpham_size = 110;
			} elseif ($tacpham_line == 3) {
				$tacpham_size = 100;
			}

			$tacpham = str_replace(" ", "\n", $tacpham);
			$tacgia = str_replace(" ", "\n", $tacgia);

			// con dau
			if (isset($_POST['condau'])) {
				$stamp = imagecreatefrompng('images/con_dau.png');
				$marge_right = 130;
				$marge_bottom = 130;
				imagecopy($im, $stamp, imagesx($im) - imagesx($stamp) - $marge_right, imagesy($im) - imagesy($stamp) - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
			}

			if (!empty($_POST['tacgia'])) {
				// tac gia
				$box = new Box($im);
				$box->setFontFace(__DIR__.'/font/mang_cau.ttf');
				$box->setFontColor(new Color(0, 0, 0));
				$box->setFontSize($tacgia_size);
				$box->setBox(130, 0, 600, 800);
				$box->setTextAlign('center', 'center');
				$box->setStrokeColor(new Color(242, 242, 242));
				$box->setStrokeSize(1);
				$box->draw($tacgia);
			}

			// tac pham
			$box = new Box($im);
			$box->setFontFace(__DIR__.'/font/'.random_array(array('hl_thufap1', 'thien_an')).'.ttf');
			$box->setFontColor(new Color($tacpham_color[0], $tacpham_color[1], $tacpham_color[2]));
			$box->setTextShadow(new Color($tacpham_shadow[0], $tacpham_shadow[1], $tacpham_shadow[2]), 2, 2);
			$box->setFontSize($tacpham_size);
			$box->setLineHeight(1.5);
			$box->setBox(0, 0, 600, 800);
			$box->setTextAlign('center', 'center');
			$box->draw($tacpham);
		} else {

			// tac pham
			$box = new Box($im);
			$box->setFontFace(__DIR__.'/font/hl_ong_do.ttf');
			$box->setFontColor(new Color($tacpham_color[0], $tacpham_color[1], $tacpham_color[2]));
			$box->setTextShadow(new Color($tacpham_shadow[0], $tacpham_shadow[1], $tacpham_shadow[2]), 2, 2);
			$box->setFontSize(72);
			$box->setLineHeight(1);
			$box->setBox(20, 100, 560, 760);
			$box->setTextAlign('center', 'top');
			$box->draw($tacpham);

			if (!empty($_POST['tacgia'])) {
				// tac gia
				$box = new Box($im);
				$box->setFontFace(__DIR__.'/font/mang_cau.ttf');
				$box->setFontColor(new Color(0, 51, 102));
				$box->setFontSize($tacgia_size);
				$box->setBox(20, -100, 560, 760);
				$box->setTextAlign('center', 'bottom');
				$box->setStrokeColor(new Color(242, 242, 242)); // Set stroke color
				$box->setStrokeSize(1); // Stroke size in pixels
				$box->draw($tacgia);
			}
		}

	} else { // ngon tinh

		if ($tacpham_line == 0 || $tacpham_line == 1) {
			$tacpham_size = 100;
		} elseif ($tacpham_line == 2) {
			$tacpham_size = 90;
		} elseif ($tacpham_line == 3) {
			$tacpham_size = 80;
		} elseif ($tacpham_line == 4) {
			$tacpham_size = 72;
		} else {
			$tacpham_size = 65;
		}

		// font
		if ($_POST['theloai'] == 'di_nang' && $mau == 'trang') {
			$tacpham_font = 'than_chien_tranh';
			$tacpham_color = array(204, 0, 204);
			$tacpham_shadow = array(102, 0, 102);
		} elseif ($_POST['theloai'] == 'di_nang' && $mau == 'toi') {
			$tacpham_font = 'than_chien_tranh';
			$tacpham_color = array(51, 204, 51);
			$tacpham_shadow = array(255, 255, 255);
		} elseif ($_POST['theloai'] == 'di_nang' && $mau == 'do') {
			$tacpham_font = 'than_chien_tranh';
			$tacpham_color = array(0, 0, 255);
			$tacpham_shadow = array(255, 255, 255);
		} elseif ($_POST['theloai'] == 'co_dai' && $mau == 'do') {
			$tacpham_font = 'fleur';
			$tacpham_color = array(204, 0, 153);
			$tacpham_shadow = array(102, 0, 204);
		} elseif ($_POST['theloai'] == 'co_dai' && $mau == 'toi') {
			$tacpham_font = 'fleur';
			$tacpham_color = array(255, 153, 204);
			$tacpham_shadow = array(255, 51, 204);
		} elseif ($_POST['theloai'] == 'co_dai' && $mau == 'trang') {
			$tacpham_font = 'fleur';
			$tacpham_color = array(204, 0, 102);
			$tacpham_shadow = array(102, 0, 51);
		} elseif ($_POST['theloai'] == 'hien_dai' && $mau == 'trang') {
			$tacpham_font = 'buc_thu';
			$tacpham_color = array(204, 0, 102);
			$tacpham_shadow = array(102, 0, 51);
		} elseif ($_POST['theloai'] == 'hien_dai' && $mau == 'do') {
			$tacpham_font = 'buc_thu';
			$tacpham_color = array(204, 0, 153);
			$tacpham_shadow = array(102, 0, 204);
		} elseif ($_POST['theloai'] == 'hien_dai' && $mau == 'toi') {
			$tacpham_font = 'buc_thu';
			$tacpham_color = array(255, 153, 204);
			$tacpham_shadow = array(255, 51, 204);
		} else {
			$tacpham_font = 'buc_thu';
			$tacpham_color = array(204, 0, 102);
			$tacpham_shadow = array(102, 0, 51);
		}

		// tac pham
		$box = new Box($im);
		$box->setFontFace(__DIR__.'/font/'.$tacpham_font.'.ttf');
		$box->setFontColor(new Color($tacpham_color[0], $tacpham_color[1], $tacpham_color[2]));
		$box->setTextShadow(new Color($tacpham_shadow[0], $tacpham_shadow[1], $tacpham_shadow[2]), 2, 2);
		$box->setFontSize($tacpham_size);
		$box->setLineHeight(1.2);
		$box->setBox(20, 100, 560, 760);
		$box->setTextAlign('center', 'top');
		$box->draw($tacpham);

		if (!empty($_POST['tacgia'])) {
			// tac gia
			$box = new Box($im);
			$box->setFontFace(__DIR__.'/font/ben_xuan.ttf');
			$box->setFontColor(new Color(0, 51, 102));
			$box->setFontSize($tacgia_size);
			$box->setBox(20, -100, 560, 760);
			$box->setTextAlign('center', 'bottom');
			$box->setStrokeColor(new Color(242, 242, 242)); // Set stroke color
			$box->setStrokeSize(1); // Stroke size in pixels
			$box->draw($tacgia);
		}
	}


	if (!empty($_POST['watermark'])) {
		// logo
		$box = new Box($im);
		$box->setFontFace(__DIR__.'/font/old_stamper.ttf');
		$box->setFontColor(new Color(102, 26, 0));
		$box->setFontSize(18);
		$box->setBox(-2, -2, 600, 800);
		$box->setTextAlign('right', 'bottom');
		$box->draw($_POST['watermark']);
	}

	// save
	$ten = 'files/' . rand() . '.jpg';
	imagepng($im, $ten);
	imagedestroy($im);

	$ten_size = round(filesize($ten)/256)/4 . 'KB';
	$tacpham = preg_replace('/\s+/', ' ', $tacpham);
	$ten_new = str_replace('files/', '', $ten);
	$show = "<p>$tacpham</p>\n<p><a href='$ten' target='_blank'>$ten_new ($ten_size)</a></p>\n";

}

function get_title($title, $mb = false) {
	$title = preg_replace('/[^A-Za-z0-9àáãạảăắằẳẵặâấầẩẫậèéẹẻẽêềếểễệđìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳỵỷỹýÀÁÃẠẢĂẮẰẲẴẶÂẤẦẨẪẬÈÉẸẺẼÊỀẾỂỄỆĐÌÍĨỈỊÒÓÕỌỎÔỐỒỔỖỘƠỚỜỞỠỢÙÚŨỤỦƯỨỪỬỮỰỲỴỶỸÝ]/', ' ', $title);
	$title = preg_replace('/\s+/', ' ', $title);
	$title = trim($title);
	if ($mb) {
		$title = mb_convert_case($title, MB_CASE_TITLE, "UTF-8"); // heroku khong ho tro ham nay bat "ext-mbstring": "*" vao composer.json và composer.lock
	}
	return $title;
}

function random_array($array = array()) {
	$k = array_rand($array);
	return $array[$k];
}
//echo random_array(array('#000000', '#990000', '#ff6680'));

?>
<title>cover</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
	a { text-decoration: none; }
	input[type=text],
	input[type=submit],
	select {
		display: block;
		margin: 10px 0;
	}
</style>
<?php
if (isset($show)) {
	echo $show;
}
?>
<form method="post">
	<input type="text" name="tacpham" onfocus="this.value=''" value="<?php echo isset($_POST['tacpham']) ? $_POST['tacpham'] : 'Bàn Long'; ?>">
	<input type="text" name="tacgia" onfocus="this.value=''" value="<?php echo isset($_POST['tacgia']) ? $_POST['tacgia'] : 'Ngã Cật Tây Hồng Thị'; ?>">
	<select name="theloai">
	<?php
	$tls = array('kiem_hiep' => 'Kiếm Hiệp', 'hien_dai' => 'Hiện Đại', 'co_dai' => 'Cổ Đại', 'di_nang' => 'Dị Năng', 'mac_dinh' => 'Khác');
	foreach($tls as $value => $name)
	{
		if($value == $_POST['theloai'])
		{
			echo "<option selected='selected' value='".$value."'>".$name."</option>";
		}
		else
		{
			echo "<option value='".$value."'>".$name."</option>";
		}
	}
	?>
	</select>
	<div style="background-color: #00bcd4; display: inline-block;">
	<input type="radio" name="mau" value="do" <?php if($mau == 'do') { echo 'checked'; } ?>> <font color="#990000">đỏ</font>
	<input type="radio" name="mau" value="toi" <?php if($mau == 'toi') { echo 'checked'; } ?>> <font color="#000000">tối</font>
	<input type="radio" name="mau" value="trang" <?php if($mau == 'trang') { echo 'checked'; } ?>> <font color="#fffff">trắng</font>
	</div>
	<input type="text" name="watermark" onfocus="this.value=''" value="<?php echo isset($_POST['watermark']) ? $_POST['watermark'] : 'example.com'; ?>">
	<input type="checkbox" name="condau" <?php if(isset($_POST['condau'])) { echo 'checked'; } ?>> <img src="images/con_dau.png" width="30" height="30"> (kiếm hiệp)
	<input type="submit" name="submit" value="Create">
</form>