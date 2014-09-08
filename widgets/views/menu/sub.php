<div class="subsection">
	<?if(count($list)>0):?>
		<table class="default">
			<col width="50%"><col>
			<tr>
				<?foreach($list as $items):?>
				<td>
					<ul class="type3">
					<?foreach($items as $item):?>
						<?if($item['selected']):?>
							<li><b class="is_dark"><?=$item['name']?></b></li>
						<?else:?>
							<li><a href="<?=$item['path']?>"><?=$item['name']?></a></li>
						<?endif?>
					<?endforeach?>
					</ul>
				</td>
				<?endforeach?>
			</tr>
		</table>
	<?endif?>
</div>
