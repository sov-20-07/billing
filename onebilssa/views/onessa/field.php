<div class="OneSSADiv" data-id="<?=$id?>" data-field="<?=$field?>" >
	<a href="javascript:;" class="OneSSADivSave" onclick="OneSSASaveField($(this).parent())" title="Сохранить"></a>
	<a href="/<?=ONESSA_DIR?>/work/showedit/?id=<?=$tree?>" target="_blank" class="OneSSADivEdit" title="Редактировать"></a>
	<div class="OneSSADivContent" contenteditable="true">
		<?=$value?>
	</div>
</div>