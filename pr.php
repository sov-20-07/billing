<?
$mails=array('unv@one-touch.ru', 'svv@one-touch.ru');
mysql_connect('dedi3142.your-server.de', 'dvrgroup', 'yVUVR5K5') or die('Can\'t connect to database');
mysql_select_db('dvrgroup') or die('Can\'t find database name');
mysql_query('SET NAMES \'utf8\'');
mb_internal_encoding('UTF-8');

mysql_query('update one_catalog set oldpr=price where oldpr=\'\'');

$data=array();
$q=mysql_query('select \'Dvr-group.ru\' as site, one_tree.name, one_catalog.price, one_catalog.oldpr from one_catalog inner join one_tree on (one_tree.id=one_catalog.tree) where one_catalog.price<>one_catalog.oldpr');
while($row=mysql_fetch_assoc($q)){
		$data[]=$row;
	
}
$txt='<table border="0" cellspacing="0" style="border: 1px solid #000000;"><tr><td style="border: 1px solid #000000;">'.iconv('utf8', 'koi8-r','Сайт').'</td><td style="border: 1px solid #000000;">'.iconv('utf8', 'koi8-r','Товар').'</td><td style="border: 1px solid #000000;">'.iconv('utf8', 'koi8-r','Старая цена').'</td><td style="border: 1px solid #000000;">'.iconv('utf8', 'koi8-r','Новая цена').'</td></tr>';
foreach ($data as $dt){
$txt.='<tr><td style="border: 1px solid #000000;">'.iconv('utf8', 'koi8-r',$dt['site']).'</td><td style="border: 1px solid #000000;">'.iconv('utf8', 'koi8-r',$dt['name']).'</td><td style="border: 1px solid #000000;">'.iconv('utf8', 'koi8-r',$dt['oldpr']).'</td><td style="border: 1px solid #000000;">'.iconv('utf8', 'koi8-r',$dt['price']).'</td></tr>';
}
$txt.='</table>';
mysql_query('update one_catalog set oldpr=price');
if(count($data)>0){
$theme=iconv('utf8', 'cp1251','Список измененных цен с сайта dvr-group.ru');
//$theme="Список измененных цен с сайта dvr-group.ru";
$message='<html><head></head><body>';
$message.=$txt;
$message.='</body></html>';
$headers="Content-Type: text/html; charset=UTF8\r\n";
$headers.="From: <robot@dvr-group.ru>\r\n";
foreach($mails as $to){
mail($to, $theme, $message, $headers);
}
}
?>