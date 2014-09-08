$(document).ready(function(){
	$('.addTree').click(function(){
		if($('.holder'+$(this).attr('ids')).html().length>0){
			$('.holder'+$(this).attr('ids')).find(".elemform").detach();
		}else{
			$(".treeform").clone().appendTo($('.holder'+$(this).attr('ids'))).show().removeClass('treeform').addClass('elemform');
			$('.holder'+$(this).attr('ids')).find(".elemform input[name=parent]").val($(this).attr('ids'));
			$('.holder'+$(this).attr('ids')).find(".elemform form").attr('action',$(".treeform form").attr('action')+'add/');
		}
	});
	$('.editTree').click(function(){
		if($('.holder'+$(this).attr('ids')).html().length>0){
			$('.holder'+$(this).attr('ids')).find(".elemform").detach();
		}else{
			$(".treeform").clone().appendTo($('.holder'+$(this).attr('ids'))).show().removeClass('treeform').addClass('elemform');
			$('.holder'+$(this).attr('ids')).find(".elemform input[name=id]").val($(this).attr('ids'));
			$('.holder'+$(this).attr('ids')).find(".elemform input[name=name]").val($(this).attr('names'));
			$('.holder'+$(this).attr('ids')).find(".elemform input[name=path]").val($(this).attr('path'));
			$('.holder'+$(this).attr('ids')).find(".elemform form").attr('action',$(".treeform form").attr('action')+'edit/');
		}
	});
	$('.visible').click(function(){
		if(confirm('Внимание! Видимость объекта и всех наследуемых элементов будет изменена')){
			if($(this).hasClass('active')){
				$(this).removeClass('active');
			}else{
				$(this).addClass('active');
			};
			$.ajax({
				type: "POST",
				url: onessapath+"tree/visible/",
				data: "id="+$(this).attr('ids')+"&tab="+$(this).attr('tab'),
				success: function(msg){}
			});
		}
	});
	$('.menu').click(function(){
		if($(this).hasClass('active')){
			$(this).removeClass('active');
		}else{
			$(this).addClass('active');
		};
		$.ajax({
			type: "POST",
			url: onessapath+"tree/menu/",
			data: "id="+$(this).attr('ids')+"&tab="+$(this).attr('tab'),
			success: function(msg){}
		});
	});
	$('.search').click(function(){
		if($(this).hasClass('active')){
			$(this).removeClass('active');
		}else{
			$(this).addClass('active');
		};
		$.ajax({
			type: "POST",
			url: onessapath+"tree/search/",
			data: "id="+$(this).attr('ids')+"&tab="+$(this).attr('tab'),
			success: function(msg){}
		});
	});
	$('.market').click(function(){
		var on;
		var text;
		if($(this).hasClass('act')){
			text='удалены из маркета';
		}else{
			text='добавлены в маркет';
		};
		if(confirm('Внимание! Объект и все наследуемые элементы будут '+text)){
			if($(this).hasClass('act')){
				on=0;
				$(this).removeClass('act');
			}else{
				on=1;
				$(this).addClass('act');
			};
			$.ajax({
				type: "POST",
				url: onessapath+"tree/market/",
				data: "id="+$(this).attr('ids')+"&on="+on,
				success: function(msg){
	
				}
			});
		}
	});
	/*$('.sortTree').click(function(){
		if($('.holder'+$(this).attr('ids')).html().length>0){
			$('.holder'+$(this).attr('ids')).find(".elemform").detach();
		}else{
			var id=$(this).attr('ids');
			$.ajax({
				type: "POST",
				url: onessapath+"tree/getsort/",
				data: "id="+id+"&tab="+$(this).attr('tab'),
				success: function(msg){
					$(".treesort").html(msg);
					$(".treesort").clone().appendTo($('.holder'+id)).show().removeClass('treesort').addClass('elemform');
					$(".treesort").html('');
					//defineSort();
				}
			});
		}
	});*/
	//$(".spisok").tablesorter();
	$("#show_lang_list").click(function(){
		$(".lang_list").slideToggle();
	});		 
	$(".lang_close").click(function(){
		$(".lang_list").slideToggle();
	});
	var editableTimeout;
	var editableClick=0;
	$(".editable").click(function(){
		if(editableClick!=1){
			editableClick=1;
			var ahref=$(this).attr("href");
			if(ahref.indexOf('undefined')==-1){
				editableTimeout=setTimeout(function(){document.location.href=ahref;},300);
			}
		}
		return false;
	});
	$(".editable").dblclick(function(){
		editableClick=0;
		clearTimeout(editableTimeout);
		$(this).hide().next().show().focus();
	});
	$(".editstr").blur(function(){
		$(this).hide().prev().show().text($(this).val());
		var data="field="+$(this).attr('field');
		data+="&tree="+$(this).attr('tree');
		if($(this).attr('path')!='undefined'){
			data+="&path="+$(this).attr('path');
		}
		data+="&tab="+$(this).attr('tab');
		data+="&value="+$(this).val();
		$.ajax({
			type: "POST",
			url: onessapath+"tree/editstr/",
			data: data,
			success: function(msg){

			}
		});
	});
});
function clearCache(id){
	var data="tab=tree";
	data+="&id="+id;
	$.ajax({
		type: "POST",
		url: onessapath+"cache/",
		data: data,
		success: function(msg){
			alert('Кэш сброшен');
		}
	});
}
function defineSort(what){
	var rows;
	var data;
	var tab;
	if(what=='jsMoveContainerTR'){
		$('.jsMoveContainerTR tr').each(function(){
			data+="new_sort[]="+$(this).attr('id')+"&";
		});
		data+="tab="+$('.jsMoveContainerTR').attr('tab')+"&page="+$('.jsMoveContainerTR').attr('page');
		tab=$('.jsMoveContainerTR').attr('tab');
		$.ajax({
			type: "POST",
			url: onessapath+"tree/sort/",
			data: data,
			success: function(msg){
				if(tab!=='data'){
					document.location.reload();
				}
			}
		});
	}else if(what=='jsMoveContainerLI_inner'){
		$('.jsMoveContainerTR tr').each(function(){
			data+="new_sort[]="+$(this).attr('id')+"&";
		});
		data+="tab="+$('.jsMoveContainerTR').attr('tab')+"&page="+$('.jsMoveContainerTR').attr('page');
		tab=$('.jsMoveContainerLI').attr('tab');
	}
}
function defineSortNum(id,tab,num){
	var data="tab="+tab+"&num="+num+"&id="+id;
	$.ajax({
		type: "POST",
		url: onessapath+"tree/sortnum/",
		data: data,
		success: function(msg){
			document.location.reload();
		}
	});
}
function defineSortFeatures(){
	$("#featuresset").tableDnD({
		onDragClass: "dragRow",
		onDrop: function(table, row) {
			var rows = table.tBodies[0].rows;
		 }
	});
}
function switchs(obj,tab,field,id){
	if(obj.text()=="Да"){
		obj.text("Нет");
	}else{
		obj.text("Да");
	};
	$.ajax({
		type: "POST",
		url: onessapath+"tree/switchs/",
		data: "id="+id+"&tab="+tab+"&field="+field,
		success: function(msg){

		}
	});
}
function keypressMe(obj){
	obj.parent().parent().parent().find(".sethere").attr("name","data["+obj.val()+"]");
}
function selectMe(obj){
	obj.parent().prev().val(obj.text());
	keypressMe(obj.parent().prev());
	obj.parent().hide();
}
function keypressEditor(obj){
	obj.parent().parent().parent().find(".sethere").attr("name","data["+obj.val()+"]");
}
function selectEditor(obj){
	obj.parent().prev().val(obj.text());
	obj.parent().next().find(".sethere").attr("name","data["+obj.text()+"]");
	obj.parent().hide();
}
function checknumfloat(obj) {
	var anum=/(^\d+$)|(^\d+\.\d+$)/;
	if (anum.test(obj.value)) {
		return true;
	}
	obj.value=0;
	return false;
}
function checknumint(obj) {
	var anum=/(^\d+$)/;
	if (anum.test(obj.value)) {
		return true;
	}
	obj.value=0;
	return false;
}
function treemenuClick(id){
	var obj=$("#tmc"+id).parent().parent();
	if(obj.hasClass('jsOpened')){
		obj.find('ul').slideUp('400', 'easeInOutQuart', function() {
			obj.find('ul').detach();
		});
	}else{
		$.ajax({
			type: "POST",
			url: onessapath+"tree/treemenu/",
			data: "id="+id,
			success: function(msg){
				resizeContent();
				obj.append(msg);
				catalogPadding(10);
			}
		});
	}
}