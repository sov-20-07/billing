<?
class Codes{
	public static $type=array('sale'=>'Промо-код на скидку','bonus'=>'Промо-код на бонус','amount'=>'Промо-код на баланс','status'=>'Промо-код на статус');
	function getIndexTypes(){
		$data=array();
		$sql='SELECT * FROM {{codes_type}} ORDER BY cdate DESC';
		$list=DB::getPagi($sql);
		foreach($list as $item){
			$sql='SELECT COUNT(*) FROM {{codes}} WHERE ctype='.$item['id'];
			$item['count']=DB::getOne($sql);
			$sql='SELECT COUNT(*) FROM {{codes}} WHERE ctype='.$item['id'].' AND iuser<>\'\'';
			$item['used']=DB::getOne($sql);
			$data[]=$item;
		}
		return $data;
	}
	function getCodes($parent){
		$data=array();
		$sql='SELECT * FROM {{codes}} WHERE ctype='.$parent.' ORDER BY edate DESC';
		$list=DB::getPagi($sql);
		foreach($list as $item){
			$sql='SELECT name FROM {{iusers}} WHERE id='.$item['iuser'].'';
			$item['iuser']=DB::getOne($sql);
			$data[]=$item;
		}
		return $data;
	}
	function getType($id){
		$sql='SELECT * FROM {{codes_type}} WHERE id='.$id.'';
		return DB::getRow($sql);
	}
	public static function editCode(){
		$sql='
			UPDATE {{codes}}
			SET code=\''.$_POST['code'].'\'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
	}
	public static function delCode(){
		$sql='DELETE FROM {{codes}} WHERE id='.$_GET['id'].'';
		DB::exec($sql);
	}
	public static function editCodesType(){
		DB::escapePost();
		if(!$_POST['multiple']){
			$sql='
				UPDATE {{codes_type}}
				SET name=\''.$_POST['name'].'\',
					fromdate=\''.date('Y-m-d H:i:01',strtotime($_POST['fromdate'])).'\',
					todate=\''.date('Y-m-d H:i:01',strtotime($_POST['todate'])).'\',
					name=\''.$_POST['name'].'\',
					ctype=\''.$_POST['type'].'\',
					value=\''.$_POST['value'].'\',
					comment=\''.$_POST['comment'].'\'
				WHERE id='.$_POST['id'].'
			';
			//print DB::prefix($sql).'<br>';
			$id=DB::exec($sql);
			for($i=0;$i<$_POST['num'];$i++){
				$code=Codes::generateCode();
				$sql='
					INSERT INTO {{codes}}
					SET ctype='.$id.',
						code=\''.$code.'\'						
				';
				//print DB::prefix($sql).'<br>';
				DB::exec($sql);
			}
			//die;
		}else{
			$sql='
				UPDATE {{codes_type}}
				SET name=\''.$_POST['name'].'\',
					fromdate=\''.date('Y-m-d H:i:01',strtotime($_POST['fromdate'])).'\',
					todate=\''.date('Y-m-d H:i:01',strtotime($_POST['todate'])).'\',
					ctype=\''.$_POST['type'].'\',
					code=\''.$_POST['code'].'\',
					value=\''.$_POST['value'].'\',
					num=\''.$_POST['num'].'\',
					comment=\''.$_POST['comment'].'\'
				WHERE id='.$_POST['id'].'
			';
			$id=DB::exec($sql);
		}
	}
	public static function addCodesType(){
		DB::escapePost();
		if(!$_POST['multiple']){
			$sql='
				INSERT INTO {{codes_type}}
				SET name=\''.$_POST['name'].'\',
					fromdate=\''.date('Y-m-d H:i:01',strtotime($_POST['fromdate'])).'\',
					todate=\''.date('Y-m-d H:i:01',strtotime($_POST['todate'])).'\',
					ctype=\''.$_POST['type'].'\',
					value=\''.$_POST['value'].'\',
					comment=\''.$_POST['comment'].'\',
					cdate=NOW(),
					author=\''.$_SESSION['user']['login'].' '.$_SESSION['user']['name'].'\',
					visible=1
			';
			//print DB::prefix($sql).'<br>';
			$id=DB::exec($sql);
			for($i=0;$i<$_POST['num'];$i++){
				$code=Codes::generateCode();
				$sql='
					INSERT INTO {{codes}}
					SET ctype='.$id.',
						code=\''.$code.'\'						
				';
				//print DB::prefix($sql).'<br>';
				DB::exec($sql);
			}
			//die;
		}else{
			$sql='
				INSERT INTO {{codes_type}}
				SET name=\''.$_POST['name'].'\',
					fromdate=\''.date('Y-m-d H:i:01',strtotime($_POST['fromdate'])).'\',
					todate=\''.date('Y-m-d H:i:01',strtotime($_POST['todate'])).'\',
					ctype=\''.$_POST['type'].'\',
					code=\''.$_POST['code'].'\',
					value=\''.$_POST['value'].'\',
					num=\''.$_POST['num'].'\',
					comment=\''.$_POST['comment'].'\',
					cdate=NOW(),
					author=\''.$_SESSION['user']['login'].' '.$_SESSION['user']['name'].'\',
					visible=1
			';
			$id=DB::exec($sql);
		}
	}
	public static function delCodesType(){
		$sql='DELETE FROM {{codes}} WHERE ctype='.$_GET['id'].'';
		DB::exec($sql);
		$sql='DELETE FROM {{codes_type}} WHERE id='.$_GET['id'].'';
		DB::exec($sql);
	}
	public static function setStatus($code,$iuser){
		$sql='
			SELECT {{codes_type}}.* FROM {{codes}}
			INNER JOIN {{codes_type}} ON {{codes_type}}.id={{codes}}.ctype
			WHERE {{codes}}.code=\''.$code.'\' AND iuser=0
		';
		$data=DB::getRow($sql);
		if($data){
			$data['code']=$code;
			if($data['fromdate']<date('Y-m-d H:i:s') && date('Y-m-d H:i:s')<$data['todate']){
				$data['code']=$code;
				$data['multiple']=true;
				Codes::saveStatus($code,$iuser,$data);
			}else{
				$data['code']='';
				$data['error']='Время для использования кода истекло';
			}
		}else{
			$sql='
				SELECT * FROM {{codes_type}}
				WHERE code=\''.$code.'\'
			';
			$data=DB::getRow($sql);
			if($data){
				$sql='
					SELECT COUNT(*) FROM {{codes}}
					WHERE ctype=\''.$data['id'].'\'
				';
				$count=DB::getOne($sql);
				if($data['num']>$count){
					$sql='
						SELECT id FROM {{codes}}
						WHERE ctype=\''.$data['id'].'\' AND iuser='.$iuser.'
					';
					$id=DB::getOne($sql);
					if($id){
						$data['code']='';
						$data['error']='Вы уже использовали данный код';
					}else{
						if($data['fromdate']<date('Y-m-d H:i:s') && date('Y-m-d H:i:s')<$data['todate']){
							$data['code']=$code;
							$data['multiple']=true;
							Codes::saveStatus($code,$iuser,$data);
						}else{
							$data['code']='';
							$data['error']='Время для использования кода истекло';
						}
					}
				}else{
					$data['code']='';
					$data['error']='Данный код активирован максимальное количество раз';
				}
			}else{
				$data['code']='';
				$data['error']='Такого промо-кода не существует';
			}
		}
		return $data;
	}
	public static function saveStatus($code,$iuser,$data){
		if(!$data['multiple']){
			$sql='
				UPDATE {{codes}}
				SET edate=NOW(),
					iuser='.$iuser.'
				WHERE code=\''.$code.'\'
			';
			DB::exec($sql);
			
		}else{
			$sql='
				INSERT INTO {{codes}}
				SET edate=NOW(),
					ctype='.$data['id'].',
					iuser='.$iuser.',
					code=\''.$code.'\'
			';
			DB::exec($sql);
		}
		$sql='
			UPDATE {{iusers_options}}
			SET status='.$data['value'].'
			WHERE iuser=\''.$iuser.'\'
		';
		DB::exec($sql);
		return true;
	}
	public static function getSale($code,$iuser=0){
		$sql='
			SELECT {{codes_type}}.* FROM {{codes}}
			INNER JOIN {{codes_type}} ON {{codes_type}}.id={{codes}}.ctype
			WHERE {{codes}}.code=\''.$code.'\' AND iuser=0
		';
		$data=DB::getRow($sql);
		if($data){
			$data['code']=$code;
			if($data['fromdate']<date('Y-m-d H:i:s') && date('Y-m-d H:i:s')<$data['todate']){
				$data['code']=$code;
			}else{
				$data='';
				$data['error']='Время для использования кода истекло';
			}
		}else{
			$sql='
				SELECT * FROM {{codes_type}}
				WHERE code=\''.$code.'\'
			';
			$data=DB::getRow($sql);
			if($data){
				$sql='
					SELECT COUNT(*) FROM {{codes}}
					WHERE ctype=\''.$data['id'].'\'
				';
				$count=DB::getOne($sql);
				if($data['num']>$count){
					if($data['fromdate']<date('Y-m-d H:i:s') && date('Y-m-d H:i:s')<$data['todate']){
						$sql='SELECT id FROM {{codes}} WHERE ctype=\''.$data['id'].'\' AND iuser='.$iuser.'';
						$iusercheck=DB::getOne($sql);
						if($iusercheck && $iuser!=0){
							$data='';
							$data['error']='Вы уже использовали этот код';
						}else{
							$data['code']=$code;
							$data['multiple']=true;
						}						
					}else{
						$data='';
						$data['error']='Время для использования кода истекло';
					}
				}else{
					$data='';
					$data['error']='Данный код активирован максимальное количество раз';
				}
			}else{
				$data='';
				$data['error']='Такого промо-кода не существует';
			}
		}
		return $data;
	}
	public static function setSale($code,$iuser,$multiple){
		if(!$multiple){
			$sql='
				UPDATE {{codes}}
				SET edate=NOW(),
					iuser='.$iuser.'
				WHERE code=\''.$code.'\'
			';
			DB::exec($sql);
		}else{
			$sql='
				SELECT id FROM {{codes_type}}
				WHERE code=\''.$code.'\'
			';
			$id=DB::getOne($sql);
			$sql='
				INSERT INTO {{codes}}
				SET ctype='.$id.',
					code=\''.$code.'\',
					edate=NOW(),
					iuser='.$iuser.'
			';
			DB::exec($sql);
		}
		//print DB::prefix($sql);die;
	}
	public static function generateCode(){  
		$arr = array('A','B','C','D','E','F','G','H','J','K','L','M','N','P','R','S','T','U','V','X','Y','Z','1','2','3','4','5','6','7','8','9');  
	    $code = "";  
	    for($i = 0; $i < 10; $i++){
	      $index = rand(0, count($arr) - 1);  
	      $code .= $arr[$index];  
	    }
	    return $code;
	}
}
?>