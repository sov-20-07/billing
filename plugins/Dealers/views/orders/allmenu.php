<div class="ltRow">
	<div class="ltCell cell_page-orders_control-panel">
		<?foreach($statuses as $key=>$item):?>
			<?if($_GET['status']==$item['path'] || ($_GET['status']=='' && $item['path']=='new')):?>
				<a href="/<?=Funcs::$cdir?>/dealers/allorders/?status=<?=$item['path']?><?=$dealer?>" class="button-whitegreen active">
					<strong><?=$item['name']?></strong>
					<b><?=DealersOrders::getOrdersCountByStatus(null,$item['path'])?></b>
				</a>
			<?else:?>
				<a href="/<?=Funcs::$cdir?>/dealers/allorders/?status=<?=$item['path']?><?=$dealer?>" class="button-whitegreen">
					<strong><?=$item['name']?></strong>
					<?=DealersOrders::getOrdersCountByStatus(null,$item['path'])?>
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
					<form id="searchform">
						<select class="input_text" name="city" id="city_select">
							<option disabled selected>Город</option>
							<?foreach($city_list as $item):?>
								<option value="<?=$item['city']?>"><?=$item['city']?></option>
							<?endforeach?>
						</select>		
						<select class="input_text" name="dealer" id="dealer_select">
							<option disabled selected>Дилер</option>
							<?foreach($dealers_list as $item):?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?endforeach?>
						</select>
						<div class="input_text_label" >От&nbsp;
							<input type="text" name="from" class="input_text input_timepicker from_picker" value="<?=$_GET['from']?>" id="from"/>
						</div>						
						<div class="input_text_label">до&nbsp;
							<input type="text" name="to" class="input_text input_timepicker to_picker" value="<?=$_GET['to']?>" id="to"/>
						</div>
						<input type="hidden" name="status" value="<?=$_GET['status']?>" />
						<span class="button-white" id="searchbtn" >Найти</span>
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
		$('#searchbtn').click(function(){
			frm.settarget().submit();
		});
	})
	var frm = {
		target:'/<?=Funcs::$uri[0]?>/<?=Funcs::$uri[1]?>',
		submit:function(){
			//$('#searchform').submit();
			window.location.href = this.target;
		},
		settarget:function(){
			//frm.target =  ($.trim($('#dealer_select')) == '' ) ? '/allorders/?' : '/orders/?';
			//frm.target += ($.trim($('#city_select')) == '') ? 'city=' : '';

			var param = new Array;

			var dealer = $('#dealer_select').val();
			var city = $('#city_select').val();
			var from = $.trim($('#from').val());
			var to = $.trim($('#to').val());
			//alert('dealer '+dealer + ' city ' + city + 'from' + from + 'to' + to);
			if (city !== null) {        param.push('city='+city);}
			if ($.trim(from) !== '') {  param.push('from='+from);}
			if ($.trim(to) !== '') {    param.push('to='+to);}
			if (dealer === null) {
				this.target += '/allorders/';
			} else {
				this.target += '/orders/';
				param.push('id='+dealer);
			}	
			this.target += '?'+param.join('&');
			
			//alert(this.target);
			return this;
		}
	}
</script>
