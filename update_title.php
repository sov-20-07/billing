<?
include_once ('settings.php');

$sql = 'SELECT * FROM one_tree WHERE parent = 294';
$result = mysql_query($sql) or die ();
while($row = mysql_fetch_assoc($result))
{
	$models[] = $row;
}

foreach ($models as $model)
{	
	$sql = 'UPDATE one_tree SET seo_title=\'Экшн-камера '.$model['name'].'. Каталог с ценами, описанием, отзывами, техническими характеристиками\',
	seo_keywords=\''.$model['name'].', купить, цена, продажа, интернет магазин\',
	seo_description=\''.$model['name'].' с бесплатной доставкой в интернет-магазине автомобильный электроники dvr-group.ru.\' WHERE id='.$model['id'];
	mysql_query($sql) or die (mysql_error());
	echo $sql;
	echo '<br>';
}

?>