<?
class Cards{
	public static $mrh_login="Fotobuka"; 
	public static $mrh_pass1="uh4ft6593h6tcn"; 
	public static $shp_item=1;
	public static function ToSessionCard(){
		Funcs::escapePost();
		$_SESSION['card']=array(
			'price'=>$_POST['nominal'],
			'title'=>$_POST['title'],
			'message'=>$_POST['message'],
		);
	}
	public static function SaveCard(){
		Funcs::escapePost();
		$tree=array('name'=>$_SESSION['card']['title']);
		$id=Tree::addTree(100,$tree,'cards');
		$sql='
			INSERT INTO {{catalog}}
			SET 
				tree='.$id.',
				description=\''.$_SESSION['card']['message'].'\',
				price='.$_SESSION['card']['price'].',
				vendor='.$_SESSION['iuser']['id'].'
		';
		DB::exec($sql);
		$mrh_login = Cards::$mrh_login; 
		$mrh_pass1 = Cards::$mrh_pass1; 
		$inv_id = $id; 
		$_SESSION['card']['id']=$id;
		$out_summ = $_SESSION['card']['price']; 
		$shp_item = Cards::$shp_item; 
		$inv_desc = "Подарочная карта, на сумму ".$_SESSION['card']['price']; 
		$in_curr = ""; 
		$culture = "ru"; 
		$encoding = "utf-8"; 
		$crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item");
		/*print "<html><script language=JavaScript ". 
			"src='https://merchant.roboxchange.com/Handler/MrchSumPreview.ashx?". 
			"MrchLogin=$mrh_login&OutSum=$out_summ&InvId=$inv_id&IncCurrLabel=$in_curr". 
			"&Desc=$inv_desc&SignatureValue=$crc&Shp_item=$shp_item". 
			"&Culture=$culture&Encoding=$encoding'></script></html>";*/
		print "<html><script>". 
			"document.location.href='http://test.robokassa.ru/index.aspx?". 
			"MrchLogin=$mrh_login&OutSum=$out_summ&InvId=$inv_id&IncCurrLabel=$in_curr". 
			"&Desc=$inv_desc&SignatureValue=$crc&Shp_item=$shp_item". 
			"&Culture=$culture&Encoding=$encoding';</script></html>";
		
		
		
	}
	public static function Success(){
		$mrh_login = Cards::$mrh_login; 
		$mrh_pass1 = Cards::$mrh_pass1; 
		$inv_id = $id; 
		$id=$_SESSION['card']['id'];
		$out_summ = $_SESSION['card']['price']; 
		$shp_item = Cards::$shp_item; 
		$crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item");
		if($crc==$_GET['SignatureValue']){
			$sql='
				UPDATE {{tree}}
				SET visible=1
				WHERE id='.$id.'
			';
			DB::exec($sql);
		}
	}
}
?>