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

3. Y.Swetake 檔案下載處：
   http://www.swetake.com/qr/qr_cgi_e.html

4. 資料來源：
   http://blog.xuite.net/hankohya34/blog/58188192-%E5%9C%A8%E7%B6%B2%E9%A0%81%E4%B8%8A%E7%94%A2%E7%94%9FQRCode%E5%9C%96%E7%89%87+PHP%E7%89%88