<?php

error_reporting(0);

require __DIR__.'/vendor/autoload.php';

use GDText\Box;
use GDText\Color;

/*lay thong tin*/
$info = array(
	'tieude' => 'Vô Tận Đan Điền',
	'tacgia' => 'Hoành Tảo Thiên Nhai',
	'theloai' => array('Tiên Hiệp', 'Dị Giới', 'Huyền Huyễn', 'Trọng Sinh')
);

$tacpham = $info['tieude'];
$tacgia = $info['tacgia'];
$cats = $info['theloai'];

if (in_array('Tiên Hiệp', $cats)) {
	$cover = 'Kiếm Hiệp';
} elseif (in_array('Kiếm Hiệp', $cats)) {
	$cover = 'Kiếm Hiệp';
} elseif (in_array('Dị Năng', $cats)) {
	$cover = 'Dị Năng';
} elseif (in_array('Khoa Huyễn', $cats)) {
	$cover = 'Dị Năng';
} elseif (in_array('Võng Du', $cats)) {
	$cover = 'Dị Năng';
} elseif (in_array('Cổ Đại', $cats)) {
	$cover = 'Cổ Đại';
} else {
	$cover = $cats[0];
}

/*the loai truyenfull*/
if (preg_match('/(Tiên Hiệp|Kiếm Hiệp|Dị Giới|Xuyên Không|Trọng Sinh)/iu', $cover)) {
	$covers = glob("images/covers/kiem_hiep__*.jpg");
	$theloai = 'kiem_hiep';
} elseif (preg_match('/(Ngôn Tình|Đô Thị|Quan Trường|Sắc|Ngược|Sủng|Đam Mỹ|Bách Hợp|Hài Hước|Truyện Teen|Nữ Phụ)/iu', $cover)) {
	$covers = glob("images/covers/hien_dai__*.jpg");
	$theloai = 'hien_dai';
} elseif (preg_match('/(Võng Du|Khoa Huyễn|Huyền Huyễn|Dị Năng|Trinh Thám|Thám Hiểm|Linh Dị|Mạt Thế)/iu', $cover)) {
	$covers = glob("images/covers/di_nang__*.jpg");
	$theloai = 'di_nang';
} elseif (preg_match('/(Cung Đấu|Gia Đấu|Đông Phương|Nữ Cường|Cổ Đại|Quân Sự|Lịch Sử)/iu', $cover)) {
	$covers = glob("images/covers/co_dai__*.jpg");
	$theloai = 'co_dai';
} else {
	$covers = glob("images/covers/mac_dinh__*.jpg");
	$theloai = 'mac_dinh';
}

$img_path = random_array($covers);

$im = imagecreatefromjpeg($img_path);

$tacpham = get_title($tacpham, true);
$tacgia = get_title($tacgia, true);

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
if ($tacpham_line > 18 || $tacgia_line > 12) {
	exit('Tác phẩm < 18 chữ, tác giả < 12 chữ');
}

