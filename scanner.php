<?php
namespace KVSun\WP_E_Edition;

final class Scanner extends \ArrayObject
{
	private $_week;
	public function __construct(Week $week, $root, $ext = '.pdf')
	{
		$this->_week = $week;
		$path = $root . DIRECTORY_SEPARATOR . $week;
		if (! is_dir($path)) {
			throw new \InvalidArgumentException("Invalid directory: '{$path}'", 500);
		}
		$files = glob($path . DIRECTORY_SEPARATOR . "*{$ext}");
		$files = array_map([$this, '_trimmedPath'], $files);
		parent::__construct($files);
	}

	public function __toString()
	{
		return json_encode(["{$this->_week}" => $this->getArrayCopy()]);
	}

	private function _trimmedPath(&$file, $ext = '.pdf')
	{
		return basename($file, $ext);
	}

	private function _getIssues()
	{
		return array_map([$this, '_getIssue'], $this->getArrayCopy());
	}

	private function _getIssue($section)
	{
		return new Issue($this->_week, $section);
	}
}

