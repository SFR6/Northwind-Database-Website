<?php

class Supplier extends Controller
{
	function ReadAll($f3, $args)
	{
		require 'requirements.php';

		$suppliersMap = new DB\SQL\Mapper($db, 'Supplier');
		$suppliers = $suppliersMap->find(array(''), array('order' => 'CompanyName'));

		$f3->set('suppliers', $suppliers);
		$f3->set('html_title', 'Suppliers');
		$f3->set('content', 'supplierReadAll.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Read1($f3, $args)
	{
		require 'requirements.php';

		$supplierMap = new DB\SQL\Mapper($db, 'Supplier');
		$supplier = $supplierMap->findone(array('Id = ?', $f3->get('PARAMS.id')));
		$websiteText = '';
		$website = '';
		if ($supplier->HomePage)
		{
			if ($supplier->HomePage[0] != '#')
			{
				$i = 0;
				while ($supplier->HomePage[$i] != '#')
				{
					$websiteText[$i] = $supplier->HomePage[$i];
					++$i;
				}
				//reached the first '#'
				++$i;
				while ($supplier->HomePage[$i] != '#')
				{
					$website[$i] = $supplier->HomePage[$i];
					++$i;
				}
			}
			else
			{
				$websiteText = $supplier->CompanyName;
				$i = 1; //skip the first '#'
				while ($supplier->HomePage[$i] != '#')
				{
					$website[$i] = $supplier->HomePage[$i];
					++$i;
				}
			}
		}

		$f3->set('supplier', $supplier);
		$f3->set('website', $website);
		$f3->set('websiteText', $websiteText);
		$f3->set('html_title', 'Supplier');
		$f3->set('content', 'supplierRead1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Create($f3)
	{
		require 'requirements.php';

		$supplierMap = new DB\SQL\Mapper($db, 'Supplier');

		$f3->set('supplier', $supplierMap);
		$f3->set('theErrorMessage', '');
		$f3->set('html_title', 'NorthWind - Create New Supplier');
		$f3->set('content', 'supplierCreate.html');
		echo \Template::instance()->render('Layout.html');
	}

	function ValidCreate($f3, &$theErrorMessage, $supplierMap)
	{
		require 'requirements.php';

		if (!preg_match("/^[a-zA-Z-' ]*$/", $supplierMap->CompanyName)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Company Name: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $supplierMap->ContactName)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Contact Person Name: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $supplierMap->ContactTitle)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Contact Person Title: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $supplierMap->City)) 
		{
			$theErrorMessage = $theErrorMessage . " - in City: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $supplierMap->Region)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Region: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $supplierMap->Country)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Country: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[0-9() -]*$/", $supplierMap->Phone)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Phone: Only digits and white space are allowed - ";
		}
		if ($supplierMap->Fax and !preg_match("/^[0-9() -]*$/", $supplierMap->Fax)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Fax: Only digits and white space are allowed - ";
		}
		if ($supplierMap->HomePage)
		{
			$dotCounter = 0;
			foreach (str_split($supplierMap->HomePage) as $char)
			{
				if ($char == '.')
				{
					++$dotCounter;
				}
			}
			if ($dotCounter < 2)
			{
				$theErrorMessage = $theErrorMessage . " - in Website: There needs to be at least two dots - ";
			}
			if (!(strstr($supplierMap->HomePage, "http://www.") != 0 || strstr($supplierMap->HomePage, "https://www.") != 0))
			{
				$theErrorMessage = $theErrorMessage . " - in Website: There needs to be at least one of the following: \"http://www.\" or \"https://www.\" - ";
			}
		}

		$supplierMap1 = new DB\SQL\Mapper($db, 'Supplier');
		$supplierMap1->load(array('UPPER(CompanyName) = ? ', strtoupper($supplierMap->CompanyName)));
		if (!$supplierMap1->dry()) 
		{
			$theErrorMessage = $theErrorMessage . " - Company Name is Not UNIQUE - ";
		}

		$phone = '';
		for ($i = 0; $i < strlen($supplierMap->Phone); ++$i)
		{
			if (is_numeric($supplierMap->Phone[$i]))
			{
				$phone = $phone . $supplierMap->Phone[$i];
			}
		}
		$unique = true;
		$supplierMap2 = new DB\SQL\Mapper($db, 'Supplier');
		$suppliers2 = $supplierMap2->find('');
		foreach ($suppliers2 as $supplier2)
		{
			$phone2 = '';
			for ($i = 0; $i < strlen($supplier2->Phone); ++$i)
			{
				if (is_numeric($supplier2->Phone[$i]))
				{
					$phone2 = $phone2 . $supplier2->Phone[$i];
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

		$fax = '';
		for ($i = 0; $i < strlen($supplierMap->Fax); ++$i)
		{
			if (is_numeric($supplierMap->Fax[$i]))
			{
				$fax = $fax . $supplierMap->Fax[$i];
			}
		}
		$unique = true;
		$supplierMap3 = new DB\SQL\Mapper($db, 'Supplier');
		$suppliers3 = $supplierMap3->find('');
		foreach ($suppliers3 as $supplier3)
		{
			if ($supplier3->Fax)
			{
				$fax2 = '';
				for ($i = 0; $i < strlen($supplier3->Fax); ++$i)
				{
					if (is_numeric($supplier3->Fax[$i]))
					{
						$fax2 = $fax2 . $supplier3->Fax[$i];
					}
				}
				if (strcmp($fax, $fax2) == 0)
				{
					$unique = false;
				}
			}

		}
		if (!$unique) 
		{
			$theErrorMessage = $theErrorMessage . " - Fax Number is Not UNIQUE - ";
		}

		$supplierMap4 = new DB\SQL\Mapper($db, 'Supplier');
		$supplierMap4->load(array('LOWER(HomePage) = ?', strtolower($supplierMap->HomePage)));
		if (!$supplierMap4->dry()) 
		{
			$theErrorMessage = $theErrorMessage . " - Website is Not UNIQUE - ";
		}

		return $theErrorMessage == '';
	}

	function CreateAct($f3)
	{
		require 'requirements.php';

		$supplierMap = new DB\SQL\Mapper($db, 'Supplier');
		$supplierMap->copyfrom('POST');

		$theErrorMessage = '';
		if (Supplier::ValidCreate($f3, $theErrorMessage, $supplierMap))
		{
			$rows = $db->exec('SELECT MAX(Id) AS LastId FROM Supplier;');
			foreach ($rows as $row)
			{
				$Id = $row['LastId'];
			}
			++$Id;

			$HomePage = '#' . $f3->get('POST.HomePage') . '#';

			$sql = "INSERT INTO Supplier (Id, CompanyName, ContactName, ContactTitle, Address, City, Region, PostalCode, Country, Phone, Fax, HomePage) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
			$stmt= $db->prepare($sql);
			$stmt->execute([$Id, $f3->get('POST.CompanyName'), $f3->get('POST.ContactName'), $f3->get('POST.ContactTitle'), $f3->get('POST.Address'), $f3->get('POST.City'), $f3->get('POST.Region'), $f3->get('POST.PostalCode'), $f3->get('POST.Country'), $f3->get('POST.Phone'), $f3->get('POST.Fax'), $HomePage]);

			$f3->reroute('/');
		} 
		else 
		{
			$supplierMap = new DB\SQL\Mapper($db, 'Supplier');

			$f3->set('supplier', $supplierMap);
			$f3->set('theErrorMessage', $theErrorMessage);
			$f3->set('html_title', 'NorthWind - Create New Supplier');
			$f3->set('content', 'supplierCreate.html');
			echo \Template::instance()->render('Layout.html');
		}
	}

	function Browse($f3, $args)
	{
		require 'requirements.php';

		$suppliersMap = new DB\SQL\Mapper($db, 'Supplier');
		$suppliers = $suppliersMap->find(array(''), array('order' => 'CompanyName'));

		$f3->set('suppliers', $suppliers);
		$f3->set('html_title', 'NorthWind Suppliers');
		$f3->set('content', 'supplierBrowse.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Browse2($f3, $args)
	{
		require 'requirements.php';

		$suppliersMap = new DB\SQL\Mapper($db, 'Supplier');
		$suppliers = $suppliersMap->find(array(''), array('order' => 'CompanyName'));

		$f3->set('suppliers', $suppliers);
		$f3->set('html_title', 'NorthWind Suppliers');
		$f3->set('content', 'supplierBrowse2.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Update1($f3, $args)
	{
		require 'requirements.php';

		$supplierMap = new DB\SQL\Mapper($db, 'Supplier');
		$supplier = $supplierMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

		$f3->set('supplier', $supplier);
		$f3->set('theErrorMessage', '');
		$f3->set('html_title', 'NorthWind Supplier - UPDATE');
		$f3->set('content', 'supplierUpdate1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function ValidUpdate($f3, &$theErrorMessage, $supplierMap)
	{
		require 'requirements.php';

		if (!preg_match("/^[a-zA-Z-' ]*$/", $supplierMap->CompanyName)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Company Name: Only letters and white space are allowed - ";
		}
		$numberOfLetters = 0;
		for ($i = 0; $i < strlen($supplierMap->CompanyName); ++$i)
		{
			if (preg_match('/[a-zA-Z]/', $supplierMap->CompanyName[$i]))
			{
				++$numberOfLetters;
			}
		}
		if ($numberOfLetters < 5)
		{
			$theErrorMessage = $theErrorMessage . " - Company Name must have at least 5 letters - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $supplierMap->ContactName)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Contact Person Name: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $supplierMap->ContactTitle)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Contact Person Title: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $supplierMap->City)) 
		{
			$theErrorMessage = $theErrorMessage . " - in City: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $supplierMap->Region)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Region: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $supplierMap->Country)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Country: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[0-9() -]*$/", $supplierMap->Phone)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Phone: Only digits and white space are allowed - ";
		}
		if ($supplierMap->Fax AND !preg_match("/^[0-9() -]*$/", $supplierMap->Fax)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Fax: Only digits and white space are allowed - ";
		}
		if ($supplierMap->HomePage)
		{
			$dotCounter = 0;
			foreach (str_split($supplierMap->HomePage) as $char)
			{
				if ($char == '.')
				{
					++$dotCounter;
				}
			}
			if ($supplierMap->HomePage[strlen($supplierMap->HomePage) - 1] != '#')
			{
				$theErrorMessage = $theErrorMessage . " - in Website: The last character needs to be '#' - ";
			}
			if ($dotCounter < 2)
			{
				$theErrorMessage = $theErrorMessage . " - in Website: There needs to be at least two dots - ";
			}
			if (!(strstr($supplierMap->HomePage, "#http://www.") != 0 || strstr($supplierMap->HomePage, "#https://www.") != 0))
			{
				$theErrorMessage = $theErrorMessage . " - in Website: There needs to be at least one of the following: \"#http://www.\" or \"#https://www.\" - ";
			}
		}

		$supplierMap1 = new DB\SQL\Mapper($db, 'Supplier');
		$supplierMap1->load(array('UPPER(CompanyName) = ? AND Id != ?', strtoupper($supplierMap->CompanyName), $supplierMap->Id));
		if (!$supplierMap1->dry()) 
		{
			$theErrorMessage = $theErrorMessage . " - Company Name is Not UNIQUE - ";
		}

		$phone = '';
		for ($i = 0; $i < strlen($supplierMap->Phone); ++$i)
		{
			if (is_numeric($supplierMap->Phone[$i]))
			{
				$phone = $phone . $supplierMap->Phone[$i];
			}
		}
		$unique = true;
		$supplierMap2 = new DB\SQL\Mapper($db, 'Supplier');
		$suppliers2 = $supplierMap2->find('');
		foreach ($suppliers2 as $supplier2)
		{
			if ($supplier2->Id != $supplierMap->Id)
			{
				$phone2 = '';
				for ($i = 0; $i < strlen($supplier2->Phone); ++$i)
				{
					if (is_numeric($supplier2->Phone[$i]))
					{
						$phone2 = $phone2 . $supplier2->Phone[$i];
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

		$fax = '';
		for ($i = 0; $i < strlen($supplierMap->Fax); ++$i)
		{
			if (is_numeric($supplierMap->Fax[$i]))
			{
				$fax = $fax . $supplierMap->Fax[$i];
			}
		}
		$unique = true;
		$supplierMap3 = new DB\SQL\Mapper($db, 'Supplier');
		$suppliers3 = $supplierMap3->find('');
		foreach ($suppliers3 as $supplier3)
		{
			if ($supplier3->Id != $supplierMap->Id and $supplier3->Fax)
			{
				$fax2 = '';
				for ($i = 0; $i < strlen($supplier3->Fax); ++$i)
				{
					if (is_numeric($supplier3->Fax[$i]))
					{
						$fax2 = $fax2 . $supplier3->Fax[$i];
					}
				}
				if (strcmp($fax, $fax2) == 0)
				{
					$unique = false;
				}
			}

		}
		if (!$unique) 
		{
			$theErrorMessage = $theErrorMessage . " - Fax Number is Not UNIQUE - ";
		}

		$supplierMap4 = new DB\SQL\Mapper($db, 'Supplier');
		$supplierMap4->load(array('LOWER(HomePage) = ? AND Id != ?', strtolower($supplierMap->HomePage), $supplierMap->Id));
		if (!$supplierMap4->dry()) 
		{
			$theErrorMessage = $theErrorMessage . " - Website is Not UNIQUE - ";
		}

		return $theErrorMessage == '';
	}

	function Update1Act($f3)
	{
		require 'requirements.php';

		if (isset($_POST['cancel'])) 
		{
			$f3->reroute('/supplierUpdateAll');
		}

		if (isset($_POST['update'])) 
		{
			$supplierMap = new DB\SQL\Mapper($db, 'Supplier');
			$supplierMap->copyFrom('POST');

			$theErrorMessage = '';
			if (Supplier::ValidUpdate($f3, $theErrorMessage, $supplierMap))
			{
				$sql = "UPDATE Supplier SET CompanyName = ?, ContactName = ?, ContactTitle = ?, Address = ?, City = ?, Region = ?, PostalCode = ?, Country = ?, Phone = ?, Fax = ?, HomePage = ? WHERE Id = ?";
				$stmt= $db->prepare($sql);
				$stmt->execute([$f3->get('POST.CompanyName'), $f3->get('POST.ContactName'), $f3->get('POST.ContactTitle'), $f3->get('POST.Address'), $f3->get('POST.City'), $f3->get('POST.Region'), $f3->get('POST.PostalCode'), $f3->get('POST.Country'), $f3->get('POST.Phone'), $f3->get('POST.Fax'), $f3->get('POST.HomePage'), $f3->get('PARAMS.id')]);

				$success = 'updated';

				$supplierMap = new DB\SQL\Mapper($db, 'Supplier');
				$supplier = $supplierMap->findone(array('Id = ?', $f3->get('PARAMS.id')));
				$websiteText = '';
				$website = '';
				if ($supplier->HomePage)
				{
					if ($supplier->HomePage[0] != '#')
					{
						$i = 0;
						while ($supplier->HomePage[$i] != '#')
						{
							$websiteText[$i] = $supplier->HomePage[$i];
							++$i;
						}
						//reached the first '#'
						++$i;
						while ($supplier->HomePage[$i] != '#')
						{
							$website[$i] = $supplier->HomePage[$i];
							++$i;
						}
					}
					else
					{
						$websiteText = $supplier->CompanyName;
						$i = 1; //skip the first '#'
						while ($supplier->HomePage[$i] != '#')
						{
							$website[$i] = $supplier->HomePage[$i];
							++$i;
						}
					}
				}

				$f3->set('supplier', $supplier);
				$f3->set('website', $website);
				$f3->set('websiteText', $websiteText);

				$f3->set('supplier', $supplier);
				$f3->set('success', $success);
				$f3->set('html_title', 'NorthWind Supplier - UPDATE Effect');
				$f3->set('content', 'supplierUpdate1Effect.html');
				echo \Template::instance()->render('Layout.html');
			} 
			else 
			{
				$supplierMap = new DB\SQL\Mapper($db, 'Supplier');
				$supplier = $supplierMap->findone(array('Id = ?', $f3->get('PARAMS.id')));
		
				$f3->set('supplier', $supplier);
				$f3->set('theErrorMessage', $theErrorMessage);
				$f3->set('html_title', 'NorthWind Supplier - UPDATE');
				$f3->set('content', 'supplierUpdate1.html');
				echo \Template::instance()->render('Layout.html');
			}
		}
	}

	function Delete1($f3, $args)
	{
		require 'requirements.php';

		$supplierMap = new DB\SQL\Mapper($db, 'Supplier');
		$supplier = $supplierMap->findone(array('Id = ?', $f3->get('PARAMS.id')));
		$websiteText = '';
		$website = '';
		if ($supplier->HomePage)
		{
			if ($supplier->HomePage[0] != '#')
			{
				$i = 0;
				while ($supplier->HomePage[$i] != '#')
				{
					$websiteText[$i] = $supplier->HomePage[$i];
					++$i;
				}
				//reached the first '#'
				++$i;
				while ($supplier->HomePage[$i] != '#')
				{
					$website[$i] = $supplier->HomePage[$i];
					++$i;
				}
			}
			else
			{
				$websiteText = $supplier->CompanyName;
				$i = 1; //skip the first '#'
				while ($supplier->HomePage[$i] != '#')
				{
					$website[$i] = $supplier->HomePage[$i];
					++$i;
				}
			}
		}

		$f3->set('supplier', $supplier);
		$f3->set('website', $website);
		$f3->set('websiteText', $websiteText);
		$f3->set('html_title', 'NorthWind Supplier - DELETE');
		$f3->set('content', 'supplierDelete1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Delete1Act($f3)
	{
		require 'requirements.php';

		if (isset($_POST['cancel'])) 
		{
			$f3->reroute('/supplierDeleteAll');
		}

		if (isset($_POST['delete'])) 
		{
			$supplierMap = new DB\SQL\Mapper($db, 'Supplier');
			$supplier = $supplierMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

			$f3->set('supplier', $supplier);
			$websiteText = '';
			$website = '';
			if ($supplier->HomePage)
			{
				if ($supplier->HomePage[0] != '#')
				{
					$i = 0;
					while ($supplier->HomePage[$i] != '#')
					{
						$websiteText[$i] = $supplier->HomePage[$i];
						++$i;
					}
					//reached the first '#'
					++$i;
					while ($supplier->HomePage[$i] != '#')
					{
						$website[$i] = $supplier->HomePage[$i];
						++$i;
					}
				}
				else
				{
					$websiteText = $supplier->CompanyName;
					$i = 1; //skip the first '#'
					while ($supplier->HomePage[$i] != '#')
					{
						$website[$i] = $supplier->HomePage[$i];
						++$i;
					}
				}
			}

			$f3->set('website', $website);
			$f3->set('websiteText', $websiteText);

			$orderMapDel = new DB\SQL\Mapper($db, 'Order');
			$orderMapDel->load(array('Id = ?', $f3->get('PARAMS.id')));

			if ($orderMapDel->dry())
			{
				$supplier->erase();
				$success = 'deleted';
			}
			else
			{
				$success = 'unsuccessful';
			}

			$f3->set('success', $success);
			$f3->set('html_title', 'NorthWind Supplier - DELETE Effect');
			$f3->set('content', 'supplierDelete1Effect.html');
			echo \Template::instance()->render('Layout.html');
		}
	}
}