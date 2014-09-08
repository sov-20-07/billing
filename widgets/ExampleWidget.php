<?
class ExampleWidget{
	function run(){
		$sql='
			SELECT {{tree}}.name FROM {{search}}
			INNER JOIN ({{tree}}
				INNER JOIN {{catalog}} ON  {{catalog}}.tree={{tree}}.id
			) ON  {{search}}.tree={{tree}}.id
			WHERE {{tree}}.visible=1
			ORDER BY RAND()
			LIMIT 0,1
		';
		$name=DB::getOne($sql);
		if(strlen($name)>50 && strpos($name,' ',50)!==false){
			$name=substr($name,0,strpos($name,' ',50));
		}
		print $name;
	}
}
?>