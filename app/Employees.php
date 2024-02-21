<?php

class Employees extends Controller
{
	function Create($f3)
	{
		require 'requirements.php';

		$employee = new DB\SQL\Mapper($db, 'Employee');
		$managersMap = new DB\SQL\Mapper($db, 'Employee');
		$managers = $managersMap->find(array(''), array('order' => 'LastName, FirstName'));

		$f3->set('managers', $managers);
		$f3->set('employee', $employee);
		$f3->set('theErrorMessage', '');
		$f3->set('html_title', 'NorthWind - Create New Employee');
		$f3->set('content', 'employeeCreate.html');
		echo \Template::instance()->render('Layout.html');
	}

	function ValidCreate($f3, &$theErrorMessage, $employee, $PassWordR)
	{
		require 'requirements.php';

		if (!preg_match("/^[a-zA-Z-' ]*$/", $employee->FirstName)) 
		{
			$theErrorMessage = $theErrorMessage . " - in First Name: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $employee->LastName)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Last Name: Only letters and white space are allowed - ";
		}
		$dob = DateTime::createFromFormat('Y-m-d', $employee->BirthDate);
		if (!($dob && $dob->format('Y-m-d') === $employee->BirthDate)) 
		{
			$theErrorMessage = $theErrorMessage . " - Date of Birth is not a valid calendar Date - ";
		}
		$doh = DateTime::createFromFormat('Y-m-d', $employee->HireDate);
		if (!($doh && $doh->format('Y-m-d') === $employee->HireDate)) 
		{
			$theErrorMessage = $theErrorMessage . " - Date of Hire is not a valid calendar Date - ";
		}
		if (!($dob < $doh)) 
		{
			$theErrorMessage = $theErrorMessage . " - Hire before Birth - ";
		}
		if ($employee->salary < 0) 
		{
			$theErrorMessage = $theErrorMessage . " - Salary could not be Negative value - ";
		}

		if (!filter_var($employee->email, FILTER_VALIDATE_EMAIL)) 
		{
			$theErrorMessage = $theErrorMessage . " - E-Mail it is not in a valid format - ";
		}
		if (!($employee->password == $PassWordR)) 
		{
			$theErrorMessage = $theErrorMessage . " - PassWords Do Not Match - ";
		}

		$employees1 = new DB\SQL\Mapper($db, 'Employee');
		$employees1->load(array('UPPER(email) = ? ', strtoupper($employee->email)));
		if (!$employees1->dry()) 
		{
			$theErrorMessage = $theErrorMessage . " - E Mail is Not UNIQUE - ";
		}
		$employees2 = new DB\SQL\Mapper($db, 'Employee');
		$employees2->load(array('UPPER(FirstName) = ? AND UPPER(LastName) = ?', strtoupper($employee->FirstName), strtoupper($employee->LastName)));
		if (!$employees2->dry())
		{
			$theErrorMessage = $theErrorMessage . " - Name is Not UNIQUE - ";
		}

		return $theErrorMessage == '';
	}

	function CreateAct($f3)
	{
		require 'requirements.php';

		$employee = new DB\SQL\Mapper($db, 'Employee');
		$employee->copyFrom('POST');
		$PassWordR = $_POST['PassWordR'];
		if ($employee->ReportsTo == 0)
		{
			$employee->ReportsTo = NULL;
		}
		$theErrorMessage = '';
		if (Employees::ValidCreate($f3, $theErrorMessage, $employee, $PassWordR)) 
		{
			$employee->save();

			$filename = $_FILES['picture']['name'];
			$tempname = $_FILES['picture']['tmp_name'];
			if (!empty($filename)) 
			{
				$rows = $db->exec('SELECT MAX(Id) AS LastId FROM Employee;');
				foreach ($rows as $row)
					$Id = $row['LastId'];
				$employeeMap = new DB\SQL\Mapper($db, 'Employee');
				$employee = $employeeMap->findone(array('Id = ?', $Id));

				$filename = strval($employee->Id) . $employee->LastName . '.jpg';
				$employee->PhotoPath = $filename;
				$folder = "assets/" . $filename;
				move_uploaded_file($tempname, $folder);
				$employee->save();
			}
			$f3->reroute('/');
		} 
		else 
		{
			$managersMap = new DB\SQL\Mapper($db, 'Employee');
			$managers = $managersMap->find(array(''), array('order' => 'LastName, FirstName'));
			$f3->set('managers', $managers);
			$f3->set('employee', $employee);
			$f3->set('theErrorMessage', $theErrorMessage);
			$f3->set('html_title', 'NorthWind - Create New Employee');
			$f3->set('content', 'employeeCreate.html');
			echo \Template::instance()->render('Layout.html');
		}
	}

