<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Добавить в корзину</title>
    <link href="/css/main.css" rel="stylesheet" type="text/css">
    <link href="/css/popup.css" rel="stylesheet" type="text/css">
    <!--[if lte IE 7]><link rel="stylesheet" type="text/css" href="/css/ie7.css"><![endif]--> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="/js/popup_common.js" type="text/javascript"></script>
</head>
<body>    
	<div class="body_back dim1"><div class="pop_basket">
        <!-- товар добавлен в корзину -->
		<div class="add_basket_finished">
            <div class="popup">
                <span class="popup_icon ic_close" title="Закрыть"></span>
                <div class="header"><b>Товар добавлен</b></div>
                Товар добавлен в корзину.
                <div class="font_14"><a href="/basket/" class="next_arrow" target="_parent">Оформить заказ</a></div>
                <div class="font_14"><a href="javascript:;" class="next_arrow close_win">Продолжить просмотр каталога</a></div>
                <div class="button_pos"><div class="button_block"><div class="button_padd"><span class="popup_button close_win">Закрыть</span></div></div></div>
            </div>    	
        </div>        
        <!-- /товар добавлен в корзину -->
        <script>
        	$('.add_basket_finished').show();
        	$("#goods", top.document).text("<?=$goods?>");
			$("#sum", top.document).text("<?=$sum?>");
        </script> 
    </div></div>
</body>
</html>