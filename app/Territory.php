<?php

class Territory extends Controller
{
	function ReadAll($f3, $args)
	{
		require 'requirements.php';

		$resultMap = new DB\SQL\Mapper($db, 'EmployeesTerritories');
		$result = $resultMap->find(array(''), array('order' => 'EID'));

		$f3->set('result', $result);
		$f3->set('html_title', 'Employees\' Territories');
		$f3->set('content', 'territoryReadAll.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Read1($f3, $args)
	{
		require 'requirements.php';

		$employeeMap = new DB\SQL\Mapper($db, 'Employee');
		$employee = $employeeMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

		$resultMap = new DB\SQL\Mapper($db, 'EmployeeTerritories');
		$result = $resultMap->find(array('EID = ?', $f3->get('PARAMS.id')), array('order' => 'TerritoryDescription'));

		$f3->set('employee', $employee);
		$f3->set('result', $result);
		$f3->set('html_title', 'Employee\'s Territories');
		$f3->set('content', 'territoryRead1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function ReadOne($f3, $args)
	{
		require 'requirements.php';

		$resultMap = new DB\SQL\Mapper($db, 'EmployeeTerritories');
		$result = $resultMap->findone(array('TerritoryId = ?', $f3->get('PARAMS.id')));

		$employeeMap = new DB\SQL\Mapper($db, 'Employee');
		$employee = $employeeMap->findone(array('Id = ?', $result->EID));

		$territoryMap = new DB\SQL\Mapper($db, 'Territory');
		$territory = $territoryMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

		$regionMap = new DB\SQL\Mapper($db, 'Region');
		$region = $regionMap->findone(array('Id = ?', $territory->RegionId));

		$f3->set('employee', $employee);
		$f3->set('territory', $territory);
		$f3->set('region', $region);
		$f3->set('html_title', 'Territory');
		$f3->set('content', 'territoryReadOne.html');
		echo \Template::instance()->render('Layout.html');
	}

	function MyRead1($f3, $args)
	{
		require 'requirements.php';

		$employeeMap = new DB\SQL\Mapper($db, 'Employee');
		$employee = $employeeMap->findone(array('Id = ?', $f3->get('users_id')));

		$resultMap = new DB\SQL\Mapper($db, 'EmployeeTerritories');
		$result = $resultMap->find(array('EID=?', $f3->get('users_id')), array('order' => 'TerritoryDescription'));

		$f3->set('employee', $employee);
		$f3->set('result', $result);
		$f3->set('html_title', 'Employee\'s Territories');
		$f3->set('content', 'territoryRead1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Create($f3)
	{
		require 'requirements.php';

		$regionMap = new DB\SQL\Mapper($db, 'Region');
		$region = $regionMap->find(array(''), array('order' => 'Id'));
		
		$employeeMap = new DB\SQL\Mapper($db, 'Employee');
		$employee = $employeeMap->find(array(''), array('order' => 'Id'));

		$territoryMap = new DB\SQL\Mapper($db, 'Territory');

		$employeeTerritoryMap = new DB\SQL\Mapper($db, 'EmployeeTerritory');

		$f3->set('region', $region);
		$f3->set('employee', $employee);
		$f3->set('territory', $territoryMap);
		$f3->set('employeeTerritory', $employeeTerritoryMap);
		$f3->set('theErrorMessage', '');
		$f3->set('html_title', 'NorthWind - Create New Territory');
		$f3->set('content', 'territoryCreate.html');
		echo \Template::instance()->render('Layout.html');
	}

	function ValidCreate($f3, &$theErrorMessage, $territoryMap)
	{
		require 'requirements.php';

		if (!preg_match("/^[a-zA-Z-' ]*$/", $territoryMap->TerritoryDescription)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Territory Name: Only letters and white space are allowed - ";
		}

		$territoryMap1 = new DB\SQL\Mapper($db, 'Territory');
		$territoryMap1->load(array('UPPER(TerritoryDescription) = ? ', strtoupper($territoryMap->TerritoryDescription)));
		if (!$territoryMap1->dry()) 
		{
			$theErrorMessage = $theErrorMessage . " - Territory Name is Not UNIQUE - ";
		}

		return $theErrorMessage == '';
	}

	function CreateAct($f3)
	{
		require 'requirements.php';

		$territoryMap = new DB\SQL\Mapper($db, 'Territory');
		$territoryMap->copyfrom('POST');

		$theErrorMessage = '';
		if (Territory::ValidCreate($f3, $theErrorMessage, $territoryMap))
		{
			$characters = '0123456789';
			$TerritoryId;
			$territoryMap1;
			do
			{
				$TerritoryId = '';
				for ($i = 1; $i <= 5; $i++)
				{
					$TerritoryId .= $characters[rand(0, strlen($characters) - 1)];
				}
				$territoryMap1 = new DB\SQL\Mapper($db, 'Territory');
				$territoryMap1->load(array('Id = ?', $TerritoryId));
			} while (!$territoryMap1->dry());

			$sql1 = "INSERT INTO Territory (Id, TerritoryDescription, RegionId) VALUES (?,?,?)";
			$stmt1= $db->prepare($sql1);
			$stmt1->execute([$TerritoryId, $f3->get('POST.TerritoryDescription'), $f3->get('POST.RegionId')]);

			$EmployeeId = $f3->get('POST.EmployeeId');
			$Id = $EmployeeId . "/" . $TerritoryId;

			$sql2 = "INSERT INTO EmployeeTerritory (Id, EmployeeId, TerritoryId) VALUES (?,?,?)";
			$stmt2= $db->prepare($sql2);
			$stmt2->execute([$Id, $EmployeeId, $TerritoryId]);
			
			$f3->reroute('/');
		} 
		else 
		{
			$regionMap = new DB\SQL\Mapper($db, 'Region');
			$region = $regionMap->find(array(''), array('order' => 'Id'));
			
			$employeeMap = new DB\SQL\Mapper($db, 'Employee');
			$employee = $employeeMap->find(array(''), array('order' => 'Id'));
	
			$territoryMap = new DB\SQL\Mapper($db, 'Territory');

			$employeeTerritoryMap = new DB\SQL\Mapper($db, 'EmployeeTerritory');
	
			$f3->set('region', $region);
			$f3->set('employee', $employee);
			$f3->set('territory', $territoryMap);
			$f3->set('employeeTerritory', $employeeTerritoryMap);
			$f3->set('theErrorMessage', $theErrorMessage);
			$f3->set('html_title', 'NorthWind - Create New Territory');
			$f3->set('content', 'territoryCreate.html');
			echo \Template::instance()->render('Layout.html');
		}
	}

	function Browse($f3, $args)
	{
		require 'requirements.php';

		$territoriesMap = new DB\SQL\Mapper($db, 'Territory');
		$territories = $territoriesMap->find(array(''), array('order' => 'TerritoryDescription'));

		$f3->set('territories', $territories);
		$f3->set('html_title', 'NorthWind Territories');
		$f3->set('content', 'territoryBrowse.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Browse2($f3, $args)
	{
		require 'requirements.php';

		$territoriesMap = new DB\SQL\Mapper($db, 'Territory');
		$territories = $territoriesMap->find(array(''), array('order' => 'TerritoryDescription'));

		$f3->set('territories', $territories);
		$f3->set('html_title', 'NorthWind Territories');
		$f3->set('content', 'territoryBrowse2.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Update1($f3, $args)
	{
		require 'requirements.php';

		$regionMap = new DB\SQL\Mapper($db, 'Region');
		$region = $regionMap->find(array(''), array('order' => 'Id'));
		
		$employeeMap = new DB\SQL\Mapper($db, 'Employee');
		$employee = $employeeMap->find(array(''), array('order' => 'Id'));

		$territoryMap = new DB\SQL\Mapper($db, 'Territory');
		$territory = $territoryMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

		$employeeTerritoryMap = new DB\SQL\Mapper($db, 'EmployeeTerritory');
		$employeeTerritory = $employeeTerritoryMap->findone(array('TerritoryId = ?', $f3->get('PARAMS.id')));

		$f3->set('region', $region);
		$f3->set('employee', $employee);
		$f3->set('territory', $territory);
		$f3->set('employeeTerritory', $employeeTerritory);
		$f3->set('theErrorMessage', '');
		$f3->set('html_title', 'NorthWind Territory - UPDATE');
		$f3->set('content', 'territoryUpdate1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function ValidUpdate($f3, &$theErrorMessage, $territoryMap)
	{
		require 'requirements.php';

		if (!preg_match("/^[a-zA-Z-' ]*$/", $territoryMap->TerritoryDescription)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Territory Name: Only letters and white space are allowed - ";
		}

		$territoryMap1 = new DB\SQL\Mapper($db, 'Territory');
		$territoryMap1->load(array('UPPER(TerritoryDescription) = ? AND Id != ?', strtoupper($territoryMap->TerritoryDescription), $territoryMap->Id));
		if (!$territoryMap1->dry()) 
		{
			$theErrorMessage = $theErrorMessage . " - Territory Name is Not UNIQUE - ";
		}

		return $theErrorMessage == '';
	}

	function Update1Act($f3)
	{
		require 'requirements.php';

		if (isset($_POST['cancel'])) 
		{
			$f3->reroute('/territoryUpdateAll');
		}

		if (isset($_POST['update'])) 
		{
			$territoryMap = new DB\SQL\Mapper($db, 'Territory');
			$territoryMap->copyFrom('POST');

			$theErrorMessage = '';
			if (Territory::ValidUpdate($f3, $theErrorMessage, $territoryMap))
			{
				$sql0 = "UPDATE Territory SET TerritoryDescription = ? WHERE Id = ?";
				$stmt0 = $db->prepare($sql0);
				$stmt0->execute([$f3->get('POST.TerritoryDescription'), $f3->get('PARAMS.id')]);

				$EmployeeId = $f3->get('POST.EmployeeId');
				$TerritoryId = $territoryMap->Id;
				$Id = $EmployeeId . "/" . $TerritoryId;
	
				$sql = "UPDATE EmployeeTerritory SET Id = ?, EmployeeId = ? WHERE TerritoryId = ?";
				$stmt= $db->prepare($sql);
				$stmt->execute([$Id, $EmployeeId, $TerritoryId]);
				
				$employeeMap = new DB\SQL\Mapper($db, 'Employee');
				$employee = $employeeMap->findone(array('Id = ?', $EmployeeId));

				$territoryMap = new DB\SQL\Mapper($db, 'Territory');
				$territory = $territoryMap->findone(array('Id = ?', $TerritoryId));

				$regionMap = new DB\SQL\Mapper($db, 'Region');
				$region = $regionMap->findone(array('Id = ?', $f3->get('POST.RegionId')));

				$success = 'updated';

				$f3->set('employee', $employee);
				$f3->set('territory', $territory);
				$f3->set('region', $region);
				$f3->set('success', $success);
				$f3->set('html_title', 'NorthWind Territory - UPDATE Effect');
				$f3->set('content', 'territoryUpdate1Effect.html');
				echo \Template::instance()->render('Layout.html');
			} 
			else 
			{
				$regionMap = new DB\SQL\Mapper($db, 'Region');
				$region = $regionMap->find(array(''), array('order' => 'Id'));
				
				$employeeMap = new DB\SQL\Mapper($db, 'Employee');
				$employee = $employeeMap->find(array(''), array('order' => 'Id'));
		
				$territoryMap = new DB\SQL\Mapper($db, 'Territory');
				$territory = $territoryMap->findone(array('Id = ?', $f3->get('PARAMS.id')));
		
				$employeeTerritoryMap = new DB\SQL\Mapper($db, 'EmployeeTerritory');
				$employeeTerritory = $employeeTerritoryMap->findone(array('TerritoryId = ?', $f3->get('PARAMS.id')));
		
				$f3->set('region', $region);
				$f3->set('employee', $employee);
				$f3->set('territory', $territory);
				$f3->set('employeeTerritory', $employeeTerritory);
				$f3->set('theErrorMessage', $theErrorMessage);
				$f3->set('html_title', 'NorthWind Territory - UPDATE');
				$f3->set('content', 'territoryUpdate1.html');
				echo \Template::instance()->render('Layout.html');
			}
		}
	}

	function Delete1($f3, $args)
	{
		require 'requirements.php';

		$territoryMap = new DB\SQL\Mapper($db, 'Territory');
		$territory = $territoryMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

		$employeeTerritoryMap = new DB\SQL\Mapper($db, 'EmployeeTerritory');
		$employeeTerritory = $employeeTerritoryMap->findone(array('TerritoryId = ?', $f3->get('PARAMS.id')));

		$employeeMap = new DB\SQL\Mapper($db, 'Employee');
		$employee = $employeeMap->findone(array('Id = ?', $employeeTerritory->EmployeeId));

		$regionMap = new DB\SQL\Mapper($db, 'Region');
		$region = $regionMap->findone(array('Id = ?', $territory->RegionId));

		$f3->set('territory', $territory);
		$f3->set('employee', $employee);
		$f3->set('region', $region);
		$f3->set('html_title', 'NorthWind Territory - DELETE');
		$f3->set('content', 'territoryDelete1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Delete1Act($f3)
	{
		require 'requirements.php';

		if (isset($_POST['cancel'])) 
		{
			$f3->reroute('/territoryDeleteAll');
		}

		if (isset($_POST['delete'])) 
		{
			$territoryMap = new DB\SQL\Mapper($db, 'Territory');
			$territory = $territoryMap->findone(array('Id = ?', $f3->get('PARAMS.id')));
	
			$employeeTerritoryMap = new DB\SQL\Mapper($db, 'EmployeeTerritory');
			$employeeTerritory = $employeeTerritoryMap->findone(array('TerritoryId = ?', $f3->get('PARAMS.id')));
	
			$employeeMap = new DB\SQL\Mapper($db, 'Employee');
			$employee = $employeeMap->findone(array('Id = ?', $employeeTerritory->EmployeeId));
	
			$regionMap = new DB\SQL\Mapper($db, 'Region');
			$region = $regionMap->findone(array('Id = ?', $territory->RegionId));

			$f3->set('territory', $territory);
			$f3->set('employee', $employee);
			$f3->set('region', $region);
			
			$territoryDelMap = new DB\SQL\Mapper($db, 'Territory');
			$territoryDel = $territoryDelMap->findone(array('Id = ?', $f3->get('PARAMS.id')));
	
			$employeeTerritoryDelMap = new DB\SQL\Mapper($db, 'EmployeeTerritory');
			$employeeTerritoryDel = $employeeTerritoryDelMap->findone(array('TerritoryId = ?', $f3->get('PARAMS.id')));

			$employeeTerritoryDel->erase();
			$territoryDel->erase();

			$success = 'deleted';

			$f3->set('success', $success);
			$f3->set('html_title', 'NorthWind Territory - DELETE Effect');
			$f3->set('content', 'territoryDelete1Effect.html');
			echo \Template::instance()->render('Layout.html');
		}
	}
}