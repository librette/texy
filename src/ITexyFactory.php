<?php
namespace Librette\Texy;

/**
 * @author David Matejka
 */
interface ITexyFactory
{

	/**
	 * @return \Texy
	 */
	public function create();
}
