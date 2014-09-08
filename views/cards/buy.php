<div class="fixed_width" id="content">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::LeftMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1">Покупка подарочной карты</div>
		<form class="buy_card" id="oneform" method="post">
			<div id="error" style="display:none" class="form_error"></div>
			<table class="default">
				<colgroup><col width="99"><col></colgroup><tbody>
				<tr>
					<td class="param_name">Сумма</td>
					<td><input mincard="500" type5="number" class="text required" title="сумма" name="nominal"> руб.</td>
				</tr>
				<tr>
					<td class="param_name">Заголовок</td>
					<td><input onkeyup="typer($(this))" onclick="typer($(this))" onchange="typer($(this))" ml="30" type5="string" class="text required" title="заголовок" name="title" style="width:290px"></td>
				</tr>
				<tr>
					<td class="param_name">Сообщение</td>
					<td><textarea onkeyup="typer($(this))" onclick="typer($(this))" onchange="typer($(this))" ml="150" rows="6" name="message" class="required"></textarea></td>
				</tr>
				<tr>
					<td class="param_name" colspan="2">
						<span onclick="checkoneform()" class="is_button right_top_corner">Продолжить<span></span></span>
					</td>
				</tr>
				<tr><td colspa="2"><div id="typer"></div></td></tr>
			</tbody></table>
		</form>
		<script>
			function checkoneform(){
				var f=0;
				$('#oneform .required').each(function(){
					if (jQuery.trim($(this).val())==''){
						$(this).css('border','solid 1px red');
						f=1;
					}else{
						$(this).css('border','');
					}
				});
				if(f==1){
					 return false;
				}else{
					$('#oneform').submit();
				}
			}
			function typer(obj){
				var num=(obj.attr('ml')*1-obj.val().length);
				if(num<0){
					obj.val(obj.val().substr(0,obj.attr('ml')*1));
					num=(obj.attr('ml')*1-obj.val().length);
				}
				$('#typer').text('Осталось символов: '+num);
			}
		</script>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>