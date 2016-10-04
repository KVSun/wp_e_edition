<?php
namespace KVSun\WP_E_Edition;

final class Scanner extends \ArrayObject
{
	public function __construct(Week $week, $ext = '.pdf')
	{
		$files = glob($week . DIRECTORY_SEPARATOR . "*{$ext}");
		parent::__construct($files);
	}

	public function __toString()
	{
		return json_encode($this->getArrayCopy());
	}
}

