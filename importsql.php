<?
require_once $_SERVER['DOCUMENT_ROOT'].'/settings.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/class/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/class/Funcs.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/class/View.php';
class site{
	public static $i=1;
	function __construct(){
		//$this->catalog(468,3);
		//$this->catalog(476,4);
		//$this->catalog(484,6);
		//$this->catalog(481,5);
		//$this->catalogOne(519,9);
		//$this->catalogOne(489,7);
		//$this->catalogOne(511,8);
		//$this->catalogOne(522,10);
	}
	function catalog($from,$to){
		$data=array();
		$sql='SELECT ID FROM onessa_struct WHERE parent=\''.$from.'\' ORDER BY num';
		$list=DB::getAll($sql,'ID');
		$i=0;
		foreach($list as $parent){
			$sql='SELECT * FROM model WHERE parent=\''.$parent.'\'';
			$items=DB::getAll($sql);
			foreach($items as $item){
				if(!$temp){
					$data=array(
						'parent'=>$to,
						'name'=>$item['name'],
						'seo_title'=>$item['title']==''?$item['name']:$item['title'],
						'seo_keywords'=>$item['kw']==''?$item['name']:$item['kw'],
						'seo_description'=>$item['descr']==''?$item['name']:$item['descr'],
						'description'=>$item['small_descr'],
						'fulltext'=>$item['full_descr'],
						'model'=>$item['model'],
						'market'=>$item['market'],
						'price'=>$item['price'],
						'visible'=>$item['visible'],
						'available'=>$item['sale'],
						'udate'=>date('Y-m-d H:i'),
						'path'=>Funcs::Transliterate($item['name']),
						'oldid'=>$item['ID'],
					);
					$id=site::setPage($data,$i);
					$i++;
				}
			}
		}
		//print '<pre>';
		//print_r($data);
	}
	function catalogOne($from,$to){
		$data=array();
		$i=0;
		$sql='SELECT * FROM model WHERE parent=\''.$from.'\'';
		$items=DB::getAll($sql);
		foreach($items as $item){
			if(!$temp){
				$data=array(
					'parent'=>$to,
					'name'=>$item['name'],
					'seo_title'=>$item['title']==''?$item['name']:$item['title'],
					'seo_keywords'=>$item['kw']==''?$item['name']:$item['kw'],
					'seo_description'=>$item['descr']==''?$item['name']:$item['descr'],
					'description'=>$item['small_descr'],
					'fulltext'=>$item['full_descr'],
					'model'=>$item['model'],
					'market'=>$item['market'],
					'price'=>$item['price'],
					'visible'=>$item['visible'],
					'available'=>$item['sale'],
					'udate'=>date('Y-m-d H:i'),
					'path'=>Funcs::Transliterate($item['name']),
					'oldid'=>$item['ID'],
				);
				$id=site::setPage($data,$i);
				$i++;
			}
		}
		//print '<pre>';
		//print_r($data);
	}
	public static function setPage($item,$iii){
		print site::$i.' '.$item['path'].' '.$item['name'].'<br />';
		site::$i++;
		$sql='
			INSERT INTO {{tree}} 
			SET
				parent='.$item['parent'].',
				name=\''.$item['name'].'\',
				seo_title=\''.$item['seo_title'].'\',
				seo_keywords=\''.$item['seo_keywords'].'\',
				seo_description=\''.$item['seo_description'].'\',
				site=1,
				path=\''.$item['path'].'\',
				visible=\''.$item['visible'].'\',
				menu=0,
				cdate=\''.$data['udate'].'\',
				udate=\''.$item['udate'].'\',
				num='.$iii.'
		';
		$id=DB::exec($sql);
		$sql='
			INSERT INTO {{catalog}} 
			SET
				tree='.$id.',
				model=\''.$item['model'].'\',
				description=\''.$item['description'].'\',
				yandex_description=\''.$item['description'].'\',
				price=\''.$item['price'].'\',
				available=\''.$item['available'].'\',
				market=\''.$item['market'].'\'
		';
		//DB::exec($sql);
		$sql='
			INSERT INTO {{catalog}} 
			SET
				tree='.$id.',
				oldid='.$item['oldid'].',
				available=1,
				market=1
		';
		DB::exec($sql);
		$sql='
			INSERT INTO {{relations}} 
			SET modul1=\'tree\',
				modul2=\'catalog\',
				id1='.$id.',
				id2=1,
				cdate=NOW()
		';
		DB::exec($sql);
		$sql='
			INSERT INTO {{data}} 
			SET
				tree='.$id.',
				path=\'fulltext\',
				type=\'editor\',
				value_text=\''.$item['fulltext'].'\',
				cdate=NOW(),
				num=1,
				visible=1
		';
		//DB::exec($sql);
	}
}
new site;
?>