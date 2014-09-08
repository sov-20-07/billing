<?if($list[0]['parent']!=2):?>
	<div class="option_block installations <?if($act==1):?>act<?endif?>">
		<div class="head sliding" id="opt4">Тип установки<span class="icon down_arrow2 <?if($act==1):?>up_arrow2<?endif?>"></span></div>
		<div class="padds sliding_opt4">
		<?foreach($list as $item):?>
			<label><input type="checkbox" value="<?=$item['id']?>" onchange="getOpt('in',this,'cb');" <?if(in_array($item['id'],is_array($_GET['in'])?$_GET['in']:array())):?>checked<?endif?> /><?=$item['name']?></label>
		<?endforeach?>
		</div>
	</div>
<?endif?>