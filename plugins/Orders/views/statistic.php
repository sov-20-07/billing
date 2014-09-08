<?=View::getPluginEmpty('header')?>
<div class="standart_menu_slim">
	<?=View::getPluginEmpty('menu')?>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Дата', 'Сумма'],
				<?foreach($list as $Y=>$items):?>
					<?foreach($items as $m=>$item):?>
						['<?=$m?>.<?=$Y?>',  <?=$item['sum']?>],
					<?endforeach?>
				<?endforeach?>
			]);
			var options = {
				title: 'Статистика продаж по месяцам'
			};
			var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		}
	</script>
	<div id="chart_div" style="width: 900px; height: 500px;"></div>
	<h4>Сводная таблица</h4>
	<table class="goods">
		<tr>
			<?foreach($list as $Y=>$items):?>
				<?foreach($items as $m=>$item):?>
					<th><?=$m?>.<?=$Y?></th>
				<?endforeach?>
			<?endforeach?>
		</tr>
		<tr>
			<?foreach($list as $Y=>$items):?>
				<?foreach($items as $m=>$item):?>
					<td><?=number_format($item['sum'],0,',',' ')?> руб.</td>
				<?endforeach?>
			<?endforeach?>
		</tr>
	</table>
	<div class="gray_line_navigation">
		&nbsp;
	</div>
</div>