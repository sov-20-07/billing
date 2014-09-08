<div class="fixed_width" id="content">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::LeftMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1"><?=$name?></div>
		<?=$fulltext?>
		<div class="forum">
			<table class="default messages fcategories">
				<col width="270"><col><col width="70">
				<tr>
					<th>Форум</th>
					<th>Последнее сообщение</th>
					<th>Сообщения</th>
				</tr>
				<?foreach($list as $items):?>
					<tr><td colspan="4" class="category_name"><div class="head2"><a href="<?=$items['path']?>"><?=$items['name']?></a></div></td></tr>
					<?foreach($items['list'] as $item):?>
						<tr>
							<td><a href="<?=$item['path']?>"><?=$item['name']?></a></td>
							<td>
								<?if($item['count']!=0):?>
									<?=$item['author']['name']?>
									<div class="date_time"><?=$item['cdatewide']?></div>
								<?endif?>
							</td>
							<td><a href="<?=$item['path']?>" class="icon ic_message auto_icon light_gray"><?=$item['count']?></a></td>
						</tr>
					<?endforeach?>
				<?endforeach?>			
			</table>
		</div>
		<?PaginationWidget::run()?>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>