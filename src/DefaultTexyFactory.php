<?php
namespace Librette\Texy;

use Nette\Object;
use Texy;

/**
 * @author David Matejka
 */
class DefaultTexyFactory extends Object implements ITexyFactory
{

	/** @var IConfigurator[] */
	protected $configurators = [];


	/**
	 * @param IConfigurator $configurator
	 */
	public function addConfigurator(IConfigurator $configurator)
	{
		$this->configurators[] = $configurator;
	}


	public function create()
	{
		$texy = new Texy();
		$configurators = $this->configurators;
		foreach ($configurators as $configurator) {
			$configurator->configure($texy);
		}

		return $texy;
	}
}
