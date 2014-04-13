<?php
namespace Librette\Texy\Caching;

use Librette\Texy\ICachingStrategy;

/**
 * @author David Matejka
 */
class NoCache implements ICachingStrategy
{

	public function load($key, $callback)
	{
		return call_user_func($callback);
	}

}
