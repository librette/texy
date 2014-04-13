<?php
namespace Librette\Texy\Configurators;

use Librette\Texy\IConfigurator;
use Texy\Configurator;
use Texy\Texy;

/**
 * @author David Matejka
 */
class DisableLinksConfigurator implements IConfigurator
{

	public function configure(Texy $texy)
	{
		Configurator::disableLinks($texy);
	}

}
