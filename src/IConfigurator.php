<?php
namespace Librette\Texy;

use Texy\Texy;

/**
 * @author David Matejka
 */
interface IConfigurator
{

	public function configure(Texy $texy);
}
