<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>QR Code</title>
</head>
1. 圖片轉換成php echo 顯示出來：
   http://davidwalsh.name/data-uri-php
   ----------
   $image = 'http://s01.calm9.com/qrcode/2015-08/NTRX3PYRLN.png';
   $imageData = base64_encode(file_get_contents($image));
   $src = 'data: '.mime_content_type($image).';base64,'.$imageData;
   echo '<img src="',$src,'">';
</html>