// kiem hiep
if ($theloai == 'kiem_hiep') {

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
		$stamp = imagecreatefrompng('images/con_dau.png');
		$marge_right = 130;
		$marge_bottom = 130;
		imagecopy($im, $stamp, imagesx($im) - imagesx($stamp) - $marge_right, imagesy($im) - imagesy($stamp) - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

		if (!empty($tacgia)) {
			// tac gia
			$box = new Box($im);
			$box->setFontFace(__DIR__.'/font/mang_cau.ttf');
			$box->setFontColor(new Color(191, 191, 191));
			$box->setTextShadow(new Color(0, 0, 0), -2, -2);
			$box->setFontSize($tacgia_size);
			$box->setBox(130, 100, 600, 800);
			$box->setTextAlign('center', 'center');
			$box->draw($tacgia);		
		}

		// tac pham
		$box = new Box($im);
		$box->setFontFace(__DIR__.'/font/'.random_array(array('hl_thufap1', 'thien_an')).'.ttf');
		$box->setFontColor(new Color(204, 51, 0));
		$box->setStrokeColor(new Color(255, 255, 255));
		$box->setStrokeSize(1);

		$box->setFontSize($tacpham_size);
		$box->setLineHeight(1.5);
		$box->setBox(0, 0, 600, 800);
		$box->setTextAlign('center', 'center');
		$box->draw($tacpham);

	} else {

		// tac pham
		$box = new Box($im);
		$box->setFontFace(__DIR__.'/font/hl_ong_do.ttf');
		$box->setFontColor(new Color(0, 128, 0));
		//$box->setTextShadow(new Color(255, 51, 0), -3, -3);
		$box->setStrokeColor(new Color(242, 242, 242));
		$box->setStrokeSize(2);
		$box->setFontSize(72);
		$box->setLineHeight(1);
		$box->setBox(20, 100, 560, 760);
		$box->setTextAlign('center', 'top');
		$box->draw($tacpham);

		if (!empty($tacgia)) {
			// tac gia
			$box = new Box($im);
			$box->setFontFace(__DIR__.'/font/mang_cau.ttf');
			$box->setFontColor(new Color(191, 191, 191));
			$box->setTextShadow(new Color(0, 0, 0), -2, -2);
			$box->setFontSize($tacgia_size);
			$box->setBox(120, -100, 360, 760);
			$box->setTextAlign('center', 'bottom');
			$box->draw($tacgia);
		}
	}

} elseif ($theloai == 'di_nang') {

	if ($tacpham_line == 0 || $tacpham_line == 1) {
		$tacpham_size = 80;
	} elseif ($tacpham_line == 2) {
		$tacpham_size = 72;
	} elseif ($tacpham_line == 3) {
		$tacpham_size = 65;
	} elseif ($tacpham_line == 4) {
		$tacpham_size = 55;
	} else {
		$tacpham_size = 45;
	}

	// tac pham
	$box = new Box($im);
	$box->setFontFace(__DIR__.'/font/than_chien_tranh.ttf');
	$box->setFontColor(new Color(153, 0, 0));
	$box->setStrokeColor(new Color(255, 255, 255));
	$box->setStrokeSize(2);
	$box->setFontSize($tacpham_size);
	$box->setLineHeight(0.8);
	$box->setBox(20, -150, 560, 800);
	$box->setTextAlign('center', 'bottom');
	$box->draw($tacpham);

	if (!empty($tacgia)) {
		// tac gia
		$box = new Box($im);
		$box->setFontFace(__DIR__.'/font/PatrickHandSC-Regular.ttf');
		$box->setFontColor(new Color(191, 191, 191));
		$box->setTextShadow(new Color(0, 0, 0), -2, -2);
		$box->setFontSize($tacgia_size);
		$box->setBox(120, 650, 360, 800);
		$box->setTextAlign('center', 'top');
		$box->draw($tacgia);
	}

} else { // con lai

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

	// tac pham
	$box = new Box($im);
	$box->setFontFace(__DIR__.'/font/'.random_array(array('buc_thu', 'fleur')).'.ttf');
	$box->setFontColor(new Color(0, 51, 102));
	//$box->setTextShadow(new Color(153, 0, 61), 2, 2);
	$box->setStrokeColor(new Color(242, 242, 242));
	$box->setStrokeSize(2);
	$box->setFontSize($tacpham_size);
	$box->setLineHeight(1.2);
	$box->setBox(20, 100, 560, 760);
	$box->setTextAlign('center', 'top');
	$box->draw($tacpham);

	if (!empty($tacgia)) {
		// tac gia
		$box = new Box($im);
		$box->setFontFace(__DIR__.'/font/ben_xuan.ttf');
		$box->setFontColor(new Color(230, 0, 92));
		$box->setFontSize($tacgia_size);
		$box->setBox(20, -100, 560, 760);
		$box->setTextAlign('center', 'bottom');
		$box->setStrokeColor(new Color(242, 242, 242));
		$box->setStrokeSize(2);
		$box->draw($tacgia);
	}

}

// logo
$box = new Box($im);
$box->setFontFace(__DIR__.'/font/old_stamper.ttf');
$box->setFontColor(new Color(102, 26, 0));
$box->setFontSize(18);
$box->setBox(-2, -2, 600, 800);
$box->setTextAlign('right', 'bottom');
$box->draw("tusach.org");

// in ra ảnh
header("Content-type: image/png");
imagepng($im);

/*hàm chức năng*/
function get_title($title, $mb = false) {
	$title = preg_replace('/[^A-Za-z0-9àáãạảăắằẳẵặâấầẩẫậèéẹẻẽêềếểễệđìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳỵỷỹýÀÁÃẠẢĂẮẰẲẴẶÂẤẦẨẪẬÈÉẸẺẼÊỀẾỂỄỆĐÌÍĨỈỊÒÓÕỌỎÔỐỒỔỖỘƠỚỜỞỠỢÙÚŨỤỦƯỨỪỬỮỰỲỴỶỸÝ]/u', ' ', $title);
	$title = preg_replace('/\s+/', ' ', $title);
	$title = preg_replace('/\s*(.*)\s*/', '$1', $title);
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