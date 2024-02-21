<?php

class Categories extends Controller
{
	//! Display content of HomePage
	function HomePage($f3, $args)
	{
		require 'requirements.php';

		$f3->set('html_title', 'NorthWind - Home Page');
		$f3->set('content','HomePage.html');
		echo \Template::instance()->render('Layout.html');
	}

	//! Display content of all categories
	function ReadAll($f3, $args)
	{
		require 'requirements.php';

		$categoriesMap=new DB\SQL\Mapper($db,'Category');
		$categories = $categoriesMap->find(array(''),array('order'=>'CategoryName'));

		$f3->set('categories', $categories);
		$f3->set('html_title', 'NorthWind Product\'s Categories');
		$f3->set('content','categoryReadAll.html');
		echo \Template::instance()->render('Layout.html');
	}
}