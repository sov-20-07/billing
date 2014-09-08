<?
class DB{
	public static $sql;
	public static $count=0;
	public static $pdo;
	public function __construct(){
		DB::$pdo = new PDO('mysql:host='.BDHOST.';dbname='.BDNAME.'', BDLOGIN, BDPASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')); 
	}
	public function getOne($sql){
		$sql=DB::prefix($sql);
		try{
			$row=DB::$pdo->query($sql)->fetchColumn(0);
			if($row){
				return $row;
			}else{
				return '';
			}
		}catch(PDOException $e){
			print $e->getMessage();
			die(DB::error($sql,debug_backtrace()));
		}
	}
	public function getRow($sql){
		$sql=DB::prefix($sql);
		$row=DB::$pdo->query($sql);
		if($row){
			$row=$row->fetch(PDO::FETCH_ASSOC);
			if($row){
				return $row;
			}else{
				return '';
			}
		}else{
			die(DB::error($sql,debug_backtrace()));
		}
	}
	public function getAll($sql,$one=''){
		$data=array();
		$sql=DB::prefix($sql);
		$q=DB::$pdo->query($sql);
		if($q){
			$q=$q->fetchAll(PDO::FETCH_ASSOC);
			if(!empty($q)){
				foreach($q as $row){
					if($one==''){
						$data[]=$row;
					}else{
						$data[]=$row[$one];
					}
				}
				return $data;
			}else{
				return array();
			}
		}else{
			die(DB::error($sql,debug_backtrace()));
		}
	}
	public function getPagi($sql){
		$perpage=$_SESSION['user']['perpage'];
		$page=$_GET['p'];
		if($page=='')$page=1;
		$data=array();
		$sql=DB::prefix($sql);
		$sqlcount=substr($sql,strpos($sql,' FROM '),strlen($sql));
		$tab=substr($sqlcount,strpos($sqlcount,' ',1),strpos($sqlcount,' ',6)-1);
		if(strpos($sql,'SELECT DISTINCT')!==false){
			$sqlcount='SELECT COUNT(DISTINCT '.$tab.'.id) '.$sqlcount;
		}else{
			$sqlcount='SELECT count(*) '.$sqlcount;
		}
		if(class_exists(PaginationWidget))PaginationWidget::$count=DB::getOne($sqlcount);
		$sql=$sql.' LIMIT '.(($page-1)*$perpage).','.$perpage.'';
		$q=DB::$pdo->query($sql) or die(DB::error($sql,debug_backtrace()));
		foreach($q as $row){
			$data[]=$row;
		}
		return $data;
	}
	public function exec($sql){
		try{
			$sql=DB::prefix($sql,1);
			DB::$pdo->exec($sql);
			return DB::$pdo->lastInsertId();
		}catch(PDOException $e){
			print $e->getMessage();
			die(DB::error($sql,debug_backtrace()));
		}
	}
	public function prefix($sql,$exec=0){
		if(strpos($sql,'JOIN')!==false || strpos($sql,'ALTER TABLE')!==false){
			$sql=str_replace('{{',BDPREFIX,$sql);
			$sql=str_replace('}}','',$sql);
		}elseif(strpos($sql,'INSERT')!==false && strpos($sql,'SELECT')!==false){
			$sql=str_replace('{{',BDPREFIX,$sql);
			$sql=str_replace('}}','',$sql);
		}else{
			$sql=preg_replace(array('/{{/','/}}/'),array(BDPREFIX,''),$sql,1);
		}
		$site=$_SESSION['site'];
		if(Funcs::$uri[0]==ONESSA_DIR){
			$site=$_SESSION['OneSSA']['site'];
		}
		if($exec==0){
			if(strpos($sql,BDPREFIX.'tree')!==false && strpos($sql,BDPREFIX.'tree t ')===false){
				if(strpos($sql,'WHERE')!==false){
					$sql=str_replace('WHERE','WHERE '.BDPREFIX.'tree.site='.$site.' AND',$sql);
				}else{
					$sql=str_replace(BDPREFIX.'tree',BDPREFIX.'tree WHERE '.BDPREFIX.'tree.site='.$site.'',$sql);
				}
			}elseif(strpos($sql,BDPREFIX.'tree t ')!==false){
				if(strpos($sql,'WHERE')!==false){
					$sql=str_replace('WHERE','WHERE t.site='.$site.' AND',$sql);
				}
			}
		}
		DB::$sql=$sql;
		DB::$count++;
		return $sql;
	}
	public static function error($sql,$backtrace){
		print View::getRenderOneSSAEmpty('/site/error',array('sql'=>$sql,'backtrace'=>$backtrace,'PDO'=>DB::$pdo->errorInfo()));
	}
	public static function escapePost($notEscape=''){
		foreach($_POST as $key=>$value){
			if($key!=$notEscape){
				if(is_array($value)){
					foreach($value as $i=>$item){
						if(is_array($item)){
							foreach($item as $i2=>$item2){
								$value[$i][$i2]=str_replace('"','&quot;',str_replace("'","&#39;",htmlspecialchars(strip_tags(trim($item2)))));
							}
						}else{
							$value[$i] =str_replace('"','&quot;',str_replace("'","&#39;",htmlspecialchars(strip_tags(trim($item)))));
						}
					}
					$_POST[$key]=$value;
				}else{
					$_POST[$key] =str_replace('"','&quot;',str_replace("'","&#39;",htmlspecialchars(strip_tags(trim($value)))));
				}
			}else{
				if(is_array($value)){
					foreach($value as $i=>$item){
						if(is_array($item)){
							foreach($item as $i2=>$item2){
								$value[$i][$i2]=DB::$pdo->quote($item2);
							}
						}else{
							$value[$i]=DB::$pdo->quote($item);
						}
					}
					$_POST[$key]=$value;
				}else{
					$_POST[$key]=DB::$pdo->quote($value);
				}
			}
		}
	}
	public static function escapeGet($notEscape=''){
		foreach($_POST as $key=>$value){
			if($key!=$notEscape){
				if(is_array($value)){
					foreach($value as $i=>$item){
						if(is_array($item)){
							foreach($item as $i2=>$item2){
								$value[$i][$i2]=str_replace('"','&quot;',str_replace("'","&#39;",htmlspecialchars(strip_tags(trim($item2)))));
							}
						}else{
							$value[$i] =str_replace('"','&quot;',str_replace("'","&#39;",htmlspecialchars(strip_tags(trim($item)))));
						}
					}
					$_POST[$key]=$value;
				}else{
					$_POST[$key] =str_replace('"','&quot;',str_replace("'","&#39;",htmlspecialchars(strip_tags(trim($value)))));
				}
			}else{
				if(is_array($value)){
					foreach($value as $i=>$item){
						if(is_array($item)){
							foreach($item as $i2=>$item2){
								$value[$i][$i2]=DB::$pdo->quote($item2);
							}
						}else{
							$value[$i]=DB::$pdo->quote($item);
						}
					}
					$_POST[$key]=$value;
				}else{
					$_POST[$key]=DB::$pdo->quote($value);
				}
			}
		}
	}
}
?>