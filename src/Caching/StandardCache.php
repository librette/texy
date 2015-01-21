<?php
namespace Librette\Texy\Caching;

use Librette\Texy\ICachingStrategy;
use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Nette\Object;

/**
 * @author David Matejka
 */
class StandardCache extends Object implements ICachingStrategy
{

	const CACHE_NAMESPACE = "Librette.Texy";

	/** @var \Nette\Caching\Cache */
	protected $cache;

	/** @var array */
	protected $dependencies = [];


	/**
	 * @param array
	 * @param IStorage
	 */
	public function __construct(array $dependencies, IStorage $cacheStorage)
	{
		$this->cache = new Cache($cacheStorage, self::CACHE_NAMESPACE);
		$this->dependencies = $dependencies;
	}


	/**
	 * @return array
	 */
	public function getDependencies()
	{
		return $this->dependencies;
	}


	/**
	 * @param array
	 */
	public function setDependencies($dependencies)
	{
		$this->dependencies = $dependencies;
	}


	public function load($key, $callback)
	{
		return $this->cache->load($key, function (&$dependencies) use ($callback) {
			$dependencies = $this->dependencies;

			return call_user_func($callback);
		});
	}

}
