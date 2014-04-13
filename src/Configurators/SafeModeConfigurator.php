<?php
namespace Librette\Texy\Configurators;

use Librette\Texy\IConfigurator;
use Texy\Configurator;
use Texy\Texy;

/**
 * @author David Matejka
 */
class SafeModeConfigurator implements IConfigurator
{

	public function configure(Texy $texy)
	{
		Configurator::safeMode($texy);
	}

}
