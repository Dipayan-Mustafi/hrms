<?php
class Image {
	
	var $height_new;
	var $width_new;
	
	public function ImageResampled($fol, $pic, $w, $h){
		$ppath=$fol."/".$pic;
		$height=$h;
		$width=$w;
				
		list ($width_orig, $height_orig)=@getimagesize($ppath);
		
		
		
		
		if ($width  <> $width_orig){
			if ($width_orig > 0){
				$this->height_new=($height_orig * $width) / $width_orig;
				$this->width_new=$width;
			}
		}else{
			$this->height_new= $height_orig  ;
			$this->width_new= $width_orig  ;
		}
		
		if ($height <> $this->height_new){
			if ($this->height_new > 0){
				$this->width_new=($this->width_new * $height) / $this->height_new;
				$this->height_new=$height;
			}
		}

	}
	
	public function SetWidth(){
		return $this->width_new;
	}
	
	public function SetHeight(){
		return $this->height_new;
	}
	
	public function ImageUploader($fol, $pic, $tmp, $tmpdir ,$user){
		move_uploaded_file($tmp, $tmpdir.$pic);
		$pic_name=explode(".", $pic);
		$fname=$pic_name[0]."_".$user.".".$pic_name[1];
		$file_det=$fol.$fname;
		if (file_exists($file_det)){
			@unlink ($file_det);
		}else{
			rename ($tmpdir.$pic, $file_det);
		}
		return $fname;
	}
	public function imageUpload($fol, $pic, $tmp, $tmpdir ){
		move_uploaded_file($tmp, $tmpdir.$pic);
		$pic_name=explode(".", $pic);
		$fname=$fol.$pic;
		if (file_exists($fname)){
			@unlink ($fname);
		}else{
			rename ($tmpdir.$pic, $fname);
		}
		return $fname;
	}
}
?>