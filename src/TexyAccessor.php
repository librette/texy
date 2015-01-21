<?php
namespace Librette\Texy;

use Librette\Texy\DI\TexyExtension;
use Nette\DI\Container;
use Nette\Object;

/**
 * @author David Matejka
 */
class TexyAccessor extends Object
{

	/** @var \Nette\DI\Container */
	protected $container;

	/** @var string */
	protected $prefix;


	/**
	 * @param Container
	 * @param string
	 */
	public function __construct(Container $container, $prefix = 'texy')
	{
		$this->container = $container;
		$this->prefix = $prefix;
	}


	/**
	 * @param string
	 * @return Engine
	 */
	public function get($name)
	{
		return $this->container->getService(sprintf('%s.' . TexyExtension::SERVICE_NAME_PATTERN, $this->prefix, $name));
	}

}
