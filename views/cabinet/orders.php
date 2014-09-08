<div class="right-block-content" >
	<h1><?=$name?></h1>
	<div style="width: 200px;" class="select">
		<div class="select-val"><?if($_GET['status']):?><?=Funcs::$reference['status'][$_GET['status']]['name']?><?else:?>Все<?endif?></div>
		<input type="hidden" value="">
		<div class="select-list" style="display: none;">
			<ul>
				<li onclick="document.location.href='/cabinet/order/'">Все</li>
				<?foreach(Funcs::$reference['status'] as $key=>$item):?>
					<li onclick="document.location.href='?status=<?=$key?>'"><?=$item['name']?></li>
				<?endforeach?>
			</ul>
		</div>
	</div>
	<table class="cabinet" style="margin-top: 20px;">
		<thead><th nowrap>№ заказа</th><th>Дата</th><th>Сумма</th><th>Оплата</th><th>Доставка</th><th>Статус</th><th></th></thead>
		<?foreach($list as $item):?>
			<tr>
				<td><?=str_repeat('0',6-strlen($item['id'])).$item['id']?></td>
				<td nowrap><?=date("d.m.Y H:i",strtotime($item['cdate']))?></td>
				<td nowrap><?=number_format($item['price'],0,',',' ')?><span class="rub">a</span></td>
				<td><?=$item['payment']?></td>
				<td><?=$item['delivery']?></td>
				<td><b><?=Funcs::$reference['status'][$item['status']]['name']?></b></td>
				<td><a href="/cabinet/orders/<?=$item['id']?>/">подробнее</a></td>
			</tr>
		<?endforeach?>
	</table>
</div>
<div class="left-block-content">
	<div class="left-content">
		<div class="logined">
			Здравствуйте,<br/>
			<b style="font-size: 15px;"><?=$_SESSION['iuser']['name']?></b><br/>
			<a href="/registration/logout/" class="exit"></a>
		</div>
		<?MenuWidget::CabinetMenu();?>
	</div>
</div>