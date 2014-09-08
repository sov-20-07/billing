<?/*?>
<form method="post" action="http://oauth.klassica.ru/apitoken" id="submitForm">
	<input type="text" name="client_id" value="12141"> 
	<input type="text" name="client_secret" value="<?=base64_encode('w8s2987mqz')?>">
	<input type="text" name="grant_type" value="partner_token">
</form>
<button onclick="$('#submitForm').submit()">submit</button>
<?*/?>
<fieldset>
	<legend>Запрос на оплату покупки /api/payment/</legend>
	<form method="post" action="/api/payment/" id="orderForm">
		<input type="hidden" name="token" value="1b143fed33f7671ba9c4b958b48e102f17d9c8c6e48af4e37b3132291e15a39e">
		<input type="text" placeholder="request_id" name="request_id" value=""> 
		<input type="text" placeholder="user_id" name="user_id" value="">
		<input type="text" placeholder="amount" name="amount" value="">
		<input type="hidden" name="currency" value="RUB">
	</form>
	<button onclick="$('#orderForm').submit()">submit</button>
</fieldset>
<fieldset>
	<legend>Запрос на вывод средств /api/request/</legend>
	<form method="post" action="/api/request/" id="requestForm">
		<input type="hidden" name="token" value="1b143fed33f7671ba9c4b958b48e102f17d9c8c6e48af4e37b3132291e15a39e">
		<input type="text" placeholder="request_id" name="request_id" value=""> 
		<input type="text" placeholder="user_id" name="user_id" value="">
		<input type="text" placeholder="amount" name="amount" value="">
		<input type="hidden" name="currency" value="RUB">
	</form>
	<button onclick="$('#requestForm').submit()">submit</button>
</fieldset>