	function ReadAll($f3, $args)
	{
		require 'requirements.php';

		$employeesMap = new DB\SQL\Mapper($db, 'Employee');
		$employees = $employeesMap->find(array(''), array('order' => 'LastName, FirstName'));

		$f3->set('employees', $employees);
		$f3->set('html_title', 'NorthWind Employees');
		$f3->set('content', 'employeeReadAll.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Read1($f3, $args)
	{
		require 'requirements.php';

		$employeeMap = new DB\SQL\Mapper($db, 'EmployeeManager');
		$employee = $employeeMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

		$f3->set('employee', $employee);
		$f3->set('html_title', 'NorthWind Employee');
		$f3->set('content', 'employeeRead1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Browse($f3, $args)
	{
		require 'requirements.php';

		$employeesMap = new DB\SQL\Mapper($db, 'Employee');
		$employees = $employeesMap->find(array(''), array('order' => 'LastName, FirstName'));

		$f3->set('employees', $employees);
		$f3->set('html_title', 'NorthWind Employees');
		$f3->set('content', 'employeeBrowse.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Browse2($f3, $args)
	{
		require 'requirements.php';

		$employeesMap = new DB\SQL\Mapper($db, 'Employee');
		$employees = $employeesMap->find(array(''), array('order' => 'LastName, FirstName'));

		$f3->set('employees', $employees);
		$f3->set('html_title', 'NorthWind Employees');
		$f3->set('content', 'employeeBrowse2.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Update1($f3, $args)
	{
		require 'requirements.php';

		$employeeMap = new DB\SQL\Mapper($db, 'Employee');
		$employee = $employeeMap->findone(array('Id = ?', $f3->get('PARAMS.id')));
		
		$managersMap = new DB\SQL\Mapper($db, 'Employee');
		$managers = $managersMap->find(array(''), array('order' => 'LastName, FirstName'));

		$f3->set('managers', $managers);
		$f3->set('employee', $employee);
		$f3->set('theErrorMessage', '');
		$f3->set('html_title', 'NorthWind Employee - UPDATE');
		$f3->set('content', 'employeeUpdate1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function ValidUpdate($f3, &$theErrorMessage, $employee, $PassWordR)
	{
		require 'requirements.php';

		if (!preg_match("/^[a-zA-Z-' ]*$/", $employee->FirstName)) 
		{
			$theErrorMessage = $theErrorMessage . " - in First Name: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $employee->LastName)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Last Name: Only letters and white space are allowed - ";
		}
		$dob = DateTime::createFromFormat('Y-m-d', $employee->BirthDate);
		if (!($dob && $dob->format('Y-m-d') === $employee->BirthDate)) 
		{
			$theErrorMessage = $theErrorMessage . " - Date of Birth is not a valid calendar Date - ";
		}
		$doh = DateTime::createFromFormat('Y-m-d', $employee->HireDate);
		if (!($doh && $doh->format('Y-m-d') === $employee->HireDate)) 
		{
			$theErrorMessage = $theErrorMessage . " - Date of Hire is not a valid calendar Date - ";
		}
		if (!($dob < $doh)) 
		{
			$theErrorMessage = $theErrorMessage . " - Hire before Birth - ";
		}
		if ($employee->salary < 0) 
		{
			$theErrorMessage = $theErrorMessage . " - Salary could not be Negative value - ";
		}

		if (!filter_var($employee->email, FILTER_VALIDATE_EMAIL)) 
		{
			$theErrorMessage = $theErrorMessage . " - E-Mail it is not in a valid format - ";
		}
		if (!($employee->password == $PassWordR)) 
		{
			$theErrorMessage = $theErrorMessage . " - PassWords Do Not Match - ";
		}

		$employees1 = new DB\SQL\Mapper($db, 'Employee');
		$employees1->load(array('UPPER(email) = ? AND Id != ?', strtoupper($employee->email), $employee->Id));
		if (!$employees1->dry()) 
		{
			$theErrorMessage = $theErrorMessage . " - E Mail is Not UNIQUE - ";
		}
		$employees2 = new DB\SQL\Mapper($db, 'Employee');
		$employees2->load(array('UPPER(FirstName) = ? AND UPPER(LastName) = ? AND Id != ?', strtoupper($employee->FirstName), strtoupper($employee->LastName), $employee->Id));
		if (!$employees2->dry()) 
		{
			$theErrorMessage = $theErrorMessage . " - Name is Not UNIQUE - ";
		}

		return $theErrorMessage == '';
	}

	function Update1Act($f3)
	{
		require 'requirements.php';

		if (isset($_POST['cancel'])) 
		{
			$f3->reroute('/employeeUpdateAll');
		}

		if (isset($_POST['update'])) 
		{

			$employeeOldMap = new DB\SQL\Mapper($db, 'Employee');
			$employeeOld = $employeeOldMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

			$employeeMap = new DB\SQL\Mapper($db, 'Employee');
			$employee = $employeeMap->findone(array('Id = ?', $f3->get('PARAMS.id')));
			$employee->copyFrom('POST');
			$PassWordR = $_POST['PassWordR'];
			if ($employee->password == '') 
			{
				$employee->password = $employeeOld->password;
				$PassWordR = $employee->password;
			}
			if ($employee->PhotoPath == '') 
			{
				$employee->PhotoPath = $employeeOld->PhotoPath;
			}

			$theErrorMessage = '';
			if (Employees::ValidUpdate($f3, $theErrorMessage, $employee, $PassWordR)) 
			{
				$filename = $_FILES['picture']['name'];
				$tempname = $_FILES['picture']['tmp_name'];

				if (!empty($filename)) 
				{
					$filename = strval($employee->Id) . $employee->LastName . '.jpg';
					$employee->PhotoPath = $filename;
					$folder = "assets/" . $filename;
					move_uploaded_file($tempname, $folder);
				}

				$employee->save();

				$success = 'updated';
				$f3->set('success', $success);
				$employeeMap = new DB\SQL\Mapper($db, 'EmployeeManager');
				$employee = $employeeMap->findone(array('Id = ?', $f3->get('PARAMS.id')));
				$f3->set('employee', $employee);
				$f3->set('html_title', 'NorthWind Employee - UPDATE Effect');
				$f3->set('content', 'employeeUpdate1Effect.html');
				echo \Template::instance()->render('Layout.html');
			} 
			else 
			{
				$managersMap = new DB\SQL\Mapper($db, 'Employee');
				$managers = $managersMap->find(array(''), array('order' => 'LastName, FirstName'));

				$f3->set('managers', $managers);
				$f3->set('employee', $employee);
				$f3->set('theErrorMessage', $theErrorMessage);
				$f3->set('html_title', 'NorthWind Employee - UPDATE');
				$f3->set('content', 'employeeUpdate1.html');
				echo \Template::instance()->render('Layout.html');
			}
		}
	}

	function Delete1($f3, $args)
	{
		require 'requirements.php';

		$employeeMap = new DB\SQL\Mapper($db, 'EmployeeManager');
		$employee = $employeeMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

		$f3->set('employee', $employee);
		$f3->set('html_title', 'NorthWind Employee - DELETE');
		$f3->set('content', 'employeeDelete1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Delete1Act($f3)
	{
		require 'requirements.php';

		if (isset($_POST['cancel'])) 
		{
			$f3->reroute('/employeeDeleteAll');
		}

		if (isset($_POST['delete'])) 
		{
			$employeeMap = new DB\SQL\Mapper($db, 'EmployeeManager');
			$employee = $employeeMap->findone(array('Id = ?', $f3->get('PARAMS.id')));
			$f3->set('employee', $employee);

			$employeeDelMap = new DB\SQL\Mapper($db, 'Employee');
			$employeeDel = $employeeDelMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

			$employeeRep = new DB\SQL\Mapper($db, 'Employee');
			$employeeRep->load(array('ReportsTo = ?', $f3->get('PARAMS.id')));
			$employeeTer = new DB\SQL\Mapper($db, 'EmployeeTerritory');
			$employeeTer->load(array('EmployeeId = ?', $f3->get('PARAMS.id')));
			$employeeOrd = new DB\SQL\Mapper($db, 'Order');
			$employeeOrd->load(array('EmployeeId = ?', $f3->get('PARAMS.id')));

			if ($employeeRep->dry() and $employeeTer->dry() and $employeeOrd->dry()) 
			{
				$success = 'deleted';
				$employeeDel->erase();
			} 
			else
			{
				$success = 'unsuccessful';
			}

			$f3->set('success', $success);
			$f3->set('html_title', 'NorthWind Employee - DELETE Effect');
			$f3->set('content', 'employeeDelete1Effect.html');
			echo \Template::instance()->render('Layout.html');
		}
	}

	function MyUpdate1($f3, $args)
	{
		require 'requirements.php';

		$myForm = new class
		{
		}; // Instantiate anonymous class

		$employeeMap = new DB\SQL\Mapper($db, 'Employee');
		$employee = $employeeMap->findone(array('Id = ?', $f3->get('users_id')));

		$myForm->Id = $employee->Id;
		$myForm->FirstName = $employee->FirstName;
		$myForm->LastName = $employee->LastName;
		$myForm->Title = $employee->Title;
		$myForm->TitleOfCourtesy = $employee->TitleOfCourtesy;
		$myForm->PhotoPath = $employee->PhotoPath;

		$f3->set('myForm', $myForm);
		$f3->set('theErrorMessage', '');
		$f3->set('html_title', 'NorthWind - My Employee');
		$f3->set('content', 'employeeMyUpdate.html');
		echo \Template::instance()->render('Layout.html');
	}

	function MyUpdate1Act($f3, $args)
	{
		require 'requirements.php';

		$myForm = new class
		{
		}; // Instantiate anonymous class
		$myForm->Id = $_POST['Id'];
		$myForm->LastName = $_POST['LastName'];

		$filename = $_FILES['picture']['name'];
		$tempname = $_FILES['picture']['tmp_name'];

		if (!empty($filename)) 
		{
			$employeeMap = new DB\SQL\Mapper($db, 'Employee');
			$employee = $employeeMap->findone(array('Id = ?', $myForm->Id));
			$filename = strval($myForm->Id) . $myForm->LastName . '.jpg';
			$employee->PhotoPath = $filename;
			$employee->save();
			$folder = "assets/" . $filename;
			move_uploaded_file($tempname, $folder);
			$f3->reroute('/');
		} 
		else 
		{
			$f3->reroute('/');
		}
	}
}