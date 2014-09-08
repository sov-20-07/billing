<?
class DB{
	public static $sql;
	public static $count=0;
	public static $error=false;
	public function __construct(){
		@mysql_connect(BDHOST, BDLOGIN, BDPASS) or die('Can\'t connect to database');
		@mysql_select_db(BDNAME) or die('Can\'t find database name');
		@mysql_query('SET NAMES \'utf8\'');
	}
	public function getOne($sql,$exec=0){
		$sql=DB::prefix($sql,$exec);
		$result=mysql_query($sql) or die(DB::error($sql,debug_backtrace()));
		if(mysql_num_rows($result)>0){
			return mysql_result($result,0);
		}else{
			return '';
		}
	}
	public function getRow($sql,$exec=0){
		$sql=DB::prefix($sql,$exec);
		$result=mysql_query($sql) or die(DB::error($sql,debug_backtrace()));
		return mysql_fetch_assoc($result);
	}
	public function getAll($sql,$one='',$exec=0){
		$data=array();
		$sql=DB::prefix($sql,$exec);
		$q=mysql_query($sql) or die(DB::error($sql,debug_backtrace()));
		while($row=mysql_fetch_assoc($q)){
			if($one==''){
				$data[]=$row;
			}else{
				$data[]=$row[$one];
			}
		}
		return $data;
	}
	public function getPagi($sql,$exec=0){
		$perpage=0;
		if(Funcs::$OneSSA){
			$perpage=$_SESSION['user']['perpage'];
		}else{
			if($_SESSION['perpage'][end(Funcs::$uri)]){
				$perpage=$_SESSION['perpage'][end(Funcs::$uri)];
			}
			if($perpage==0){
				$perpage=$_SESSION['perpage'][reset(Funcs::$uri)];
			}
			if($perpage==0){
				$perpage=10;
			}
		}
		$page=$_GET['p'];
		if($page=='')$page=1;
		$data=array();
		$sql=DB::prefix($sql,$exec);
		$sqlcount=substr($sql,strpos($sql,' FROM '),strlen($sql));
		$tab=substr($sqlcount,strpos($sqlcount,' ',1),strpos($sqlcount,' ',6)-1);
		if(strpos($sql,'SELECT DISTINCT')!==false){
			$sqlcount='SELECT COUNT(DISTINCT '.$tab.'.id) '.$sqlcount;
		}else{
			$sqlcount='SELECT COUNT(*) '.$sqlcount;
		}
		if(strpos($sqlcount,'ORDER BY')!==false)$sqlcount=substr($sqlcount,0,strpos($sqlcount,'ORDER BY'));
		if(class_exists(PaginationWidget))PaginationWidget::$count=DB::getOne($sqlcount,1);
		$sql=$sql.' LIMIT '.(($page-1)*$perpage).','.$perpage.'';
		$q=mysql_query($sql) or die('<b>Ошибка в SQL-запросе:</b> '.$sql);
		while($row=mysql_fetch_assoc($q)){
			$data[]=$row;
		}
		return $data;
	}
	public function exec($sql){
		$sql=DB::prefix($sql,1);
		mysql_query($sql) or die(DB::error($sql,debug_backtrace()));
		return mysql_insert_id();
	}
	public function prefix($sql,$exec=0){
		if(strpos($sql,'JOIN')!==false || strpos($sql,'ALTER TABLE')!==false){
			$sql=str_replace('{{',BDPREFIX,$sql);
			$sql=str_replace('}}','',$sql);
		}elseif(strpos($sql,'INSERT')!==false && strpos($sql,'SELECT')!==false){
			$sql=str_replace('{{',BDPREFIX,$sql);
			$sql=str_replace('}}','',$sql);
		}elseif(strpos($sql,'DELETE')!==false && strpos($sql,'SELECT')!==false){
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
		if(DEBUG==0 && Funcs::$uri[0]!=ONESSA_DIR){
			header("HTTP/1.0 404 Not Found");
			DB::$error=true;
			View::$layout='main';
			View::render('site/error404');
		}elseif(DEBUG!=0 && Funcs::$uri[0]!=ONESSA_DIR){
			header("HTTP/1.0 404 Not Found");
			print View::getRenderEmpty('site/error',array('sql'=>$sql,'backtrace'=>$backtrace));
		}else{
			print View::getRenderOneSSAEmpty('site/error',array('sql'=>$sql,'backtrace'=>$backtrace));
		}
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
								$value[$i][$i2]=mysql_real_escape_string($item2);
							}
						}else{
							$value[$i]=mysql_real_escape_string($item);
						}
					}
					$_POST[$key]=$value;
				}else{
					$_POST[$key]=mysql_real_escape_string($value);
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
								$value[$i][$i2]=mysql_real_escape_string($item2);
							}
						}else{
							$value[$i]=mysql_real_escape_string($item);
						}
					}
					$_POST[$key]=$value;
				}else{
					$_POST[$key]=mysql_real_escape_string($value);
				}
			}
		}
	}
}
?>