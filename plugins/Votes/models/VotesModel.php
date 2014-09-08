<?
class Votes{
	public static function getList(){
		$data=array();
		$site=$_SESSION['site'];
		if(Funcs::$uri[0]==ONESSA_DIR) $site=$_SESSION['OneSSA']['site'];
		$sql='SELECT id FROM {{votes}} WHERE parent=0 AND site='.$site.' ORDER BY num';
		$list=DB::GetAll($sql,'id');
		foreach($list as $item){
			$data[]=Votes::getOne($item);
		}
		return $data;
	}
	public static function getOne($id){
		$site=$_SESSION['site'];
		if(Funcs::$uri[0]==ONESSA_DIR) $site=$_SESSION['OneSSA']['site'];
		$sql='SELECT * FROM {{votes}} WHERE id='.$id.' AND site='.$site.'';
		$data=DB::GetRow($sql);
		$sql='SELECT * FROM {{votes}} WHERE parent='.$id.' AND site='.$site.' ORDER BY num';
		$list=DB::GetAll($sql);
		$sum=0;
		foreach($list as $item){
			$sum+=$item['answers'];
		}
		foreach($list as $i=>$item){
			if($sum!=0){
				$item['width']=round($item['answers']/$sum*100);
			}else{
				$item['width']=0;
			}
			$data['list'][]=$item;
		}
		return $data;
	}
	public static function add(){
		$site=$_SESSION['site'];
		if(Funcs::$uri[0]==ONESSA_DIR) $site=$_SESSION['OneSSA']['site'];
		$sql='UPDATE {{votes}} SET num=num+10';
		DB::exec($sql);
		$sql='
			INSERT INTO {{votes}}
			SET description=\''.$_POST['description'].'\',
				num=10,
				visible=1,
				cdate=NOW(),
				author=\''.$_SESSION['user']['id'].'\',
				site='.$site.'
		';
		$id=DB::exec($sql);
		if(!empty($_POST['answers'])){
			foreach($_POST['descriptions'] as $i=>$item){
				if($item){
					$sql='
						INSERT INTO {{votes}}
						SET parent='.$id.',
							description=\''.$item.'\',
							answers=\''.$_POST['answers'][$i].'\',
							num=\''.$_POST['num'][$i].'\',
							visible=1,
							cdate=NOW(),
							author=\''.$_SESSION['user']['id'].'\',
							site='.$site.'
							
					';
					DB::exec($sql);
				}
			}
		}
		return $id;
	}
	public static function edit($id){
		$site=$_SESSION['site'];
		if(Funcs::$uri[0]==ONESSA_DIR) $site=$_SESSION['OneSSA']['site'];
		$sql='
			UPDATE {{votes}}
			SET description=\''.$_POST['description'].'\',
				cdate=NOW(),
				author=\''.$_SESSION['user']['id'].'\'
			WHERE id='.$id.'
		';
		DB::exec($sql);
		if(!empty($_POST['answers'])){
			$sql='DELETE FROM {{votes}} WHERE site='.$site.' AND parent='.$id.'';
			DB::exec($sql);
			foreach($_POST['descriptions'] as $i=>$item){
				if($item){
					$sql='
						INSERT INTO {{votes}}
						SET parent='.$id.',
							description=\''.$item.'\',
							answers=\''.$_POST['answers'][$i].'\',
							num=\''.$_POST['num'][$i].'\',
							visible=1,
							cdate=NOW(),
							author=\''.$_SESSION['user']['id'].'\',
							site='.$site.'
							
					';
					DB::exec($sql);
				}
			}
		}
	}
	public static function del($id){
		$site=$_SESSION['site'];
		if(Funcs::$uri[0]==ONESSA_DIR) $site=$_SESSION['OneSSA']['site'];
		$sql='DELETE FROM {{votes}} WHERE site='.$site.' AND id='.$id.'';
		DB::exec($sql);
		$sql='DELETE FROM {{votes}} WHERE site='.$site.' AND parent='.$id.'';
		DB::exec($sql);
	}
	public static function setAjax(){
		$sql='SELECT parent FROM {{votes}} WHERE id='.$_POST['id'];
		$parent=DB::getOne($sql);
		$sql='UPDATE {{votes}} SET answers=answers+1 WHERE id='.$_POST['id'];
		DB::exec($sql);
		setcookie('votes'.$parent,$parent,time()+3600*24*30,'/');
		return $parent;
	}
}
?>