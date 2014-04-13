<?php
namespace Librette\Texy\Configurators;

use Librette\Texy\IConfigurator;
use Texy\Configurator;
use Texy\Texy;

/**
 * @author David Matejka
 */
class DisableImagesConfigurator implements IConfigurator
{

	public function configure(Texy $texy)
	{
		Configurator::disableImages($texy);
	}

}
