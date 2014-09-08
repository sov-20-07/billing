<?if(count($viewed)>0):?>
	<div class="hr" style="margin-bottom: 16px;"></div>
	<div style="position: relative;">
		<h3>Просмотренные</h3>
		<?if(count($viewed)>1):?><a href="javascript:;" class="showmore" onclick="$('#vtopbody').toggle();">показать больше</a><?endif?>
	</div>
	<table class="v-top">
	<?foreach($viewed as $i=>$items):?>
		<?if($i==2):?><tbody style="display:none;" id="vtopbody"><?endif?>
		<tr>
		<?foreach($items as $item):?>
			<td><?=View::getRenderEmpty('catalog/listmodelsmall',$item)?></td>
		<?endforeach?>
		</tr>
		<?if($i==count($viewed)-1 && $i>2):?></tbody><?endif?>
	<?endforeach?>
	</table>
<?endif?>