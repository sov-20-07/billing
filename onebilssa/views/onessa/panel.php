<style>
	.OneSSAPanel{background: none repeat scroll 0 0 #F6F6F6;border: 1px solid #DDE0D3;height: 30px;padding: 10px;width: 100%;}
	.OneSSALogo{margin: 2px 20px 0 0;display: inline-block;float:left;}
	.OneSSADiv{border: 2px solid #ccc; padding: 5px; margin: -7px; position: relative;}
	.OneSSADivEdit{width: 15px;height:15px;background: url("/<?=ONESSA_DIR?>/i/icons.png") repeat scroll -73px -140px rgba(0, 0, 0, 0);
		position: absolute;right:1px;top:17px;display:block;padding-top: 0}
	.OneSSADivSave{width: 15px;height:15px;background: url("/<?=ONESSA_DIR?>/i/icons.png") repeat scroll -75px -156px rgba(0, 0, 0, 0);
		position: absolute;right:1px;top: 1px;display:block;padding-top: 0}
	.OneSSAPanelOnOff{width: 32px;height:14px;float:left;border:1px solid #666;cursor:pointer;margin-left:12px;margin-top:8px;border-radius:3px;}
	.OneSSAPanelOnOff div{width: 12px;height:12px;border:1px solid #666;background: #888;}
	.OneSSAPanelOnOff.Off{box-shadow: inset 0 0 6px;}
	.OneSSAPanelOnOff.On{box-shadow: inset 0 0 6px;background: #99FF99}
	.OneSSAPanelOnOff.On div{margin-left: 18px;}
	.OneSSAEditorPanel{position: absolute;left:210px;top:12px;}
	.OneSSAEditorButton{width: 28px;height:28px;display:block;float:left;background: url("/<?=ONESSA_DIR?>/i/editoricons.png") no-repeat;
		cursor:pointer;border:1px solid transparent;}
	.OneSSAEditorButton:hover{border:1px solid #AAA;border-radius:4px;}
	.OneSSAEditorButton.Clear{background-position: 6px -1650px;}
	.OneSSAEditorButton.Bold{background-position: 6px -18px;}
	.OneSSAEditorButton.Italic{background-position: 6px -42px;}
	.OneSSAEditorButton.Underline{background-position: 6px -138px;}
	.OneSSAEditorButton.Strike{background-position: 6px -66px;}
	.OneSSAEditorButton.Subpscript{background-position: 6px -90px;}
	.OneSSAEditorButton.Supscript{background-position: 6px -114px;}
	.OneSSAEditorButton.Insertlink{background-position: 6px -1218px;}
</style>
<script>
	$(document).ready(function(){
		var OneSSAPanelOnOffDiv=$('.OneSSAPanelOnOff div');
		var OneSSAPanelOnOff=$('.OneSSAPanelOnOff');
		OneSSAPanelOnOff.click(function(){
			if($(this).hasClass('Off')){
				OneSSAPanelOnOffDiv.animate({marginLeft:'18px'},600,"linear", function(){
					OneSSAPanelOnOff.removeClass('Off').addClass('On');
					document.location.href="/<?=ONESSA_DIR?>/panel/on/";
				});
			}else{
				OneSSAPanelOnOffDiv.animate({marginLeft:'0px'},600,"linear", function(){
					OneSSAPanelOnOff.addClass('Off').removeClass('On');
					document.location.href="/<?=ONESSA_DIR?>/panel/on/";
				});
			}
		});
		
	});
	function OneSSASaveField(obj){
		$('#OneSSAEditorForm input[name=OneSSAEditorFieldId]').val($(obj).attr('data-id'));
		$('#OneSSAEditorForm input[name=OneSSAEditorFieldField]').val($(obj).attr('data-field'));
		$('#OneSSAEditorForm textarea[name=OneSSAEditorFieldValue]').val($(obj).find('div').html());
		var data=$('#OneSSAEditorForm').serialize();
		$.ajax({
			type: "POST",
			url: "/<?=ONESSA_DIR?>/panel/save/",
			data: data,
			success: function(msg){
				alert('Сохранено успешно!')
			}
		});
	}
	function OneSSAEditorAction(type){
		range=window.getSelection().getRangeAt(0);
		var newNode='';
		switch (type) {
	        case "bold": newNode=document.createElement("b"); break
	        case "italic": newNode=document.createElement("i"); break
	        case "underline": newNode=document.createElement("u"); break
	        case "strike": newNode=document.createElement("strike"); break
	        case "supscript": newNode=document.createElement("sup"); break
	        case "subscript": newNode=document.createElement("sub"); break
	        <?/*?>
	        case "alignleft": txt = '<div style="text-align: left;">' + txt + '</div>'; break
	        case "aligncenter": txt = '<div style="text-align: center;">' + txt + '</div>'; break
	        case "alignright": txt = '<div style="text-align: right;">' + txt + '</div>'; break
	        case "alignjustify": txt = '<div style="text-align: justify;">' + txt + '</div>'; break
	        case "ol": txt = '<ol>' + txt + '</ol>'; break
	        case "ul": txt = '<ul>' + txt + '</ul>'; break
			<?*/?>
	        case "insertlink": insertlink = prompt("Введите ссылку:");newNode=document.createElement("a");newNode.href=insertlink; break
	        <?/*?>
	        case "insertimage": insertimage = prompt("Enter image URL:", "http://"); if ((insertimage != null) && (insertimage != "")) {txt = '<img src="' + insertimage + '">'; } break
	        case 'insertvideo': insertvideo = prompt("Enter video URL:", "http://"); if ((insertvideo != null) && (insertvideo != "")) {txt = '<object type="application/x-shockwave-flash" data="' + insertvideo + '" width="640" height="385"><param name="movie" value="' + insertvideo + '" /></object>';} break
			<?*/?>
	    }
	    if(type=='clear'){
	    	var regex = /(<([^>]+)>)/ig;
	    	var txt=range.toString().replace(regex, "");
	    	range.deleteContents();
	    	range.insertNode(document.createTextNode(txt));
	    }else{
	    	range.surroundContents(newNode);
	    }
	}
</script>
<form id="OneSSAEditorForm" style="display:none"><input type="hidden" name="OneSSAEditorFieldId"><input type="hidden" name="OneSSAEditorFieldField"><textarea name="OneSSAEditorFieldValue"></textarea></form>
<div class="OneSSAPanel">
	<a class="OneSSALogo" href="/<?=ONESSA_DIR?>/"><img alt="oneSSA" src="/<?=ONESSA_DIR?>/i/onessa_logo.png"></a>
	<?if($_SESSION['user']['panel']['edit']==''):?>
		<div class="OneSSAPanelOnOff Off" title="Включить редактирование"><div></div></div>
	<?else:?>
		<div class="OneSSAPanelOnOff On" title="Выключить редактирование"><div></div></div>
		<div class="OneSSAEditorPanel">
			<span class="OneSSAEditorButton Clear" onmousedown="OneSSAEditorAction('clear')" title="Убрать форматирование"></span>
			<span class="OneSSAEditorButton Bold" onmousedown="OneSSAEditorAction('bold')" title="Жирный"></span>
			<span class="OneSSAEditorButton Italic" onmousedown="OneSSAEditorAction('italic')" title="Курсив"></span>
			<span class="OneSSAEditorButton Underline" onmousedown="OneSSAEditorAction('underline')" title="Подчеркнутый"></span>
			<span class="OneSSAEditorButton Strike" onmousedown="OneSSAEditorAction('strike')" title="Зачеркнутый"></span>
			<span class="OneSSAEditorButton Subpscript" onmousedown="OneSSAEditorAction('subscript')" title="Подстрочный индекс"></span>
			<span class="OneSSAEditorButton Supscript" onmousedown="OneSSAEditorAction('supscript')" title="Надстрочный индекс"></span>
			<span class="OneSSAEditorButton Insertlink" onmousedown="OneSSAEditorAction('insertlink')" title="Добавить ссылку"></span>
		</div>
	<?endif?>
</div>