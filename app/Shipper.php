<?php

class Shipper extends Controller
{
	function ReadAll($f3, $args)
	{
		require 'requirements.php';

		$shippersMap = new DB\SQL\Mapper($db, 'Shipper');
		$shippers = $shippersMap->find(array(''), array('order' => 'CompanyName'));

		$f3->set('shippers', $shippers);
		$f3->set('html_title', 'Shippers');
		$f3->set('content', 'shipperReadAll.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Read1($f3, $args)
	{
		require 'requirements.php';

		$shipperMap = new DB\SQL\Mapper($db, 'Shipper');
		$shipper = $shipperMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

		$f3->set('shipper', $shipper);
		$f3->set('html_title', 'Shipper');
		$f3->set('content', 'shipperRead1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Create($f3)
	{
		require 'requirements.php';

		$shipperMap = new DB\SQL\Mapper($db, 'Shipper');

		$f3->set('shipper', $shipperMap);
		$f3->set('theErrorMessage', '');
		$f3->set('html_title', 'NorthWind - Create New Shipper');
		$f3->set('content', 'shipperCreate.html');
		echo \Template::instance()->render('Layout.html');
	}

	function ValidCreate($f3, &$theErrorMessage, $shipperMap)
	{
		require 'requirements.php';

		if (!preg_match("/^[a-zA-Z-' ]*$/", $shipperMap->CompanyName)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Company Name: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[0-9() -]*$/", $shipperMap->Phone)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Phone: Only digits and white space are allowed - ";
		}

		$shipperMap1 = new DB\SQL\Mapper($db, 'Shipper');
		$shipperMap1->load(array('UPPER(CompanyName) = ? ', strtoupper($shipperMap->CompanyName)));
		if (!$shipperMap1->dry()) 
		{
			$theErrorMessage = $theErrorMessage . " - Company Name is Not UNIQUE - ";
		}

		$phone = '';
		for ($i = 0; $i < strlen($shipperMap->Phone); ++$i)
		{
			if (is_numeric($shipperMap->Phone[$i]))
			{
				$phone = $phone . $shipperMap->Phone[$i];
			}
		}
		$unique = true;
		$shipperMap2 = new DB\SQL\Mapper($db, 'Shipper');
		$shippers2 = $shipperMap2->find('');
		foreach ($shippers2 as $shipper2)
		{
			$phone2 = '';
			for ($i = 0; $i < strlen($shipper2->Phone); ++$i)
			{
				if (is_numeric($shipper2->Phone[$i]))
				{
					$phone2 = $phone2 . $shipper2->Phone[$i];
				}
			}
			if (strcmp($phone, $phone2) == 0)
			{
				$unique = false;
			}
		}
		if (!$unique) 
		{
			$theErrorMessage = $theErrorMessage . " - Phone Number is Not UNIQUE - ";
		}

		return $theErrorMessage == '';
	}

	function CreateAct($f3)
	{
		require 'requirements.php';

		$shipperMap = new DB\SQL\Mapper($db, 'Shipper');
		$shipperMap->copyfrom('POST');

		$theErrorMessage = '';
		if (Shipper::ValidCreate($f3, $theErrorMessage, $shipperMap))
		{
			$rows = $db->exec('SELECT MAX(Id) AS LastId FROM Shipper;');
			foreach ($rows as $row)
			{
				$Id = $row['LastId'];
			}
			++$Id;

			$sql = "INSERT INTO Shipper (Id, CompanyName, Phone) VALUES (?,?,?)";
			$stmt= $db->prepare($sql);
			$stmt->execute([$Id, $f3->get('POST.CompanyName'), $f3->get('POST.Phone')]);

			$f3->reroute('/');
		} 
		else 
		{
			$shipperMap = new DB\SQL\Mapper($db, 'Shipper');

			$f3->set('shipper', $shipperMap);
			$f3->set('theErrorMessage', $theErrorMessage);
			$f3->set('html_title', 'NorthWind - Create New Shipper');
			$f3->set('content', 'shipperCreate.html');
			echo \Template::instance()->render('Layout.html');
		}
	}

	function Browse($f3, $args)
	{
		require 'requirements.php';

		$shippersMap = new DB\SQL\Mapper($db, 'Shipper');
		$shippers = $shippersMap->find(array(''), array('order' => 'CompanyName'));

		$f3->set('shippers', $shippers);
		$f3->set('html_title', 'NorthWind Shippers');
		$f3->set('content', 'shipperBrowse.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Browse2($f3, $args)
	{
		require 'requirements.php';

		$shippersMap = new DB\SQL\Mapper($db, 'Shipper');
		$shippers = $shippersMap->find(array(''), array('order' => 'CompanyName'));

		$f3->set('shippers', $shippers);
		$f3->set('html_title', 'NorthWind Shippers');
		$f3->set('content', 'shipperBrowse2.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Update1($f3, $args)
	{
		require 'requirements.php';

		$shipperMap = new DB\SQL\Mapper($db, 'Shipper');
		$shipper = $shipperMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

		$f3->set('shipper', $shipper);
		$f3->set('theErrorMessage', '');
		$f3->set('html_title', 'NorthWind Shipper - UPDATE');
		$f3->set('content', 'shipperUpdate1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function ValidUpdate($f3, &$theErrorMessage, $shipperMap)
	{
		require 'requirements.php';

		if (!preg_match("/^[a-zA-Z-' ]*$/", $shipperMap->CompanyName)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Company Name: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[0-9() -]*$/", $shipperMap->Phone)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Phone: Only digits and white space are allowed - ";
		}

		$shipperMap1 = new DB\SQL\Mapper($db, 'Shipper');
		$shipperMap1->load(array('UPPER(CompanyName) = ? AND Id != ?', strtoupper($shipperMap->CompanyName), $shipperMap->Id));
		if (!$shipperMap1->dry()) 
		{
			$theErrorMessage = $theErrorMessage . " - Company Name is Not UNIQUE - ";
		}

		$phone = '';
		for ($i = 0; $i < strlen($shipperMap->Phone); ++$i)
		{
			if (is_numeric($shipperMap->Phone[$i]))
			{
				$phone = $phone . $shipperMap->Phone[$i];
			}
		}
		$unique = true;
		$shipperMap2 = new DB\SQL\Mapper($db, 'Shipper');
		$shippers2 = $shipperMap2->find('');
		foreach ($shippers2 as $shipper2)
		{
			if ($shipper2->Id != $shipperMap->Id)
			{
				$phone2 = '';
				for ($i = 0; $i < strlen($shipper2->Phone); ++$i)
				{
					if (is_numeric($shipper2->Phone[$i]))
					{
						$phone2 = $phone2 . $shipper2->Phone[$i];
					}
				}
				if (strcmp($phone, $phone2) == 0)
				{
					$unique = false;
				}
			}
		}
		if (!$unique) 
		{
			$theErrorMessage = $theErrorMessage . " - Phone Number is Not UNIQUE - ";
		}

		return $theErrorMessage == '';
	}

	function Update1Act($f3)
	{
		require 'requirements.php';

		if (isset($_POST['cancel'])) 
		{
			$f3->reroute('/shipperUpdateAll');
		}

		if (isset($_POST['update'])) 
		{
			$shipperMap = new DB\SQL\Mapper($db, 'Shipper');
			$shipperMap->copyFrom('POST');

			$theErrorMessage = '';
			if (Shipper::ValidUpdate($f3, $theErrorMessage, $shipperMap))
			{
				$sql = "UPDATE Shipper SET CompanyName = ?, Phone = ? WHERE Id = ?";
				$stmt= $db->prepare($sql);
				$stmt->execute([$f3->get('POST.CompanyName'), $f3->get('POST.Phone'), $f3->get('PARAMS.id')]);

				$success = 'updated';

				$shipperMap = new DB\SQL\Mapper($db, 'Shipper');
				$shipper = $shipperMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

				$f3->set('shipper', $shipper);
				$f3->set('success', $success);
				$f3->set('html_title', 'NorthWind Shipper - UPDATE Effect');
				$f3->set('content', 'shipperUpdate1Effect.html');
				echo \Template::instance()->render('Layout.html');
			} 
			else 
			{
				$shipperMap = new DB\SQL\Mapper($db, 'Shipper');
				$shipper = $shipperMap->findone(array('Id = ?', $f3->get('PARAMS.id')));
		
				$f3->set('shipper', $shipper);
				$f3->set('theErrorMessage', $theErrorMessage);
				$f3->set('html_title', 'NorthWind Shipper - UPDATE');
				$f3->set('content', 'shipperUpdate1.html');
				echo \Template::instance()->render('Layout.html');
			}
		}
	}

	function Delete1($f3, $args)
	{
		require 'requirements.php';

		$shipperMap = new DB\SQL\Mapper($db, 'Shipper');
		$shipper = $shipperMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

		$f3->set('shipper', $shipper);
		$f3->set('html_title', 'NorthWind Shipper - DELETE');
		$f3->set('content', 'shipperDelete1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Delete1Act($f3)
	{
		require 'requirements.php';

		if (isset($_POST['cancel'])) 
		{
			$f3->reroute('/shipperDeleteAll');
		}

		if (isset($_POST['delete'])) 
		{
			$shipperMap = new DB\SQL\Mapper($db, 'Shipper');
			$shipper = $shipperMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

			$f3->set('shipper', $shipper);

			$orderMapDel = new DB\SQL\Mapper($db, 'Order');
			$orderMapDel->load(array('ShipVia = ?', $f3->get('PARAMS.id')));

			if ($orderMapDel->dry())
			{
				$shipper->erase();
				$success = 'deleted';
			}
			else
			{
				$success = 'unsuccessful';
			}

			$f3->set('success', $success);
			$f3->set('html_title', 'NorthWind Shipper - DELETE Effect');
			$f3->set('content', 'shipperDelete1Effect.html');
			echo \Template::instance()->render('Layout.html');
		}
	}
}