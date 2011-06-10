<?php
	$imagesArr = array();
	$i = 0;
	
	if(file_exists('../album/album.xml')){
		$xml = simplexml_load_file('../album/album.xml');
	}
	
	if(file_exists('../album/images/')){
		$files = array_slice(scandir('../album/images/'), 2);
		
		if (count($files)) {
			foreach ($files as $file) {
				if ($file != '.' && $file != '..') {
					if ($xml) {
						$img = $xml->xpath('image[name="'.$file.'"]');
						
						if (count($img)) {
							$caption = ''; {
								$text1 = "{$img[0]->text1}";
								$text2 = "{$img[0]->text2}";
								$text3 = "{$img[0]->text3}";
								$link1 = "{$img[0]->link1}";
								$link2 = "{$img[0]->link2}";
								$link3 = "{$img[0]->link3}";
								
								$b = function($i, $t, $l) {
									$link_text = 'Link ';
									
									return '<a href="#" class="button showinfo" id="info'.$i.'" msg="'.htmlentities($t, ENT_QUOTES).'" lnk="'.htmlentities($l, ENT_QUOTES).'">'.$link_text.$i.'</a>';
								};
								
								$caption = '';
								for ($i = 1; $i <= 3; $i++) {
									$t = 'text' . $i;
									$l = 'link' . $i;
									$caption .= $b($i, ${$t}, ${$l});
								}
							}
							
							$imagesArr[] = array(
								'src' 	=> 'album/images/' . $file,
								'caption' => $caption
							);
						} else {
							continue;
						}
					}
				}
			}
		}
	}
	
	$json 		= $imagesArr; 
	$encoded 	= json_encode($json);
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');
	echo $encoded;
	unset($encoded);
?>