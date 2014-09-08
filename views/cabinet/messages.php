<div class="fixed_width" id="content">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::CabinetMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1">Сообщения</div>
		<table class="default messages">
			<colgroup><col><col width="100%"><col></colgroup><tbody>
			<?foreach($list as $item):?>
				<tr>
					<td class="upic"><a href="/user/<?=$item['user']?>/"><img src="<?=$item['avatar']?>"></a></td>
					<td>
						<?if($item['direction']=='touser'):?>кому<?else:?>от<?endif?>
						<a href="/user/<?=$item['user']?>/"><?=$item['name']?></a><br />
						<?=Extra::getDate($item['cdate'])?><br />
						<a href="/cabinet/messages/<?=$item['user']?>/"><?=$item['message']?></a>
					</td>
					<td>
						<?if($item['direction']=='touser'):?>
							<a href="/cabinet/messages/<?=$item['user']?>/"><img src="/i/ic_up.jpg" title="исходящий" /></a>
						<?else:?>
							<a href="/cabinet/messages/<?=$item['user']?>/"><img src="/i/ic_down.jpg" title="входящий" /></a>
						<?endif?>
						<?/*?><a href="?dm=11"  onclick="return confirm('Действительно удалить?') " class="icon ic_delete" title="Удалить"></a><?*/?>
					</td>
				</tr>
			<?endforeach?>
		</tbody></table>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>