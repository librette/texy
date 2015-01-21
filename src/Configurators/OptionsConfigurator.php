<?php
namespace Librette\Texy\Configurators;

use Librette\Texy\IConfigurator;
use Texy;

/**
 * @author David Matejka
 */
class OptionsConfigurator implements IConfigurator
{

	/** @var array */
	protected $options = [];


	/**
	 * @param array $options
	 */
	public function __construct(array $options)
	{
		$this->options = $options;
	}


	public function configure(Texy $texy)
	{
		return $this->applyOptions($texy, $this->options);
	}


	/**
	 * @param Texy|object
	 * @param array
	 * @return Texy|object
	 */
	protected function applyOptions($object, $options)
	{
		foreach ($options as $key => $value) {
			if (property_exists($object, $key)) {
				if (is_object($object->{$key})) {
					$this->applyOptions($object->{$key}, $value);
				} elseif (is_array($object->{$key}) and is_array($value)) {
					$object->{$key} = array_merge($object->{$key}, $value);
				} else {
					$object->{$key} = $value;
				}

			}
		}

		return $object;
	}
}
