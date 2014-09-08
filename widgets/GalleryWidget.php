<?
class GalleryWidget{
	public static $slideshowGroup=1;
	public static $files=array();
	function run($row){
		$row['slideshowGroup']=GalleryWidget::$slideshowGroup;
		GalleryWidget::$slideshowGroup++;
		$row['files']=array();
		if(is_numeric($row['tree'])){
			$sql='
				SELECT id FROM {{data}}
				WHERE tree='.$row['tree'].' AND path=\''.$row['path'].'\' AND type=\'gallery\'
			';
			$dataId=DB::getOne($sql);
			if($dataId){
				$sql='
					SELECT id2 FROM {{relations}}
					WHERE modul1=\'data\' AND modul2=\'files\' AND id1='.$dataId.'
				';
				$fileId=DB::getAll($sql,'id2');
				if(count($fileId)>0){
					$sql='
						SELECT * FROM {{files}}
						WHERE id IN ('.implode(',',$fileId).')
						ORDER BY num
					';
					$temp=DB::getAll($sql);
					foreach($temp as $item){
						$item['file']=Funcs::getFileInfo($item['path']);
						$row['files'][$item['mime']][]=$item;
					}
				}
			}
		}
		GalleryWidget::$files=$row['files'];
		return View::getWidget('galleryWidget',$row);
	}
}
?>