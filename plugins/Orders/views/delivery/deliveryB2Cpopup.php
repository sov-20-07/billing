<h3>Формирование запроса к B2C</h3>
<?if($_GET['act']!='send'):?>
	<a href="?act=send&id=<?=$_GET['id']?>&type=<?=$_GET['type']?>&deliveryprice=<?=$_GET['deliveryprice']?>">Сформировать запрос</a>
<?else:?>
	<div id="postal">
	<?foreach(Delivery::$postal as $key=>$item):?>
		<?if($postal[$key]):?>
			<b><?=$item?> </b><?if(strpos($postal[$key],'http://')!==false):?><a href="<?=$postal[$key]?>" target="_blank"><?=$postal[$key]?></a><?else:?><?=$postal[$key]?><?endif?><br />
		<?endif?>
	<?endforeach?>
	</div>
	<a href="javascript:;" onclick="sendpostal()">Сохранить изменения</a>
	<script>
		function sendpostal(){
			window.parent.document.getElementById('postal').innerHTML=document.getElementById('postal').innerHTML;
			window.parent.hs.close();
		}
	</script>
<?endif?>