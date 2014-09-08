<?
class Catalog{
	public static $reserved=array('pp','p','pu','pd','d','s','o','r','ve','pf','pt','in','ajax','utm_source', 'utm_medium', 'utm_campaign');
	public static $options;
	function __construct(){
		
	}
	public function getPreviewCatalog($parent){
		$data=array();
		$sql='SELECT * FROM {{tree1}} WHERE parent='.$parent.' AND visible=1 ORDER BY num';
		$list=DB::getAll($sql);
		foreach($list as $row){
			$sql='
				SELECT {{tree}}.id FROM {{tree}}
				INNER JOIN {{catalog}} ON {{tree}}.id={{catalog}}.tree 
				WHERE {{tree}}.parent='.$row['id'].' AND {{tree}}.visible=1 
				ORDER BY {{catalog}}.rating
				LIMIT 0,3
			';
			$items=DB::getAll($sql,'id');
			//echo count($items); die;
			$data2=array();
			foreach($items as $id){
				$data2[]=Catalog::getOne($id);
			}
			$sql='
				SELECT COUNT({{catalog}}.id) FROM {{tree}}
				INNER JOIN {{catalog}} ON {{tree}}.id={{catalog}}.tree 
				WHERE {{tree}}.parent='.$row['id'].' AND {{tree}}.visible=1 
			';
			$count=DB::getOne($sql);
			$data[]=array(
				'path'=>'/catalog/'.$row['path'].'/',
				'name'=>$row['name'],
				'count'=>$count,
				'list'=>$data2,
			);
		}
		return $data;
	}
	public function getHitCatalog($parent){
		$quantity=0;
		$return=array();
		$sql='
			SELECT DISTINCT {{tree}}.id FROM {{tree}}
			INNER JOIN {{catalog}} ON {{tree}}.id={{catalog}}.tree
			WHERE {{tree}}.visible=1 AND {{catalog}}.hit=1
		';
		$catalog=DB::getAll($sql,'id');
		$k=1;
		foreach($catalog as $i=>$model){
			if($i%3==0 && $i!=0)$k++;
			$return[$k][]=Catalog::getOne($model);
			//$vendorsIds[$model['vendor']]++;
		}
		for($i=0;$i<$k*3-count($catalog);$i++)$return[$k][]=array();
		return $return;
	}
	public function getInnerListPagi($parent){
		//Catalog::setOptions();
		$condition=array('select'=>array(),'join'=>array(),'where'=>array());
		$quantity=0;
		$return=array();
		$priceArr=array('from'=>0,'to'=>0);
		$vendors=array('list'=>array());
		$vendorsIds=array();
		$ids[]=$parent;
		$ids=array_merge($ids,Tree::getChilds($parent));
		$start = microtime(true);
		/*foreach($_GET as $key=>$items){
			if(is_array($items)){
				foreach($items as $key2=>$item){
					if(trim($item)==''){
						unset($_GET[$key][$key2]);
					}
				}
			}
		}*/
		foreach($_GET as $key=>$item){
			if(!in_array($key,OneSSA::$catalogStandart) && !in_array($key,Catalog::$reserved) && count($ids)>0 && $item!='all' && $item!='' && substr($key,strlen($key)-3,2)!='_t'){
				$path=Catalog::$options[$key];
				if(!$path)$path=$key;
				$sql='
					SELECT type FROM {{data}}
					WHERE path=\''.$path.'\' AND tree IN ('.implode(',',$ids).')
				';
				$fieldName=Fields::$fieldsName[DB::getOne($sql)];
				if(substr($path,strlen($path)-3,2)=='_f'){
					$from=$path;
					$to=str_replace('_f','_t',$path);
					if(substr($path,strlen($path)-1,1)=='f') $field='value_float';
					else $field='value_int';
					$path=substr($path,0,strpos($path,'_f'));
					$sql='
							SELECT DISTINCT {{tree}}.id FROM {{tree}}
							INNER JOIN {{data}} ON {{tree}}.id={{data}}.tree
							WHERE {{data}}.path=\''.Catalog::$options[$path].'\' AND ('.$field.' BETWEEN '.($_GET[$from]==''?'0':$_GET[$from]).' AND '.($_GET[$to]==''?'100000000':$_GET[$to]).')
								AND {{tree}}.id IN ('.implode(',',$ids).')
					';
				}elseif(is_array($item)){
					if(is_numeric($item[0])){
						$sql='
							SELECT DISTINCT {{tree}}.id FROM {{tree}}
							INNER JOIN {{data}} ON {{tree}}.id={{data}}.tree
							WHERE {{data}}.path=\''.$path.'\' AND '.$fieldName.' IN ('.implode(',',$item).')
								AND {{tree}}.id IN ('.implode(',',$ids).')
						';
					}else{
						$sql='
							SELECT DISTINCT {{tree}}.id FROM {{tree}}
							INNER JOIN {{data}} ON {{tree}}.id={{data}}.tree
							WHERE {{data}}.path=\''.$path.'\' AND '.$fieldName.' IN (\''.implode('\',\'',$item).'\')
								AND {{tree}}.id IN ('.implode(',',$ids).')
						';
					}
				}elseif(is_numeric($item)){
					$sql='
						SELECT DISTINCT {{tree}}.id FROM {{tree}}
						INNER JOIN {{data}} ON {{tree}}.id={{data}}.tree
						WHERE {{data}}.path=\''.$path.'\' AND '.$fieldName.'='.$item.'
							AND {{tree}}.id IN ('.implode(',',$ids).')
					';
				}else{
					$sql='
						SELECT DISTINCT {{tree}}.id FROM {{tree}}
						INNER JOIN {{data}} ON {{tree}}.id={{data}}.tree
						WHERE {{data}}.path=\''.$path.'\' AND '.$fieldName.'=\''.$item.'\'
							AND {{tree}}.id IN ('.implode(',',$ids).')
					';
				}
				//print DB::prefix($sql);
				$ids=DB::getAll($sql,'id');
			}
		}
		//echo 'Время выполнения скрипта '.(microtime(true) - $start).' ('.DB::$count.')<br />';
		if($_GET['a']==1){
			$available=' AND available=1';
		}
		if(is_numeric($_GET['pf']) || is_numeric($_GET['pt'])){
			$condition['select']['price']=' AND ({{catalog}}.price BETWEEN '.($_GET['pf']==''?'0':$_GET['pf']).' AND '.($_GET['pt']==''?'1000000':$_GET['pt']).')';
		}
		if(is_array($_GET['in']) && count($_GET['in']>0)){
			$condition['select']['installation']=' AND {{tree}}.parent IN ('.implode(',',$_GET['in']).')';
		}
		if(is_array($_GET['ve']) && count($_GET['ve']>0)){
			$condition['select']['vendor']=' AND {{catalog}}.vendor IN ('.implode(',',$_GET['ve']).')';
		}elseif(is_numeric($_GET['ve'])){
			$condition['select']['vendor']=' AND {{catalog}}.vendor='.$_GET['ve'].'';
		}
		if(is_array($_GET['ra'])){
			if($_GET['ra']['r']=='r'){
				$reports='INNER JOIN {{reports}} ON {{tree}}.id={{reports}}.tree';
				unset($_GET['ra']['r']);
			}
			if(count($_GET['ra'])>0){
				$rating=' AND rating IN ('.implode(',',$_GET['ra']).')';
			}
		}
		$order='{{tree}}.num';
		$orderSelect='';
		switch($_GET['s']){
			case 'pu': $order='price DESC';break;
			case 'pd': $order='price';break;
			case 'd': $order='udate DESC';break;
			case 's': $order='skidka DESC'; $orderSelect=', (100-({{'.$tab.'}}.new_cost/{{'.$tab.'}}.old_cost*100)) AS skidka'; break;
			case 'o': $order='popularity DESC';break;
			case 'r': $order='rating DESC';break;
		}
		if(count($ids)>0){
			$sql='
				SELECT DISTINCT {{catalog}}.*, {{tree}}.* '.$orderSelect.' FROM {{catalog}} 
				INNER JOIN {{tree}} ON {{catalog}}.tree={{tree}}.id
					'.$reports.'
				WHERE {{tree}}.id IN ('.implode(',',$ids).') '.implode(' ',$condition['select']).'
					AND {{tree}}.visible=1
				ORDER BY '.$order.'
			';
			$catalog=DB::getPagi($sql);
			$fields=Fields::getReserveFieldsByModulePath($tab);
			$k=1;
			foreach($catalog as $i=>$model){
				if($i%3==0 && $i!=0)$k++;
				$return[$k][]=Catalog::getOne($model['id']);
				//$vendorsIds[$model['vendor']]++;
			}
			for($i=0;$i<$k*3-count($catalog);$i++)$return[$k][]=array();
			$sql='
				SELECT COUNT(DISTINCT {{tree}}.id) 
				 FROM {{catalog}}
				INNER JOIN {{tree}} ON {{catalog}}.tree={{tree}}.id
					'.$reports.'
				WHERE {{tree}}.id IN ('.implode(',',$ids).') '.implode(' ',$condition['select']).'
					AND {{tree}}.visible=1
			';
			$quantity=DB::getOne($sql);
			$x=0;
			/*foreach(Funcs::$referenceId['vendor'] as $key=>$item){
				if(!key_exists($key,$vendorsIds)){
					$item['disabled']='disabled';
					$x++;
				}else{
					$item['count']=$vendorsIds[$key];
					$vendors['list'][$key]=$item;
				}
			}*/
			if($x==count(Funcs::$referenceId['vendor']))$vendors['list']=array();
		}
		return array('list'=>$return,/*'vendors'=>$vendors,*/'quantity'=>$quantity);
	}
	public function getOne($id){
		//die($id);
		if(!Cache::get('model'.$id)){
			$fields=Fields::getReserveFieldsByModulePath('catalog');
			$sql='
				SELECT {{catalog}}.*, {{tree}}.* FROM {{catalog}} 
				INNER JOIN {{tree}} ON {{catalog}}.tree={{tree}}.id
				WHERE {{tree}}.id ='.$id.'
			';
			$model=DB::getRow($sql);
			if($model){
				foreach($fields as $key=>$item){
					if(in_array($item['path'],OneSSA::$catalogStandart)){
						$temp[$item['path']]=$model[$item['path']];
					}
				}
				$return=$temp;
				$return['id']=$id;
				$parentpath=Tree::getPathToTree($model['parent']);
				$return['path']=$parentpath./*Funcs::$referenceId['vendor'][$model['vendor']]['path'].'/'.*/$id.'/';
				$return['tree']=$id;
				$return['name']=$model['name'];
				$return['parent']=$model['parent'];
				$return['rating']=$model['rating'];
				$return['report']=Catalog::getCountReport($id);
				$return['sale']=$item['price']-$item['supprice'];
				$fields=Fields::getFieldsByTree($id,'wide');
				$return['pics']=$fields['files_gal']['image'];
				
				/*$date_b=explode('.', Funcs::$conf['akcia']['date_begin']);
		$date_e=explode('.', Funcs::$conf['akcia']['date_end']);
		$date_b=mktime(0,0,0,$date_b[1], $date_b[0],$date_b[2]);
		$date_e=mktime(23,59,59,$date_e[1], $date_e[0],$date_e[2]);
		$today=mktime();
		$yes=0;
		if (($today>=$date_b)&&($today<=$date_e))
		$yes=1;
		$akcia='0';
		if ($yes==1)
		$akcia=$model['akcia'];*/
		
				$return['akcia']=$akcia;
				$return['files']=$fields['files_gal']['application'];
				$multi=Fields::getMultiFields($id);
				if(count($multi['tv'])>0){
					$return['descr1']='Телевидение';
					$return['descr2']=Funcs::$referenceId['tv'][$multi['tv'][0]]['name'];
				}
				unset($fields['files_gal']);
				unset($fields['gal']);
				$return['additional']=Catalog::getAdditionalFieldsArray($fields);
				Cache::set('model'.$id,$return);
				return $return;
			}
		}else{
			return Cache::get('model'.$id);
		}
	}
	public function getPathToTree($id){
		if(is_numeric($id)){
			$sql='SELECT parent FROM {{tree}} WHERE id='.$id;
			$parent=DB::getOne($sql);
			$parentpath=Tree::getPathToTree($parent);
			$sql='SELECT vendor FROM {{catalog}} WHERE tree='.$id;
			$vendor=DB::getOne($sql);
			return $parentpath.Funcs::$referenceId['vendor'][$vendor]['path'].'/'.$id.'/';
		}
	}
	public function getAdditionalFieldsArray($fields){
		$data=array();
		foreach($fields as $key=>$item){
			foreach(Extra::$paramCategories as $name=>$param){
				if(in_array(trim(str_replace($name.' ','',$key)),$param)){
					$data[$name][trim(str_replace($name.' ','',$key))]=$item;
				}
			}
		}
		if(count($data)==0){
			if(count($fields)==1){
				$data=reset($fields);
			}else{
				$data=$fields;
			}
		}
		return $data;
	}
	public function getAdditionalgood($id,$what){
		$data=array();
		if($id){
			$sql='
				SELECT DISTINCT {{relations}}.id2 AS id FROM {{relations}}
				INNER JOIN {{data}} ON {{relations}}.id1={{data}}.id
				WHERE {{data}}.tree='.$id.' AND {{data}}.path=\''.$what.'\'
				ORDER BY RAND()
				LIMIT 0,3
			';
			$ids=DB::getAll($sql,'id');
			foreach($ids as $i=>$id){
				if($id)$temp=Catalog::getOne($id);
				if($temp['name'])$data[]=$temp;
			}
		}
		return $data;
	}
	public function getMore($id,$parent){
		$return=array();
		$sql='
			SELECT DISTINCT {{tree}}.id FROM {{catalog}}
			INNER JOIN {{tree}} ON {{catalog}}.tree={{tree}}.id
			WHERE {{tree}}.parent='.$parent.' AND {{tree}}.id<>'.$id.' AND visible=1
			ORDER BY RAND() LIMIT 0,3
		';
		$catalog=DB::getAll($sql,'id');
		foreach($catalog as $i=>$item){
			$return[]=Catalog::getOne($item);
		}
		return $return;
	}
	public function getRecommended($id,$count=5){
		$data=array();
		$idsp=array_merge(array($id),Tree::getChilds($id));
		$sql='
			SELECT {{tree}}.id FROM {{tree}}
			INNER JOIN {{catalog}} ON {{catalog}}.tree={{tree}}.id
			WHERE {{tree}}.id<>'.$id.' AND parent IN ('.implode(',',$idsp).')
			ORDER BY RAND() LIMIT 0,'.$count.'
		';
		$ids=DB::getAll($sql,'id');
		foreach($ids as $i=>$id){
			$data[]=Catalog::getOne($id);
		}
		return $data;
	}
	public static function setViewed($id){
		if(isset($_COOKIE['viewed'])){
			$viewed=explode(',',$_COOKIE['viewed']);
			$viewed=array_unique($viewed);
			if(!in_array($id,$viewed))$viewed[]=$id;
			$viewed=implode(',',$viewed);
		}else{
			$viewed=$id;
		}
		setcookie("viewed",$viewed,time()+3600*24*7,"/",$_SERVER['HTTP_HOST']);
	}
	public static function getViewed(){
		if(isset($_COOKIE['viewed'])){
			$viewed=explode(',',$_COOKIE['viewed']);
		}
		if(count($viewed)>0){
			$return=array();
			$sql='
				SELECT DISTINCT {{tree}}.id  FROM {{catalog}}
				INNER JOIN {{tree}} ON {{catalog}}.tree={{tree}}.id
				WHERE {{tree}}.id IN ('.implode(',',$viewed).') AND {{tree}}.visible=1
			';
			$catalog=DB::getAll($sql,'id');
			/*foreach($viewed as $i=>$item){
				if(in_array($item,$catalog)){
					$viewed[$i]=Catalog::getOne($item);
				}
			}*/
			$k=1;
			$viewed=array_reverse($viewed);
			foreach($viewed as $i=>$item){
				if($i%4==0 && $i!=0)$k++;
				$return[$k][]=Catalog::getOne($item);
			}
			for($i=0;$i<$k*4-count($catalog);$i++)$return[$k][]=array();
			return $return;
			//return $viewed;
		}else{
			return array();	
		}		
	}
	public static function setFavorite($id){
		$count=0;
		if(isset($_COOKIE['favorite'])){
			$favorite=explode(',',$_COOKIE['favorite']);
			$favorite=array_unique($favorite);
			if(!in_array($id,$favorite))$favorite[]=$id;
			$count=count($favorite);
			$favorite=implode(',',$favorite);
		}else{
			$favorite=$id;
		}
		setcookie("favorite",$favorite,time()+3600*24*7,"/",$_SERVER['HTTP_HOST']);
		return $count;
	}
	public static function delFavorite($id){
		$count=0;
		if(isset($_COOKIE['favorite'])){
			$favorite=explode(',',$_COOKIE['favorite']);
			$favorite=array_unique($favorite);
			if(in_array($id,$favorite))unset($favorite[array_search($id, $favorite)]); 
			$count=count($favorite);
			$favorite=implode(',',$favorite);
		}else{
			$favorite=$id;
		}
		setcookie("favorite",$favorite,time()+3600*24*7,"/",$_SERVER['HTTP_HOST']);
		return $count;
	}
	public static function getFavorite(){
		if(isset($_COOKIE['favorite'])){
			$favorite=explode(',',$_COOKIE['favorite']);
		}
		if(count($favorite)>0){
			$tab=strtolower(__CLASS__);
			$return=array();
			$sql='
				SELECT DISTINCT {{tree}}.id  FROM {{'.$tab.'}}
				INNER JOIN {{tree}} ON {{'.$tab.'}}.tree={{tree}}.id
				WHERE {{tree}}.id IN ('.implode(',',$favorite).')
			';
			$catalog=DB::getAll($sql,'id');
			foreach($catalog as $item){
				$return[]=Catalog::getOne($item);
			}
			return $return;
		}else{
			return array();	
		}		
	}
	public function setPopularity($tree){
		$tab=strtolower(__CLASS__);
		$sql='
			UPDATE {{'.$tab.'}}
			SET popularity=popularity+1
			WHERE tree='.$tree.'
		';
		DB::exec($sql);
	}
	public function setReport($id){
		foreach ($_POST as $key=>$value) $_POST[$key] = htmlspecialchars(trim(strip_tags($value)));
		$cbid=0;
		$sql='
			INSERT INTO {{reports}}
			SET 
				`tree`='.$id.',
				`name`=\''.$_POST['name'].'\',
				`email`=\''.$_POST['email'].'\',
				`report`=\''.$_POST['report'].'\',
				`stars`='.$_POST['stars'].',
				`create_date`=NOW()
		';
		DB::exec($sql);
		$sql='SELECT * FROM {{reports}} WHERE tree='.$id.'';
		$list=DB::getAll($sql);
		$count=count($list);
		$sum=0;
		foreach($list as $item){
			$sum+=$item['stars'];
		}
		$rating=round($sum/$count);
		$sql='
			UPDATE {{catalog}}
			SET rating='.$rating.'
			WHERE tree='.$id.'
		';
		DB::exec($sql);
		$path=Tree::getPathToTree($id);
		$text=View::getRenderEmpty('email/adminreport',array('path'=>$path));
		$mail = new Email;
		$mail->Text($text);
		$mail->Subject('Оставлен отзыв на сайте www.'.str_replace('www.','',$_SERVER["HTTP_HOST"]));
		$mail->From('robot@'.str_replace('www.','',$_SERVER["HTTP_HOST"]));
		$mail->mailTo(Funcs::$conf['email']['report']);
		$mail->Send();
	}
	public function delReport(){
		$sql='DELETE FROM {{reports}} WHERE id='.$_GET['id'].' AND `tree`='.$_GET['tree'].'';
		DB::exec($sql);
	}
	public function setSubscribe($id){
		foreach ($_POST as $key=>$value) $_POST[$key] = htmlspecialchars(trim(strip_tags($value)));
		$cbid=0;
		$sql='SELECT id FROM {{subscribers}} 
			WHERE `tree`='.$id.' AND `email`=\''.$_POST['email'].'\'
		';
		$temp=DB::getOne($sql);
		if(!$temp){
			$sql='
				INSERT INTO {{subscribers}}
				SET 
					`tree`='.$id.',
					`name`=\''.$_POST['name'].'\',
					`email`=\''.$_POST['email'].'\'
			';
			DB::exec($sql);
		}
	}
	public static function getReports($id){
		$sql='SELECT * FROM {{reports}} WHERE tree='.$id.'';
		return DB::getAll($sql);
	}
	public static function getReport($id){
		if($_GET['report']){
			$sql='
				SELECT {{orders}}.* FROM {{orders}} 
				INNER JOIN {{orders_items}} ON {{orders}}.id={{orders_items}}.orders
				WHERE {{orders_items}}.tree='.$id.' AND MD5(CONCAT({{orders}}.email,\'report\'))=\''.$_GET['report'].'\'
			';
			$tree=DB::getRow($sql);
			if($tree['id']){
				$sql='
					SELECT id FROM {{reports}}
					WHERE tree='.$id.' AND email=\''.$tree['email'].'\'
				';
				$temp=DB::getOne($sql);
				if($temp){
					return 0;
				}else{
					return $tree;
				}
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	public static function getCountReport($id){
		$sql='SELECT count(*) FROM {{reports}} WHERE tree='.$id.'';
		return DB::getOne($sql);
	}
	public static function getType($id,$parent){
		if(!Funcs::$uri[3]){
			$parent=$id;
		}
		$sql='
			SELECT {{tree}}.* FROM {{tree}} 
			LEFT JOIN {{catalog}} ON {{tree}}.id={{catalog}}.tree
			WHERE {{tree}}.parent='.$parent.' AND {{catalog}}.tree IS NULL ORDER BY {{tree}}.num
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$item['path']=Tree::getPathToTree($item['id']);
			$data['list'][]=$item;
		}
		return $data;
	}
	public static function getVendors($parent,$models=array()){
		$vendors['list']=array();
		if(Funcs::$uri[2]==''){
			$sql='SELECT id FROM {{tree}} WHERE path=\''.Funcs::$uri[1].'\' AND visible=1';
			$id=DB::getOne($sql);
			$ids=Tree::getChilds($id);
			$sql='
				SELECT DISTINCT {{reference}}.name, {{reference}}.path, {{reference}}.id FROM {{reference}} 
				INNER JOIN ({{catalog}}
					INNER JOIN {{tree}} ON {{catalog}}.tree={{tree}}.id)
				ON {{reference}}.id={{catalog}}.vendor
				WHERE {{tree}}.id IN ('.implode(',',$ids).') AND {{tree}}.visible=1 ORDER BY name
			';
		}else{
			$sql='
				SELECT DISTINCT {{reference}}.name, {{reference}}.path, {{reference}}.id FROM {{reference}} 
				INNER JOIN ({{catalog}}
					INNER JOIN {{tree}} ON {{catalog}}.tree={{tree}}.id)
				ON {{reference}}.id={{catalog}}.vendor
				WHERE {{tree}}.parent='.$parent.' AND {{tree}}.visible=1 ORDER BY name
			';
		}
		$list=DB::getAll($sql);
		$vendorIds=array();
		$vendorCount=array();
		foreach($models as $items){
			foreach($items as $item){
				$vendorIds[]=$item['vendor'];
				$vendorCount[$item['vendor']]++;
			}
		}
		foreach($list as $item){
			if(in_array($item['id'],$vendorIds) && isset($_GET['opt'])){
				$vendors['list'][]=array(
					'id'=>$item['id'],
					'name'=>$item['name'],
					'path'=>$item['path'],
					'count'=>$vendorCount[$item['id']]
				);
			}elseif(!isset($_GET['opt'])){
				$sql='
					SELECT COUNT({{tree}}.id) FROM {{catalog}}
					INNER JOIN {{tree}} ON {{catalog}}.tree={{tree}}.id
					WHERE {{tree}}.parent='.$parent.' AND {{tree}}.visible=1 AND {{catalog}}.vendor='.$item['id'].'
				';
				$count=DB::getOne($sql);
				$vendors['list'][]=array(
					'id'=>$item['id'],
					'name'=>$item['name'],
					'path'=>$item['path'],
					'count'=>$count
				);
			}
		}
		return $vendors;
	}
	public static function setOptions(){
		foreach(Funcs::$referenceId['options'] as $item){
			$value=$item['value'];
			$value=explode("\n",$item['value']);
			Catalog::$options[trim($value[0])]=$item['name'];
		}
	}
	public static function getValuesPrice($parent){
		$data=array();
		$sql='
			SELECT MAX({{catalog}}.price) AS maxv, MIN({{catalog}}.price) AS minv FROM {{catalog}}
			INNER JOIN {{tree}} ON {{tree}}.id={{catalog}}.tree
			WHERE {{tree}}.parent='.$parent.' AND {{tree}}.visible=1
		';
		$data=DB::getRow($sql);
		$data['type']=substr($type,0,1);
		if($data['maxv']>0){
			return $data;
		}else{
			return array();
		}
	}
	public static function getMounting($fields){
		$value='';
		foreach(Funcs::$reference as $key=>$item){
			if(in_array(Funcs::$uri[2],explode(';',$key))){
				foreach($item as $key=>$ref){
					if($fields['additional'][$item[key($item)]['name']]<$key && $value==''){
						$value=$ref['value'];
					}
				}
			}
		}
		return $value;
	}
	public static function getLink($link){
		$data=array();
		foreach(Funcs::$reference[$link] as $path=>$item){
			if(in_array($path,Funcs::$uri)){
				$values=explode(';',$item['value']);
				foreach($values as $i=>$value){
					$data['list'][]=array(
						'href'=>'?pf='.($values[$i-1]>0?$values[$i-1]:0).'&pt='.($values[$i]>0?$values[$i]:0).'',
						'name'=>($values[$i-1]>0?'от '.$values[$i-1]:'').' '.($values[$i]>0?'до '.$values[$i]:0).''
					);
				}
				$data['list'][]=array(
					'href'=>'?pf='.$values[$i],
					'name'=>'от '.$values[$i]
				);
			}
		}
		return $data;
	}
}
?>