<?
class BannersWidget{
	function run(){
		$data=array();
		if(Funcs::$infoblock['banners']){
			foreach(Funcs::$infoblock['banners'] as $item){
				$x=0;
				$path=explode("\r\n",$item['source']);
				foreach($path as $p){
					if(strpos($p,'*')!==false){
						$p=substr($p,0,strpos($p,'*'));
						if(strpos($_SERVER['REQUEST_URI'],$p)!==false){
							$x=1;
						}
					}else{
						if($_SERVER['REQUEST_URI']==$p){
							$x=1;
						}
					}
				}
				if($x==1){
					$data[]=$item;
				}
			}
		}
		return View::Widget('banners',array('list'=>$data,'sales'=>BannersWidget::getSales()));
	}
	function getSales(){
		$data=array();
		$sql='
			SELECT {{catalog}}.tree FROM {{catalog}}
			INNER JOIN {{tree}} ON {{catalog}}.tree={{tree}}.id
			WHERE visible=1 AND {{catalog}}.price<{{catalog}}.oldprice
			ORDER BY RAND()	LIMIT 0,2
		';
		$list=DB::getAll($sql,'tree');
		foreach($list as $item){
			$data[]=Catalog::getOne($item);
		}
		return $data;
	}
}
?>