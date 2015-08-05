1. 圖片轉換成php echo 顯示出來：
   http://davidwalsh.name/data-uri-php
   ----------
   $image = 'http://s01.calm9.com/qrcode/2015-08/NTRX3PYRLN.png';
   $imageData = base64_encode(file_get_contents($image));
   $src = 'data: '.mime_content_type($image).';base64,'.$imageData;
   echo '<img src="',$src,'">';

2. 圖片轉成base64 傳遞：
   http://stackoverflow.com/questions/3695077/php-html-image-output
   (Andrew 回答那個)
