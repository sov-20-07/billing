<?
class Research{
	function __construct(){
		
	}
	function getSearch(){
		$data=array();
		$sql='SELECT COUNT(*) FROM {{search}}';
		$data['search']=DB::getOne($sql);
		$sql='SELECT COUNT(*) FROM '.BDPREFIX.'tree WHERE visible=1 and path<>\'index\' and path<>\'search\' and path<>\'sitemap\'';
		$data['tree']=DB::getOne($sql,1);
		return $data;
	}
	function setSearch(){
		$data=array();
		$sql='SELECT * FROM '.BDPREFIX.'tree WHERE visible=1 and path<>\'index\' and path<>\'search\' and path<>\'sitemap\' ORDER BY mdate DESC, cdate DESC';
		$list=DB::getAll($sql,'',1);
		$sql='DELETE FROM {{search}}';
		DB::exec($sql);
		foreach($list as $item){
			$sql='SELECT * FROM {{data}} WHERE tree='.$item['id'].'';
			$datas=DB::getAll($sql);
			$temp=$item['id'].' '.$item['name'].' '.$item['seo_title'].' '.$item['seo_keywords'].' '.$item['seo_description'].'  ';
			foreach($datas as $item2){ 	
				$temp.=trim(htmlspecialchars(strip_tags($item2['value_string'].' '.$item2['value_text']))).' ';
			}
			$item['search']=$temp;
			$sql='
				INSERT INTO {{search}}
				SET 
					name=\''.mysql_real_escape_string($item['name']).'\',
					tree=\''.$item['id'].'\',
					search=\''.mysql_real_escape_string($item['search']).'\',
					cdate=\''.$item['mdate'].'\'
		   ';
			DB::exec($sql);
		}
	}
}
?>