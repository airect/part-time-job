<?php
class AdviceAction extends Action {
	public function index() {
		dump(APP_PATH);
		$this->display();
	}
	public function push() {
		if(session('?uid')){
			$uid = session('');
		}
		//提交到数据库
		$Advice = M('Advice');
			//过滤
		$Advice->check('c', '1,200','length');
		$content = $this->_post('c');
		$data = array('content'=>$content);
			//提交
		if($Advice->add($data)){
			$this->ajaxReturn(1,'提交成功',1);
		}else{
			$this->ajaxReturn(0,'提交失败',1);
		}
	}
	public function imgUpload(){
		Vendor('um.Uploader','','.class.php');
		$config = array(
        	"savePath" =>APP_PATH . "Public/Upload/",             //存储文件夹
        	"maxSize" => 2*1024 ,                   //允许的文件最大尺寸，单位KB
        	"allowFiles" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp" ), //允许的文件格式
		);

		$up = new Uploader( "upfile" , $config );
		$type = $_REQUEST['type'];
		$callback=$_GET['callback'];

		$info = $up->getFileInfo();
		$info['url'] = str_replace(APP_PATH, '', $info['url']);
		/**
		 * 返回数据	
		 */
		if($callback) {
			echo '<script>'.$callback.'('.json_encode($info).')</script>';
		} else {
			echo json_encode($info);
		}
	}
}
?>