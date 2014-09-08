<?
class Run{
	public static $colors=array();
	public static $headerClass='';
	public static $socTitle='';
	public static $socDescription='';
	public function __construct(){
		if($_GET['ref']){
			$sql='SELECT iuser FROM {{iusers_options}} WHERE selfcode=\''.$_GET['ref'].'\'';
			$iuser=DB::getOne($sql);
			if($iuser){
				$_SESSION['referal']=$iuser;
			}
		}
		$sql='SELECT * FROM {{tree}} WHERE parent=410 AND visible=1 ORDER BY num';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$fields=Fields::getFieldsByTree($item['id'],'wide');
			$item['pic']=$fields['files_gal']['image'][0]['path'];
			$multi=Fields::getMultiFields($item['id']);
			foreach($multi['color'] as $row){
				$item['list'][$row]=Funcs::$referenceId['color'][$row]['name'];
			}
			Run::$colors[$item['id']]=$item;
		}
		//print '<pre>';print_r(Run::$colors);die;
		$sql='SELECT * FROM {{tree}} WHERE id=1';
		$row=DB::getRow($sql);
		Run::$socTitle=$row['seo_title'];
		Run::$socDescription=$row['seo_description'];
	}
}
new Run;
?>