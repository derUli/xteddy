<?php
class XTeddy extends Controller {
	private $moduleName = "xteddy";
	public function getImages() {
		$images = array ();
		$dir = scandir ( ModuleHelper::buildModuleRessourcePath ( $this->moduleName, "images" ) );
		foreach ( $dir as $file ) {
			if (endsWith ( $file, ".png" )) {
				$teddyName = basename ( pathinfo ( $file, PATHINFO_FILENAME ) );
				$images [$teddyName] = ModuleHelper::buildModuleRessourcePath ( $this->moduleName, "images/" . basename ( $file ) );
			}
		}
		return $images;
	}
	public function contentFilter($html) {
		if (strpos ( $html, '[' ) !== false) {
			$images = $this->getImages ();
			
			foreach ( $images as $key => $value ) {
				ViewBag::set ( "teddy_image", $value );
				$imgHtml = Template::executeModuleTemplate ( $this->moduleName, "teddy.php" );
				$html = str_ireplace ( '[' . $key . ']', $imgHtml, $html );
			}
			if (strpos ( $html, '[xtoys]' ) !== false) {
				$random = array_rand ( $images );
				ViewBag::set ( "teddy_image", $images [$random] );
				$imgHtml = Template::executeModuleTemplate ( $this->moduleName, "teddy.php" );
				
				$html = str_ireplace ( '[xtoys]', $imgHtml, $html );
			}
		}
		return $html;
	}
}
