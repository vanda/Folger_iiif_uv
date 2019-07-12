<?php

defined("ABSPATH") or die("Nothing to see here.");

class IIIF
{
	private $owner;
	private static $pageShortCodes;
	private $totalCodeCount;
	private static $embedJSEmbeded;
	private $requested_manifest;

	private function setRequestedManifest($manifest) {
		$this->requested_manifest = $manifest;
	}

	private function getRequestedManifest() {
		return $this->requested_manifest;
	}

	private function getOwner() {
		return $this->owner;
	}

	private function setOwner($o) {
		$this->owner = $o;
	}

	private function getTotalCodeCount() {
		return $this->totalCodeCount;
	}

	private function getEmbedJSEmbeded() {
		return $this->embedJSEmbeded;
	}

	private function setEmbedJSEmbeded($embeded) {
		$this->embedJSEmbeded = $embeded;
	}

	private function checkShortCodes($sc) {
		if (count($this->pageShortCodes) > 0) {
			$codeCount = 0;
			foreach($this->pageShortCodes as $key=>$code) {
				$this->totalCodeCount ++;
				if (trim($code) === trim($sc)) {
					$codeCount++;
				};
			};

			$this->pageShortCodes[] = $sc;

			return $codeCount;
		} else {
			$this->pageShortCodes[] = $sc;

			return 0;
		};
	}

	function renderAssetType($input) {
		$retVal .= $this->renderImages($input);

		return $retVal;
	}

	function renderNotFound() {

		$retVal = '<div class="miranda-not-found"><p>We couldn\'t find the record with a dapID of "' . $this->getRequestedDapID() . '"</p>' . $this->viewOnMiranda[0] . 'Try searching on:' . $this->viewOnMiranda[1] . $this->mirandaAddress . '">' . $this->viewOnMiranda[4] . '</div></div>';

		return $retVal;
	}

	function renderImages($input) {

		$elementData = array(
			'data-locale'        => 'en-GB:English (GB)',
			'data-fullscreen'    => '',
			'data-config'        => $this->getOwner()->getPluginPath() . 'include/uv_config.json',
			'data-uri'           => $this->getRequestedManifest(),
			'data-sequenceindex' => '0',
			'data-canvasindex'   => '0',
			'data-rotation'      => '0'
		);

		$elDataString = '';
		foreach ( $elementData as $key => $elData ) {
			$elDataString .= $key . '= "' . $elData . '" ';
		};

		$uvDivScript = '<div class="uv" ' . $elDataString . ' style="width:100%; height: 500px;"></div>';
		$uvDivScript .= '<script type="text/javascript" id="embedUV" src="' . $this->getOwner()->getPluginPath() . 'include/uv/lib/embed.js' . '"></script><script type="text/javascript">/* wordpress fix */</script>';

		return $uvDivScript;
	}

	function UVEmbedShortcode($args) {
		if($args) {
			wp_enqueue_style('iiif-style',$this->getOwner()->getPluginPath() . 'include/iiif-style.css');

			//echo '<pre>' . var_export($return,true) . '</pre>';
			$this->setRequestedManifest($args['manifest']);

			return $this->renderAssetType($return);
		};
		return "";
	}

	function __construct($owner) {
		$this->pageShortCodes = array();
		$this->setOwner($owner);

	}

}
