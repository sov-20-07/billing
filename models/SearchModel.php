<?
class Search{
	public function getResult(){
		$data=array();
		$q=trim(strip_tags($_GET['q']));
		if($q){
			$sql='
				SELECT * FROM {{search}}
				INNER JOIN {{tree}} ON  {{search}}.tree={{tree}}.id
				WHERE search LIKE \'%'.$q.'%\' AND visible=1
				ORDER BY {{search}}.cdate DESC
			';
			$list=DB::getAll($sql);
			foreach ($list as $item){
				$fields=Fields::getFieldsByTree($item['tree'],'gal');
				$path=Tree::getPathToTree($item['tree']);
				$data[]=array(
					'id'=>$item['tree'],
					'name'=>$item['name'],
					'path'=>$path,
					'fields'=>$fields,
					'info'=>Tree::getInfo($item['tree'])
				);
			}
		}
		return $data;
	}
}
?>