<div class="pop-up-block" >
    <div class="box">

		<h4>Товар добавлен в корзину</h4>
			
		
		<div class="form_dialog"></br>
			Вы добавили:
			<table class="basket-table">
				<tr>
					<td style="border: none;"><a href="<?=$path?>" target="_parent"><?=$name?></a></td>
					<td style="border: none;"><?=$price?><span class="rub">a</span></td>
				</tr>
			</table>	
				<div class="hr"></div>
				     Всего товаров в корзине: <?=$goods?><br/>
					 <b>На сумму: <?=$sum?><span class="rub">a</span></b>
				
		
			<div class="bottom_block" style="margin-top: 20px;text-align: center">
				<a href="javascript:;" onclick="closeme()" class="back_to continue-shopping-grey in-block">Продолжить покупки</a>
				<a href="javascript:;" onclick="goBasket()" class="is_button  go-to-basket">Перейти в корзину<span></span></a>
			</div>
		</div>
 </div>
</div>

<script>
	function goBasket(){
		window.parent.document.location.href="/basket/";
	}
</script>