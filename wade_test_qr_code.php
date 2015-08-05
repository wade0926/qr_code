<?php
require_once('func/qr_code/qr_img.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>QR Code</title>
</head>
<body style="background-color:#CCC">
<?php
//========== 測試用物品明細 op ==========
//物品1
$goods_info[0]['name'] = '測試物品A(袋)'; 
$goods_info[0]['quantity'] = '1';
$goods_info[0]['price'] = '30';

//物品2
$goods_info[1]['name'] = '牛奶(盒)';
$goods_info[1]['quantity'] = '3';
$goods_info[1]['price'] = '42';

//物品3
$goods_info[2]['name'] = '洋芋片(包)';
$goods_info[2]['quantity'] = '2';
$goods_info[2]['price'] = '39';

//算總價
foreach($goods_info as $row)
{
	$total_price += $row['quantity'] * $row['price'];
}
//========== 測試用物品明細 ed ==========

//1. 發票字軌 (10位)：記錄發票完整十碼號碼。
$invoice_id = 'AB11223311';
//$invoice_id = 'XA74213178';

//2. 發票開立日期 (7位)：記錄發票三碼民國年、二碼月份、二碼日期。
$time = '1040724';

//3. 隨機碼 (4位)：記錄發票上隨機碼四碼。
$randon_code = '2339';

//4. 銷售額 (8位)：記錄發票上未稅之金額總計八碼，將金額轉換以十六進位方式記載。若營業人銷售系統無法順利將稅項分離計算，則以00000000記載。
$total_price_no_tax = '00000000';

//5. 總計額 (8位)：記錄發票上含稅總金額總計八碼，將金額轉換以十六進位方式記載。
$total_price = dechex($total_price);

//總計額如果少於8 碼，補0
if(strlen($total_price) < 8)
{
	$fill_zero_amount = 8 - strlen($total_price);
	
	for($i = 1;$i <= $fill_zero_amount;$i++)
	{	
		$fill_zero_str .= '0';		
	}
	
	$total_price = $fill_zero_str.$total_price;	
}

//6. 買方統一編號 (8位)：記錄發票上買受人統一編號，若買受人為一般消費者則以 00000000記載。
$buyer_id = '00000000';

//7. 賣方統一編號 (8位)：記錄發票上賣方統一編號。
$seller_id = '80535765';  //買對統編

//8. 加密驗證資訊 (24位)：將發票字軌十碼及隨機碼四碼以字串方式合併後使用 AES 加密並採用 Base64 編碼轉換。
$encrypt_data = aes_encryption($invoice_id.$randon_code,aes_key);  //需加密金鑰(暫無)

//先把固定的77個位元組起來
$set_77 = $invoice_id.$time.$randon_code.$total_price_no_tax.$total_price.$buyer_id.$seller_id.$encrypt_data;

//設定左邊QR Code 初始值
$left_code_data = $set_77;

//========== 左邊的QR Code，除了固定的77 位元和商品資訊外的額外資訊 op ==========
//9. 營業人自行使用區 (10位)：提供營業人自行放置所需資訊，若不使用則以10個"*"符號呈現。
$left_extra_info['free_area'] = '**********';

//10.二維條碼記載完整品目筆數：記錄左右兩個二維條碼記載消費品目筆數，以十進位方式記載。
$left_extra_info['valid_record_amount'] = 3;  //暫用一個固定數字

//11.該張發票交易品目總筆數：記錄該張發票記載總消費品目筆數，以十進位方式記載。
$left_extra_info['total_record_amount'] = count($goods_info);

//12.中文編碼參數 (1位)：定義後續資訊的編碼規格
$left_extra_info['chinese_coding_type'] = 1;

foreach($left_extra_info as $row)
{
	$left_code_data .= ':'.$row;
}
//========== 左邊的QR Code，除了固定的77 位元和商品資訊外的額外資訊 ed ==========

//設定右邊QR Code 初始值
$right_code_data = '**';

$i = 1;

//把QR Code放入物品明細
foreach($goods_info as $row)
{
	foreach($row as $row_detail)
	{
		//替換掉英文冒號成中文的冒號(英文冒號在此為格式用法，故不可當內容用)
		$row_detail = str_replace(':','：',$row_detail);
				
		//(7-11 的做法很像是左邊最多放兩項商品名細)
		if($i <= 2)
		{
			$left_code_data .= ':'.$row_detail;
		}
		else
		{
			$right_code_data .= ':'.$row_detail;
		}	
	}	
	
	$i++;
}

//左邊QR Code
$left_qr_code = generate_qr_code($left_code_data);

//右邊QR Code
$right_qr_code = generate_qr_code($right_code_data);
?>
<div style="margin-top:120px;text-align:center;">
	<span>
    	<img src="<?php echo $left_qr_code;?>" width="160" height="160" />
    </span>
    
    <span style="margin-left:40px;">
    	<img src="<?php echo $right_qr_code;?>" width="160" height="160" />
    </span>	    
</div>

</body>
</html>