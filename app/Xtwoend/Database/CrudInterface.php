<?php namespace Xtwoend\Database;

interface CrudInterface {
	public function getAll();
	public function getById($id);
	public function create(array $attribut);
	public function update($id, array $attribut)
	public function remove($id);	
} 