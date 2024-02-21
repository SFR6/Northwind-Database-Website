<?php

class Logins extends Controller
{
	//! Display content page
	function LoginUser($f3, $args)
	{
		require 'requirements.php';

		$users = new DB\SQL\Mapper($db, 'employees');
		$users->email = '';
		$users->password = '';

		$f3->set('users', $users);
		$f3->set('theErrorMessage', '');
		$f3->set('html_title', 'NorthWind - Log In');
		$f3->set('content', 'LoginForm.html');
		echo \Template::instance()->render('Layout.html');
	}

	//! Process form
	function LoginUserAct($f3, $args)
	{
		require 'requirements.php';

		$users = new DB\SQL\Mapper($db, 'Employee');
		$users->email = $_POST['email'];
		$users->password = $_POST['password'];

		$theErrorMessage = '';
		if (Logins::FormValidate($f3, $theErrorMessage, $users)) 
		{
			$userSession = new DB\SQL\Mapper($db, 'Employee');
			$userSession = $userSession->findone(array('UPPER(email) = ? AND password = ?', strtoupper($users->email), $users->password));

			session_start();
			$f3->set('SESSION.session_id', session_id());
			$f3->set('SESSION.users_id', $userSession->Id);
			if (!$userSession->ReportsTo)
			{
				$f3->set('SESSION.users_type', 2);
			}
			else
			{
				$f3->set('SESSION.users_type', 1);
			}
			$f3->set('SESSION.users_name', $userSession->FirstName . ' ' . $userSession->LastName);
	
			$f3->set('html_title', 'NorthWind - Home Page');
			$f3->reroute('/');
		} 
		else 
		{
			$f3->set('users', $users);
			$f3->set('theErrorMessage', $theErrorMessage);
			$f3->set('html_title', 'NorthWind - Log In');
			$f3->set('content', 'LoginForm.html');
			echo \Template::instance()->render('Layout.html');
		}
	}

	function FormValidate($f3, &$theErrorMessage, $users)
	{
		require 'requirements.php';

		$theErrorMessage = '';

		if (!filter_var($users->email, FILTER_VALIDATE_EMAIL)) 
		{
			$theErrorMessage = $theErrorMessage . " - Invalid E Mail format - ";
		}
		$loginUsers = new DB\SQL\Mapper($db, 'Employee');
		$loginUsers->load(array('UPPER(email) = ?', strtoupper($users->email)));
		if ($loginUsers->dry()) 
		{
			$theErrorMessage = $theErrorMessage . " - UserName E-Mail it is not of a registered user - ";
		} 
		else 
		{
			$loginUsersPass = new DB\SQL\Mapper($db, 'Employee');
			$loginUsersPass->load(array('UPPER(email) = ? AND password = ?', strtoupper($users->email), $users->password));
			if ($loginUsersPass->dry()) 
			{
				$theErrorMessage = $theErrorMessage . " - Users E-Mail and PassWord do not Match!";
			}
		}

		return $theErrorMessage == '';
	}

	function LogoutUser($f3, $args)
	{
		require 'requirements.php';

		$f3->clear('SESSION');

		session_unset(); //destroys variables

		$f3->set('html_title', 'NorthWind Product\'s Categories');
		$f3->reroute('/');
	}
}