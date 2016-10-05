<?php
namespace KVSun\WP_E_Edition;

final class Issue
{
	private $_path = '';
	private $_section = '';
	private $ext = '.pdf';

	public function __construct(Week $week, $section, $ext = '.pdf')
	{
		$this->_path = $week->path;
		$this->_section = $section;
		$this->_ext = $ext;
		if (! file_exists($this)) {
			throw new InvalidArgumentException("$section not found in $week.");
		}
	}

	public function __toString()
	{
		return $this->_path . DIRECTORY_SEPARATOR . $this->_section . $this->_ext;
	}

	public function out()
	{
		header('Content-Type: application/pdf');
		readfile($this);
		exit();
	}
}
