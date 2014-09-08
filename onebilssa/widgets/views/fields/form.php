<li class="edit_form_section edit_form_section_other edit_form_section_row">
	<?=View::widget('fields/addtd')?>
	<table class="edit_form_table">
		<tr>
			<td>
				Форма:
			</td>
			<td>
				<?=$form?>
				<input type="hidden" class="text" value="<?=$value?>" name="data[]">
				<input type="hidden" class="text" value="<?=$type?>" name="fieldtypes[]">
			</td>
		</tr>
	</table>
</li>