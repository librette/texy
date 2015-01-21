<?php
namespace Librette\Texy\Configurators;

use Librette\Texy\IConfigurator;
use TexyConfigurator;
use Texy;

/**
 * @author David Matejka
 */
class DisableLinksConfigurator implements IConfigurator
{

	public function configure(Texy $texy)
	{
		TexyConfigurator::disableLinks($texy);
	}

}
