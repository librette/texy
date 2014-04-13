<?php
namespace Librette\Texy;

/**
 * @author David Matejka
 */
interface ITexyFactory
{

	/**
	 * @return \Texy\Texy
	 */
	public function create();
}
