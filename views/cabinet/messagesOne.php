<div class="fixed_width" id="content">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::CabinetMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1">Сообщения</div>
		<a href="/cabinet/message/" class="icon back_to auto_icon">Вернуться</a>
		<table class="default messages">
			<colgroup><col><col width="100%"><col></colgroup><tbody>
			<tr class="no_bord">
				<td class="upic"><a href="/user/<?=$user['id']?>/"><img src="<?=$user['avatar']?>"></td>
				<td>
					<a href="/user/<?=$user['id']?>/"><?=$user['name']?></a><br />
				</td>
			</tr>
		</tbody></table>
		<div class="head2">История сообщений</div>				
		<table class="default messages">
			<colgroup><col><col width="100%"><col></colgroup><tbody>
			<?foreach($list as $item):?>
				<tr>
					<td><nobr><?=Extra::getDate($item['cdate'])?></nobr></td>
					<td>
						<?if($item['direction']=='touser'):?>
							<img src="/i/ic_up.jpg" title="исходящий" />
						<?else:?>
							<img src="/i/ic_down.jpg" title="входящий" />
						<?endif?>
						<span class="standart"><?=nl2br($item['message'])?></span>
					</td>
					<td><a href="javascript:;"  onclick="return AlertBox(200,100,'Подтверждение','Действительно удалить?','Да','?del=<?=$item['id']?>','Нет','close'); " class="icon ic_delete" title="Удалить"></a></td>
				</tr>
			<?endforeach?>							
			<tr class="your_answer">
				<td colspan="3">
					<div class="is_black">Ваш ответ</div>
					<form action="" method="post" id="ans">
						<textarea id="txt" rows="6" name="message"></textarea>
						<input type="hidden" name="to" value="34"/>
						<span onclick="if (jQuery.trim($('#txt').val())==''){$('#txt').css('border','1px solid #FF0000');return false;}else{$('#txt').css('border','');$('#ans').submit();}" class="is_button right_top_corner span">Отправить<span></span></span>
					</form>
				</td>
			</tr>
		</tbody></table>
		<a href="/cabinet/message/" class="icon back_to auto_icon">Вернуться</a>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>

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
							<img src="/i/ic_up.jpg" title="исходящий" />
						<?else:?>
							<img src="/i/ic_down.jpg" title="входящий" />
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