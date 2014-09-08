<?
class Cron{
	public static function Subscribe(){
		$sql='
			SELECT DISTINCT {{catalog}}.tree FROM {{catalog}} 
			INNER JOIN {{subscribers}} USING (tree)
			WHERE {{subscribers}}.sent_date=\'0000-00-00 00:00:00\' AND {{catalog}}.available=1
		';
		$ids=DB::getAll($sql,'tree');
		foreach($ids as $id){
			$sql='
				SELECT * FROM {{subscribers}}
				WHERE sent_date=\'0000-00-00 00:00:00\' AND tree='.$id.'
			';
			$subscribers=DB::getAll($sql);
			foreach($subscribers as $item){
				$data=Catalog::getOne($id);
				$data['user']=$item;
				$text=View::getRenderEmpty('email/subscribe',$data);
				$mail = new Email;
				$mail->Text($text);
				$mail->Subject('Появился товар на сайте www.'.str_replace('www.','',$_SERVER["HTTP_HOST"]));
				$mail->From('robot@'.str_replace('www.','',$_SERVER["HTTP_HOST"]));
				$mail->To($item['email']);
				$mail->Send();
			}
			$sql='
				UPDATE {{subscribers}}
				SET
					sent_date=CURRENT_TIMESTAMP()
				WHERE sent_date=\'0000-00-00 00:00:00\' AND tree='.$id.'
			';
			DB::exec($sql);
		}
	}
	public static function Report(){
		$sql='SELECT * FROM {{orders}} WHERE loyalty=1 AND sent=0';
		$list=DB::getAll($sql);
		foreach($list as $order){
			$sql='
				SELECT * FROM {{orders_items}}
				WHERE orders='.$order['id'].'
			';
			$items=DB::getAll($sql);
			$data=$order;
			foreach($items as $item){
				$temp=Tree::getInfo($item['tree']);
				if($temp['path']!='catalogopt'){
					$data['list'][]=Catalog::getOne($item['tree']);
				}
			}
			$text=View::getRenderEmpty('email/report',$data);
			$mail = new Email;
			$mail->Text($text);
			$mail->Subject('Оставьте отзыв о товаре на сайте www.'.str_replace('www.','',$_SERVER["HTTP_HOST"]));
			$mail->From('robot@'.str_replace('www.','',$_SERVER["HTTP_HOST"]));
			$mail->To($order['email']);
			$mail->Send();
			$sql='
				UPDATE {{orders}}
				SET	sent=1
				WHERE id='.$order['id'].'
			';
			DB::exec($sql);
		}
	}
	public static function Currency(){		
		$data=array();
		$CurrCBR=simplexml_load_file('http://www.cbr.ru/scripts/XML_daily.asp?date_req='.date("d.m.Y"));
		$date1=$CurrCBR['Date'];
		$data['date1']=date("Y-m-d",strtotime($CurrCBR['Date']));
		$Currency=array();
		$i=0;
		foreach($CurrCBR as $c){
			if($c->CharCode=='GBP')$c->Name='Фунт стерлингов СК';
			if($c->CharCode=='XDR')$c->Name='СДР';
			if($c->CharCode=='USD'){
				$Currency['USD1']=$c->Value;
			}elseif($c->CharCode=='EUR'){
				$Currency['EUR1']=$c->Value;
			}else{
				$Currency['CW'][$i]['Title']=$c->Name;
				$Currency['CW'][$i]['Value1']=$c->Value;
				$Currency['CW'][$i]['Nominal']=$c->Nominal;
				$i++;
			}			
		}
		$CurrCBR=simplexml_load_file('http://www.cbr.ru/scripts/XML_daily.asp');
		$date2=date("Y-m-d",strtotime($CurrCBR['Date']));
		if(date("Y-m-d",strtotime($date1))!=date("Y-m-d",strtotime($date2)))
			$data['date2']=date("Y-m-d",strtotime($CurrCBR['Date']));
		$i=0;
		foreach($CurrCBR as $c){
			if($c->CharCode=='USD'){
				if(date("Y-m-d",strtotime($date1))!=date("Y-m-d",strtotime($date2)))$Currency['USD2']=$c->Value;
			}elseif($c->CharCode=='EUR'){
				if(date("Y-m-d",strtotime($date1))!=date("Y-m-d",strtotime($date2)))$Currency['EUR2']=$c->Value;
			}else{
				if(date("Y-m-d",strtotime($date1))!=date("Y-m-d",strtotime($date2))){
					$Currency['CW'][$i]['Value2']=$c->Value;
					$Currency['CW'][$i]['ValueDif']=round(str_replace(',','.',$Currency['CW'][$i]['Value2'])-str_replace(',','.',$Currency['CW'][$i]['Value1']),4);
					if($Currency['CW'][$i]['ValueDif']>0)$Currency['CW'][$i]['ValueDif']='+'.str_replace('.',',',$Currency['CW'][$i]['ValueDif']);
				}
				$Currency['CW'][$i]['Value']='ЦБ '.$c->CharCode.' '.str_replace('.',',',$Currency['CW'][$i]['Value1']).' '.str_replace('.',',',$Currency['CW'][$i]['ValueDif']).' '.str_replace('.',',',$Currency['CW'][$i]['Value2']);
				$i++;
			}
		}
		if(date("Y-m-d",strtotime($date1))!=date("Y-m-d",strtotime($date2)))$Currency['USDDIF']=str_replace('.',',',round(str_replace(',','.',$Currency['USD2'])-str_replace(',','.',$Currency['USD1']),4));
		if(date("Y-m-d",strtotime($date1))!=date("Y-m-d",strtotime($date2)))$Currency['EURDIF']=str_replace('.',',',round(str_replace(',','.',$Currency['EUR2'])-str_replace(',','.',$Currency['EUR1']),4));
		if($Currency['USDDIF']>0)$Currency['USDDIF']='+'.str_replace('.',',',$Currency['USDDIF']);
		if($Currency['EURDIF']>0)$Currency['EURDIF']='+'.str_replace('.',',',$Currency['EURDIF']);
		$data['Curr']=$Currency;
		$sql='SELECT id FROM {{settings}} WHERE visible=1 AND path=\'currency\'';
		$parent=DB::getOne($sql);
		if(str_replace(',','.',$data['Curr']['USD1'])>0){
			$sql='
				UPDATE {{settings}} 
				SET value=\''.str_replace(',','.',$data['Curr']['USD1']).'\' 
				WHERE parent='.$parent.' AND path=\'USD\'
			';
			DB::exec($sql);
		}
		if(str_replace(',','.',$data['Curr']['EUR1'])>0){
			$sql='
				UPDATE {{settings}} 
				SET value=\''.str_replace(',','.',$data['Curr']['EUR1']).'\' 
				WHERE parent='.$parent.' AND path=\'EUR\'
			';
		}
		DB::exec($sql);
	}
	public static function run(){
		$date=array(
			date('i'),
			date('H'),
			date('d'),
			date('n'),
			date('w')==0?7:date('w')
		);
		$sql='SELECT * FROM {{cron}} WHERE visible=1 ORDER BY name';
		$items=DB::getAll($sql);
		foreach($items as $item){
			$timing=explode(' ',$item['timing']);
			$data=array();
			foreach($timing as $i=>$time){
				$time=str_replace('*',$date[$i],$time);
				$time=explode(',',$time);
				$data[]=$time;
			}
			$x=array(0,0,0,0,0);
			foreach($data as $i=>$datas){
				foreach($datas as $dat){
					eval('$temp='.$dat.';');
					if($date[$i]*1==$dat*1 || (strpos($dat,'/')!==false && is_int($temp)==true)){
						$x[$i]=1;
					}
				}
			}
			$xx=0;
			foreach($x as $xitem){
				if($xitem==1)$xx++;
			}
			if($xx==5){
				if(strpos($item['path'],'http://')===false){
					file_get_contents('http://'.$_SERVER['HTTP_HOST'].$item['path']);
				}else{
					file_get_contents($item['path']);
				}
				$sql='UPDATE {{cron}} SET mdate=NOW() WHERE id='.$item['id'];
				DB::exec($sql);
				print $item['path'].'<br>';
			}
		}
	}
}
?>