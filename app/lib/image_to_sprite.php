<?php
class images_to_sprite {

	function images_to_sprite($folder,$output,$x,$y) {
		$this->folder = ($folder ? $folder : 'myfolder'); // Folder name to get images from, i.e. C:\\myfolder or /home/user/Desktop/folder
		$this->filetypes = array('jpg'=>true,'png'=>true,'jpeg'=>true,'gif'=>true); // Acceptable file extensions to consider
		$this->output = ($output ? $output : 'mysprite'); // Output filenames, mysprite.png and mysprite.css
		$this->x = $x; // Width of images to consider
		$this->y = $y; // Heigh of images to consider
		$this->files = array();
	}

	function create_sprite($path) {
		$basedir = $this->folder;
		$files = array();

		// Read through the directory for suitable images
		if($handle = opendir($this->folder)) {
			while (false !== ($file = readdir($handle))) {
				$split = explode('.',$file);
				// Ignore non-matching file extensions
				if($file[0] == '.' || !isset($this->filetypes[$split[count($split)-1]]))
					continue;
				// Get image size and ensure it has the correct dimensions
				$output = getimagesize($this->folder.'/'.$file);
				if($output[0] != $this->x && $output[1] != $this->y)
					continue;
				// Image will be added to sprite, add to array
				$this->files[$file] = $file;
			}
			closedir($handle);
		}

		// yy is the height of the sprite to be created, basically X * number of images
		$this->xx = $this->x * count($this->files);
		$im = imagecreatetruecolor($this->xx,$this->y);

		// Add alpha channel to image (transparency)
		imagesavealpha($im, true);
		$alpha = imagecolorallocatealpha($im, 0, 0, 0, 127);
		imagefill($im,0,0,$alpha);

		// Append images to sprite and generate CSS lines
		
		$i = $ii = 0;

		foreach($this->files as $key => $file) {
			$im2 = imagecreatefrompng($this->folder.'/'.$file);
			imagecopy($im,$im2,($this->x*$i),0,0,0,$this->x,$this->y);
			$i++;
		}

		imagepng($im,$path.$this->output.'.png'); // Save image to file
		imagedestroy($im);
		return $path.$this->output.'.png';
	}
}

//$class = new images_to_sprite('imagefolder','sprite',63,63);
//$class->create_sprite();
?>