<div class="ltRow">
	<div class="ltCell cell_page-orders_control-panel">
		<?foreach(Orders::$statuses as $key=>$item):?>
			<?if($_GET['status']==$item['path'] || ($_GET['status']=='' && $item['path']=='new')):?>
				<a href="/<?=Funcs::$cdir?>/orders/?status=<?=$item['path']?>" class="button-whitegreen active"><strong><?=$item['name']?></strong> <?=Orders::getOrdersListCountByStatus($item['path'])?></b></a>
			<?else:?>
				<a href="/<?=Funcs::$cdir?>/orders/?status=<?=$item['path']?>" class="button-whitegreen"><strong><?=$item['name']?></strong> <?=Orders::getOrdersListCountByStatus($item['path'])?></a>
			<?endif?>
		<?endforeach?>
	</div>
</div>
<div class="ltRow">
	<div class="ltCell cell_page-content_control-panel">		
		<a class="button-white" href="/<?=Funcs::$cdir?>/orders/add/<?=Orders::$nextOrderId?>/" onclick="if(confirm('Внимание будет создан новый заказ №<?=str_repeat('0',6-strlen(Orders::$nextOrderId)).Orders::$nextOrderId?>')){return true;}else{return false;}">Новый заказ</a>
		<a class="button-white" href="/<?=Funcs::$cdir?>/orders/market/">Отзывы на маркете (<?=Orders::getMarketListCount()?>)</a>
		<a class="button-white" href="/<?=Funcs::$cdir?>/orders/editstatus/">Статусы</a>
	</div>
</div>
<div class="ltRow">
	<div class="cell_page-content_control-panel">		
		<div class="jsTabs">
			<section class="onetabs">
				<header class="onetabs_links">
					<span class="jsTabsLink onetabs_link">Дополнительно</span>
					<span class="jsTabsLink onetabs_link">Статистика</span>
				</header>
			</section>
			<section class="jsTabsContent onetabs_content">
				<div class="jsTabsTab">
					<div class="onetabs_tab">
						<div class="clearfix">
							<div class="control-panel_inline">
								<header class="control-panel_inline_header">Выборка:</header>
								<form>
									От&nbsp; <div class="input_text_label widget_time"><input type="text" name="from" class="input_text" style="width:150px;" value="<?=$_GET['from']?>" /></div>
									до&nbsp; <div class="input_text_label widget_time"><input type="text" name="to" class="input_text" style="width:150px;" value="<?=$_GET['to']?>" /></div>
									<div class="input_text_label"><input type="text" name="number" placeholder="Номер заказа" class="input_text" value="<?=$_GET['number']?>" /></div>
									<div class="input_text_label"><input type="text" name="phone" placeholder="Телефон" class="input_text" value="<?=$_GET['phone']?>" /></div>
									<div class="input_text_label"><input type="text" name="fio" placeholder="ФИО" class="input_text" value="<?=$_GET['fio']?>" /></div>
									<input type="hidden" name="status" value="<?=$_GET['status']?>" />
									<span class="button-white"onClick="$(this).parent().submit();">Найти</span>
								</form>
							</div>
							<div class="control-panel_inline">
								<legend class="control-panel_inline_header">Экспорт:</legend>
								<a href="/<?=Funcs::$cdir?>/orders/export/<?=Funcs::getFG(NULL,'?');?>">Скачать файл</a> </br>
								<?/*?>
								<form method="POST" enctype="multipart/form-data" action="/<?=Funcs::$cdir?>/orders/export/<?=Funcs::getFG(NULL,'?');?>">
									<input type="file" name="upload" />
									<input type="submit" value="Загрузить" />
								</form>
								<?*/?>
							</div>
						</div>
					</div>					
				</div>
				<div class="jsTabsTab">
					<div class="onetabs_tab">
						<div class="clearfix">
							<div class="control-panel_inline">
								<header class="control-panel_inline_header">Статистика:</header>
								<a href="/<?=Funcs::$cdir?>/orders/statistic/month/">Продажи по месяцам</a>
							</div>
						</div>
					</div>		
				</div>
			</section>
		</div>
	</div>
</div>
<script>
	
</script>