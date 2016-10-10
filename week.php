<?php
namespace KVSun\WP_E_Edition;

final class Week extends \DateTime
{
	const DIR = 'Y m d';

	private $_root;

	public $path;

	public function __construct($root, $date = null)
	{
		if ($date instanceof \DateTimeInterface) {
			$date = $date->format(self::W3C);
		}
		if (! is_dir($root)) {
			throw new \InvalidArgumentException("{$root} is not a directory.", 500);
		}

		$this->_root  = rtrim($root, DIRECTORY_SEPARATOR);
		parent::__construct($date);
		if ($this->getTimestamp() > time()) {
			throw new \InvalidArgumentException('Request made for future date', 404);
		}
		$this->path = $this->_root . DIRECTORY_SEPARATOR . $this;
	}

	public function __isset($section)
	{
		return file_exists($this->path . DIRECTORY_SEPARATOR . $section . '.pdf');
	}

	public function __get($section)
	{
		if ($this->__isset($section))
		{
			return new Issue($this, $section);
		} else {
			throw new \Exception("$section not found in $week.", 500);
		}
	}

	public function scan($ext = '.pdf')
	{
		return new Scanner($this, $this->_root, $ext);
	}

	public function __toString()
	{
		$format = str_replace(' ', DIRECTORY_SEPARATOR, self::DIR);
		return $this->format($format);
	}
}
