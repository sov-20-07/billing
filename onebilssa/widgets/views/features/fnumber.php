<tr>
	<td class="form_param"><?=$name?></td>
	<td class="form_field">
		<div class="b_relative_wrap">
			<input class="date input_text input_text_200" type="text" onfocus="$(this).next().show()" onblur="$(this).next().hide()" value="<?=$value?>" name="features[<?=$path?>]" onblur="checknumfloat(this)" />
			<div class="input_text_dropdown" onmouseover="$(this).prev().attr('onblur','')" onmouseout="$(this).prev().attr('onblur','$(this).next().hide()')" style="position:absolute;display:none;background: #FFFFFF;border:1px solid #999999;padding:3px;">
				<?foreach($select as $item):?>
					<a href="javascript:;" onclick="$(this).parent().prev().val($(this).text());$(this).parent().hide();"><?=$item?></a><br />
				<?endforeach?>
			</div>
			<input type="hidden" class="text" value="fnumber" name="featurestype[]">
			<input type="hidden" class="text" value="<?=$id?>" name="featuresid[]">
		</div>
	</td>
</tr>