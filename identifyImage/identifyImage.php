<?php
function identify_image($filename=NULL) {
	if (file_exists($filename)) { //If it's passed as a file, open it, otherwise assume the contents were passed as a string.
		$fp = fopen($filename,"rb");
		$image_bin = fread($fp,8);
		fclose($fp);
	} else {
		$image_bin = substr($filename,0,8);
	}
	
	if (substr($image_bin,0,8)==chr(137).chr(80).chr(78).chr(71).chr(13).chr(10).chr(26).chr(10)) {
		return [
			'ext' => '.png'
			,'type' => 'raster'
			,'mime' => 'image/png'
			,'loss' => 'lossless'
		];
	}
	if (substr($image_bin,0,2)==chr(255).chr(216)) {
		return [
			'ext' => '.jpg,.jpeg,.jpe,.jif,.jfif,.jfi'
			,'type' => 'raster'
			,'mime' => 'image/jpeg'
			,'loss' => 'lossy'
		];
	}

	if (substr($image_bin,0,2)==chr(66).chr(77) || substr($image_bin,0,2)==chr(66).chr(65) || substr($image_bin,0,2)==chr(67).chr(73) || substr($image_bin,0,2)==chr(73).chr(67)) {
		return [
			'ext' => '.bmp,.dib'
			,'type' => 'raster'
			,'mime' => 'image/x-bmp'
			,'loss' => 'lossless'
		];
	}
	if (substr($image_bin,0,6)==chr(71).chr(73).chr(70).chr(56).chr(55).chr(97) || substr($image_bin,0,6)==chr(71).chr(73).chr(70).chr(56).chr(57).chr(97)) {
		return [
			'ext' => '.gif'
			,'type' => 'raster'
			,'mime' => 'image/x-bmp'
			,'loss' => 'palette'
		];
	}
	return false;
}
 
// Usage
if (!$ftype = identify_image("png.png"))
	die ("Cannot Identify Image Type");
else {
	echo "<pre>";
	print_r($ftype);
}
