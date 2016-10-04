<?php
namespace KVSun\WP_E_Edition;

class Edition
{
	private $_date = null;
	private $_root;
	private $_ext = Consts::EXT;

	public function __construct(
		$dir,
		Week $date = null,
		$ext = Consts::EXT
	)
	{
		if (! is_dir($dir)) {
			throw new \InvalidArgumentExcaption("{$dir} is not a valid directory.", 500);
		} else {
			$this->_root = $dir;
		}
		$this->_date = $date;
	}

	public function __isset($section)
	{
		return file_exists($this . DIRECTORY_SEPARATOR . $section . $this->_ext);
	}

	public function __get($section)
	{
		if ($this->__isset($section)) {
			return file_get_contents($this . DIRECTORY_SEPARATOR . $section. $this->_ext);
		}
	}

	public function __invoke($section)
	{
		if ($this->__isset($section)) {
			\shgysk8zer0\Core\Headers::getInstance()->Content_Type = Consts\CONTENT_TYPE;
			readfile($this . DIRECTORY_SEPARATOR . $section . $this->_ext);
		} else {
			throw new \Exception("Unable to locate {$section} in '{$this}'", 404);
		}
	}

	public function __toString()
	{
		if ($this->_date instanceof Week) {
			return "{$week}";
		} else {
			return rtrim($this->_root, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
		}
	}
}

