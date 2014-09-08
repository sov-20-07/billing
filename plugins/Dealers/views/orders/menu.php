<?
$dealerId = $dealer['id'];
$dealer = (is_null($dealer))?'':'&id='.$dealer['id'];
?>
<div class="ltRow">
	<div class="ltCell cell_page-content_control-panel">
		<a href="/onemfssa/dealers/addorder/?id=<?=$dealerId?>" class="button button_add-element">Добавить заказ</a>
	</div>
</div>

<div class="ltRow">
	<div class="ltCell cell_page-orders_control-panel">
		<?foreach($statuses as $key=>$item):?>
			<?if($_GET['status']==$item['path'] || ($_GET['status']=='' && $item['path']=='new')):?>
				<a href="/<?=Funcs::$cdir?>/dealers/orders/?status=<?=$item['path']?><?=$dealer?>" class="button-whitegreen active">
					<strong><?=$item['name']?></strong>
					<b><?=DealersOrders::getOrdersCountByStatus($dealerId,$item['path'])?></b>
				</a>
			<?else:?>
				<a href="/<?=Funcs::$cdir?>/dealers/orders/?status=<?=$item['path']?><?=$dealer?>" class="button-whitegreen">
					<strong><?=$item['name']?></strong>
					<?=DealersOrders::getOrdersCountByStatus($dealerId,$item['path'])?>
				</a>
			<?endif?>
		<?endforeach?>
	</div>
</div>

<div class="ltRow">
	<div class="cell_page-content_control-panel">		
			<div class="clearfix">
				<div class="control-panel_inline">
					<header class="control-panel_inline_header">Выборка:</header>
					<form>
						<select class="input_text" name="city">
							<option disabled selected>Город</option>
							<?foreach($city_list as $item):?>
								<option value="<?=$item['city']?>"><?=$item['city']?></option>
							<?endforeach?>
						</select>		
						<div class="input_text_label" >От&nbsp;
							<input type="text" name="from" class="input_text input_timepicker from_picker" value="<?=$_GET['from']?>" />
						</div>						
						<div class="input_text_label">до&nbsp;
							<input type="text" name="to" class="input_text input_timepicker to_picker" value="<?=$_GET['to']?>" />
						</div>
						<input type="hidden" name="status" value="<?=$_GET['status']?>" />
						<span class="button-white"onClick="$(this).parent().submit();">Найти</span>
					</form>
				</div>
				<div class="control-panel_inline">
					<legend class="control-panel_inline_header">Экспорт:</legend>
					<a href="/<?=Funcs::$cdir?>/dealers/orders/export/<?=Funcs::getFG(NULL,'?');?>">Скачать файл</a> </br>
				</div>
			</div>		
	</div>
</div>
<script>
	$(document).ready(function(){
		var opts = ({ dateFormat: "dd.mm.yy" });
		$('.from_picker').datetimepicker(opts);
		$('.to_picker').datetimepicker(opts);
	})
</script>
