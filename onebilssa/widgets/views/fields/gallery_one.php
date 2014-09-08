<li class="gallery_item clearfix" ids="<?=$file['id']?>">
	<figure class="gallery_img_layout">
		<span class="icon_publish visible <?if($file['visible']==1):?>active<?endif?>" tab="files" ids="<?=$file['id']?>"></span>
		<span class="icon_remove" onclick="if(confirm('Удалить файл?'))removeFile<?=$parent?>($(this),<?=$file['id']?>)"></span>
		<?if($file['mime']=='image'):?>
			<a href="<?=$file['path']?>" class="gallery_img_link" onclick="return hs.expand(this, galleryOptions)"><img src="/of<?=$file['path']?>?h=100&w=100&c=1" class="gallery_img" alt=""></a>
		<?else:?>
			<a href="<?=$file['path']?>" class="gallery_img_link" target="_blank"><img src="/<?=Funcs::$cdir?>/i/icons/ic_<?=$file['file']['raz']?>.gif" class="gallery_img" alt=""></a>
		<?endif?>
	</figure>
	<div class="gallery_description">
		<table class="gallery_description_table">
			<tr>
				<td>Название</td>
				<td><div class="input_text_holder"><input type="text" class="input_text" value="<?=$file['name']?>" id="name<?=$file['id']?>" onblur="editFile<?=$parent?>(<?=$file['id']?>)"></div></td>
			</tr>
			<tr>
				<td>Описание</td>
				<td><div class="input_text_holder"><input type="text" class="input_text" value="<?=$file['dop']?>" id="dop<?=$file['id']?>" onblur="editFile<?=$parent?>(<?=$file['id']?>)"></div></td>
			</tr>
		</table>
	</div>
	<span class="icon_move jsMoveDragInner"></span>
</li>