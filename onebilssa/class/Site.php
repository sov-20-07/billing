<?
abstract class Site{
	public function checkRights(){
		if($_SESSION['user']['id']!='0'){
			if($_SESSION['user']['id']==''){
				$this->accessDenied();
			}else{
				$user=User::getInfo($_SESSION['user']['id']);
				$sql='
						UPDATE {{users}}
						SET ldate=NOW()
						WHERE id='.$_SESSION['user']['id'].'
				';
				DB::exec($sql);
				if($user['visible']==1 && $user['ticket']==session_id()){
					$x=0;
					if(array_key_exists(Funcs::$uri[1],OneSSA::$modulesStandart)){
						if(in_array(Funcs::$uri[1],$user['access']['modules'])){
							$x=1;
						}
						if($x==0){
							$this->pageDenied();
						}
					}elseif(isset($_REQUEST['tree']) || $_POST['tab']=='tree'){
						$tree=$_REQUEST['tree'];
						if(!is_numeric($tree))$tree=$_REQUEST['parent'];
						if($tree=='')$tree=$_POST['id'];
						$tree=Tree::getParents($tree);
						if(count($tree)==0)$x=1;
						foreach($user['access']['tree'] as $item){
							if(in_array($item,$tree)){
								$x=1;
							}
						}
						if($x==0){
							$this->pageDenied();
						}
					}
					
				}else{
					$this->accessDenied();
				}
			}
		}
	}
	public function accessDenied(){
		View::$layout='empty';
		View::render('site/login');
		die;
	}
	public function pageDenied(){
		View::$layout='empty';
		View::render('site/pagedenied');
		die;
	}
	public function redirect($uri){
		if(strpos($uri,'http://')!==false){
			header('Location: '.$uri);
		}else{
			if(Funcs::$uri[0]==ONESSA_DIR){
				header('Location: /'.ONESSA_DIR.$uri);
			}else{
				header('Location: '.Funcs::$path.$uri);
			}
		}
		die;
	}
	public function visible(){
		$this->checkRights();
		if($_POST['tab']=='tree'){
			$sql='SELECT visible FROM {{'.$_POST['tab'].'}} WHERE id='.$_POST['id'].'';
			$vis=DB::getOne($sql)==1?'0':'1';
			$ids=Tree::getChilds($_POST['id']);
			$ids[]=$_POST['id'];
			$sql='
				UPDATE {{'.$_POST['tab'].'}}
				SET visible='.$vis.'
				WHERE id IN ('.implode(',',$ids).')
			';
			DB::exec($sql);
		}else{
			$sql='
				UPDATE {{'.$_POST['tab'].'}}
				SET visible=IF(visible=1,0,1)
				WHERE id='.$_POST['id'].'
			';
			DB::exec($sql);
		}
	}
	public function search(){
		$this->checkRights();
		$sql='
			UPDATE {{'.$_POST['tab'].'}}
			SET search=IF(search=1,0,1)
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
	}
	public function menu(){
		$this->checkRights();
		$sql='
			UPDATE {{'.$_POST['tab'].'}}
			SET menu=IF(menu=1,0,1)
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
	}
	public function market(){
		$this->checkRights();
		$ids=Tree::getChilds($_POST['id']);
		$ids[]=$_POST['id'];
		$sql='
			UPDATE {{catalog}}
			SET market='.$_POST['on'].'
			WHERE tree IN ('.implode(',',$ids).')
		';
		DB::exec($sql);
	}
	public function sort(){
		foreach ($_POST['new_sort'] as $i=>$item){
			$item=substr($item,3,strlen($item));
			$k=0;
			if($_POST['page']>1){
				$k=($_POST['page']-1)*10*$_SESSION['user']['perpage'];
			}
			$sql='
				UPDATE {{'.$_POST['tab'].'}}
				SET num='.(($i+1)*10+$k).'
				WHERE id='.$item.'
			';
			DB::exec($sql);
		}
	}
	public function sortnum(){
		$sql='
			UPDATE {{'.$_POST['tab'].'}}
			SET num='.$_POST['num'].'
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
	}
	public function treemenu(){
		TreeWidget::ajax();
	}
	public function perpage(){
		$_SESSION['user']['perpage']=$_POST['new_kol'];
		if(strpos($_SERVER['HTTP_REFERER'],'module')!==false && strpos($_SERVER['HTTP_REFERER'],'fieldlist')!==false){
			header('Location:'.$_SERVER['HTTP_REFERER']);
		}else{
			header('Location:'.(strpos($_SERVER['HTTP_REFERER'],'?')!==false?substr($_SERVER['HTTP_REFERER'],0,strpos($_SERVER['HTTP_REFERER'],'?')):$_SERVER['HTTP_REFERER']));
		}
	}
	public function switchs(){
		$this->checkRights();
		$sql='
			UPDATE {{'.$_POST['tab'].'}}
			SET `'.$_POST['field'].'`=IF(`'.$_POST['field'].'`=1,0,1)
			WHERE id='.$_POST['id'].'
		';
		DB::exec($sql);
	}
	public function setuseroptions(){
		$sql='
			DELETE FROM {{user_options}}
			WHERE user='.$_SESSION['user']['id'].' AND tree='.$_POST['tree'].' AND name=\'table\'
		';
		DB::exec($sql);
		foreach($_POST['rows'] as $item){
			$sql='
				INSERT INTO {{user_options}}
				SET 
					user='.$_SESSION['user']['id'].',
					tree='.$_POST['tree'].',
					name=\'table\',
					value=\''.$item.'\'
			';
			DB::exec($sql);
		}
	}
	public function editstr(){
		$this->checkRights();
		DB::escapePost();
		if($_POST['tab']=='tree'){
			$where='id='.$_POST['tree'].'';
		}elseif($_POST['tab']=='catalog'){
			$where='tree='.$_POST['tree'].'';
		}else{
			$where='path=\''.trim($_POST['path']).'\' AND tree='.$_POST['tree'].'';
		}
		$sql='
			UPDATE {{'.$_POST['tab'].'}}
			SET `'.$_POST['field'].'`=\''.$_POST['value'].'\'
			WHERE '.$where.'
		';
		//print DB::prefix($sql,1);
		DB::exec($sql);
	}
}
?>