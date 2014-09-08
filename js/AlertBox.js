// JavaScript Document
/*
	Плагин MessageBox
	void AlertBox(int width, int height, string title, string text, string butText1, string path1, string butText2="", string path2="");
	Пример: AlertBox(300,150,'Заголовок','Тут сного текста','продолжить','close','перезагрузить','reload');
	Варианты path: URL, close, reload
*/
function AlertBox(widX,widY,title,text,but1,path1,but2,path2){
	var div='<div class="alert_box">'+
		'<div class="alert_box_transparent_layer"></div>'+
		'<div class="alert_box_window pop-up-block" style="width:'+widX+'px;height:'+widY+'px;">'+
			'<span class="alert_box_close close"></span>'+
			'<span class="alert_box_title">'+title+'</span>'+
			'<span class="alert_box_text">'+text+'</span>';
		div+='<div class="alert_box_center">';
		if(path1=='close'){
			path1="javascript:closeAlertBox()";
		}else if(path1=='reload'){
			path1='javascript:document.location.reload()';
		}
		if(but1=='продолжить'){
			div+='<a class="is_button continue-shopping-grey doted" style="margin-right:5px;text-decoration:none;" href="'+path1+'">'+but1+'</a>';
		}else{
			div+='<span class="alert_box_but1"><a class="is_button right_top_corner" href="'+path1+'">'+but1+'<span></span></a></span>';
		}
		if(path2=='close'){
			path2="javascript:closeAlertBox()";
		}else if(path2=='reload'){
			path2='javascript:document.location.reload()';
		}
		if(but2=='в отложенные'){
			div+='<a class="is_button deferred" href="'+path2+'">'+but2+'</a>';
		}else if(but2=='сравнить'){
			div+='<a class="is_button compare-green" href="'+path2+'">'+but2+'</a>';
		}else{
			div+='<span class="alert_box_but2"><a class="is_button  right_top_corner" href="'+path2+'">'+but2+'<span></span></a></span>';
		}
		div+='</div></div></div>';
	$(div).appendTo(document.body);
	$('.alert_box').show();
	$('.alert_box_close').click(function(){
		closeAlertBox();
	});
}
function closeAlertBox(){
	$('.alert_box').detach();
}