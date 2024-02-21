<?php

//! Base controller
class Controller 
{
	protected $db;

	//! Instantiate class
	function __construct()
	{
		$f3=Base::instance();
		// Connect to the database

		$db=new DB\SQL($f3->get('dbDSN')); // SQLite Database
		$db->exec('PRAGMA foreign_keys = 1;');

		new DB\SQL\Session($db);
		// Save frequently used variables
		$this->db=$db;
	}
}
