<?php
namespace KVSun\WP_E_Edition;

final class Week extends \DateTime
{
	const DIR = 'Y m d';

	private $_root;

	public function __construct($root, $date = null)
	{
		if (! is_dir($root)) {
			throw new \InvalidArgumentExcaption("{$root} is not a directory.", 500);
		}

		$this->_root  = rtrim($root, DIRECTORY_SEPARATOR);
		parent::__construct($date);
	}

	public function __toString()
	{
		$format = str_replace(' ', DIRECTORY_SEPARATOR, self::DIR);
		return $this->_root . DIRECTORY_SEPARATOR . $this->format($format);
	}
}

