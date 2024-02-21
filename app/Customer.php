<?php

class Customer extends Controller
{
	function ReadAll($f3, $args)
	{
		require 'requirements.php';

		$customersMap = new DB\SQL\Mapper($db, 'Customer');
		$customers = $customersMap->find(array(''), array('order' => 'CompanyName'));

		$f3->set('customers', $customers);
		$f3->set('html_title', 'Customers');
		$f3->set('content', 'customerReadAll.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Read1($f3, $args)
	{
		require 'requirements.php';

		$customerMap = new DB\SQL\Mapper($db, 'Customer');
		$customer = $customerMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

		$f3->set('customer', $customer);
		$f3->set('html_title', 'Customer');
		$f3->set('content', 'customerRead1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Create($f3)
	{
		require 'requirements.php';

		$customerMap = new DB\SQL\Mapper($db, 'Customer');

		$f3->set('customer', $customerMap);
		$f3->set('theErrorMessage', '');
		$f3->set('html_title', 'NorthWind - Create New Customer');
		$f3->set('content', 'customerCreate.html');
		echo \Template::instance()->render('Layout.html');
	}

	function ValidCreate($f3, &$theErrorMessage, $customerMap)
	{
		require 'requirements.php';

		if (!preg_match("/^[a-zA-Z-' ]*$/", $customerMap->CompanyName)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Company Name: Only letters and white space are allowed - ";
		}
		$numberOfLetters = 0;
		for ($i = 0; $i < strlen($customerMap->CompanyName); ++$i)
		{
			if (preg_match('/[a-zA-Z]/', $customerMap->CompanyName[$i]))
			{
				++$numberOfLetters;
			}
		}
		if ($numberOfLetters < 5)
		{
			$theErrorMessage = $theErrorMessage . " - Company Name must have at least 5 letters - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $customerMap->ContactName)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Contact Person Name: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $customerMap->ContactTitle)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Contact Person Title: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $customerMap->City)) 
		{
			$theErrorMessage = $theErrorMessage . " - in City: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $customerMap->Region)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Region: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $customerMap->Country)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Country: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[0-9() -]*$/", $customerMap->Phone)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Phone: Only digits and white space are allowed - ";
		}
		if ($customerMap->Fax AND !preg_match("/^[0-9() -]*$/", $customerMap->Fax)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Fax: Only digits and white space are allowed - ";
		}

		$customerMap1 = new DB\SQL\Mapper($db, 'Customer');
		$customerMap1->load(array('UPPER(CompanyName) = ? ', strtoupper($customerMap->CompanyName)));
		if (!$customerMap1->dry()) 
		{
			$theErrorMessage = $theErrorMessage . " - Company Name is Not UNIQUE - ";
		}

		$phone = '';
		for ($i = 0; $i < strlen($customerMap->Phone); ++$i)
		{
			if (is_numeric($customerMap->Phone[$i]))
			{
				$phone = $phone . $customerMap->Phone[$i];
			}
		}
		$unique = true;
		$customerMap2 = new DB\SQL\Mapper($db, 'Csutomer');
		$customers2 = $customerMap2->find('');
		foreach ($customers2 as $customer2)
		{
			$phone2 = '';
			for ($i = 0; $i < strlen($customer2->Phone); ++$i)
			{
				if (is_numeric($customer2->Phone[$i]))
				{
					$phone2 = $phone2 . $customer2->Phone[$i];
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
		for ($i = 0; $i < strlen($customerMap->Fax); ++$i)
		{
			if (is_numeric($customerMap->Fax[$i]))
			{
				$fax = $fax . $customerMap->Fax[$i];
			}
		}
		$unique = true;
		$customerMap3 = new DB\SQL\Mapper($db, 'Customer');
		$customers3 = $customerMap3->find('');
		foreach ($customers3 as $customer3)
		{
			if ($customer3->Fax)
			{
				$fax2 = '';
				for ($i = 0; $i < strlen($customer3->Fax); ++$i)
				{
					if (is_numeric($customer3->Fax[$i]))
					{
						$fax2 = $fax2 . $customer3->Fax[$i];
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

		return $theErrorMessage == '';
	}

	function CreateAct($f3)
	{
		require 'requirements.php';

		$customerMap = new DB\SQL\Mapper($db, 'Customer');
		$customerMap->copyfrom('POST');

		$theErrorMessage = '';
		if (Customer::ValidCreate($f3, $theErrorMessage, $customerMap))
		{
			$Id = '';
			$name = $f3->get('POST.CompanyName');
			$counter = 3;
			for ($i = 0; $i < strlen($name) and $counter > 0; ++$i)
			{
				if (preg_match('/[A-Z]/', strtoupper($name[$i])))
				{
					$Id = $Id . strtoupper($name[$i]);
					--$counter;
				}
			}
			$uniqueId = false;
			$letter1 = '';
			$letter2 = '';
			for ($j = $i; $name[$j] and $uniqueId == false; ++$j)
			{
				$letter1 = strtoupper($name[$j]);
				for ($k = $j + 1; $name[$k] and $uniqueId == false; ++$k)
				{
					$letter2 = strtoupper($name[$k]);
					$customersMap1 = new DB\SQL\Mapper($db, 'Customer');
					$customers1 = $customersMap1->find(array(''), array('order' => 'Id'));
					$uniqueId = true;
					foreach ($customers1 as $customer1)
					{
						if (strcmp($customer1->Id, $Id . $letter1 . $letter2) == 0)
						{
							$uniqueId = false;
						}
					}
				}
			}
			$Id = $Id . $letter1 . $letter2;

			$sql = "INSERT INTO Customer (Id, CompanyName, ContactName, ContactTitle, Address, City, Region, PostalCode, Country, Phone, Fax) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
			$stmt= $db->prepare($sql);
			$stmt->execute([$Id, $f3->get('POST.CompanyName'), $f3->get('POST.ContactName'), $f3->get('POST.ContactTitle'), $f3->get('POST.Address'), $f3->get('POST.City'), $f3->get('POST.Region'), $f3->get('POST.PostalCode'), $f3->get('POST.Country'), $f3->get('POST.Phone'), $f3->get('POST.Fax')]);

			$f3->reroute('/');
		} 
		else 
		{
			$customerMap = new DB\SQL\Mapper($db, 'Customer');

			$f3->set('customer', $customerMap);
			$f3->set('theErrorMessage', $theErrorMessage);
			$f3->set('html_title', 'NorthWind - Create New Customer');
			$f3->set('content', 'customerCreate.html');
			echo \Template::instance()->render('Layout.html');
		}
	}

	function Browse($f3, $args)
	{
		require 'requirements.php';

		$customersMap = new DB\SQL\Mapper($db, 'Customer');
		$customers = $customersMap->find(array(''), array('order' => 'CompanyName'));

		$f3->set('customers', $customers);
		$f3->set('html_title', 'NorthWind Customers');
		$f3->set('content', 'customerBrowse.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Browse2($f3, $args)
	{
		require 'requirements.php';

		$customersMap = new DB\SQL\Mapper($db, 'Customer');
		$customers = $customersMap->find(array(''), array('order' => 'CompanyName'));

		$f3->set('customers', $customers);
		$f3->set('html_title', 'NorthWind Customers');
		$f3->set('content', 'customerBrowse2.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Update1($f3, $args)
	{
		require 'requirements.php';

		$customerMap = new DB\SQL\Mapper($db, 'Customer');
		$customer = $customerMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

		$f3->set('customer', $customer);
		$f3->set('theErrorMessage', '');
		$f3->set('html_title', 'NorthWind Customer - UPDATE');
		$f3->set('content', 'customerUpdate1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function ValidUpdate($f3, &$theErrorMessage, $customerMap)
	{
		require 'requirements.php';

		if (!preg_match("/^[a-zA-Z-' ]*$/", $customerMap->CompanyName)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Company Name: Only letters and white space are allowed - ";
		}
		$numberOfLetters = 0;
		for ($i = 0; $i < strlen($customerMap->CompanyName); ++$i)
		{
			if (preg_match('/[a-zA-Z]/', $customerMap->CompanyName[$i]))
			{
				++$numberOfLetters;
			}
		}
		if ($numberOfLetters < 5)
		{
			$theErrorMessage = $theErrorMessage . " - Company Name must have at least 5 letters - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $customerMap->ContactName)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Contact Person Name: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $customerMap->ContactTitle)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Contact Person Title: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $customerMap->City)) 
		{
			$theErrorMessage = $theErrorMessage . " - in City: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $customerMap->Region)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Region: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[a-zA-Z-' ]*$/", $customerMap->Country)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Country: Only letters and white space are allowed - ";
		}
		if (!preg_match("/^[0-9() -]*$/", $customerMap->Phone)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Phone: Only digits and white space are allowed - ";
		}
		if ($customerMap->Fax AND !preg_match("/^[0-9() -]*$/", $customerMap->Fax)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Fax: Only digits and white space are allowed - ";
		}

		$customerMap1 = new DB\SQL\Mapper($db, 'Customer');
		$customerMap1->load(array('UPPER(CompanyName) = ? AND Id != ?', strtoupper($customerMap->CompanyName), $customerMap->Id));
		if (!$customerMap1->dry()) 
		{
			$theErrorMessage = $theErrorMessage . " - Company Name is Not UNIQUE - ";
		}

		$phone = '';
		for ($i = 0; $i < strlen($customerMap->Phone); ++$i)
		{
			if (is_numeric($customerMap->Phone[$i]))
			{
				$phone = $phone . $customerMap->Phone[$i];
			}
		}
		$unique = true;
		$customerMap2 = new DB\SQL\Mapper($db, 'Customer');
		$customers2 = $customerMap2->find('');
		foreach ($customers2 as $customer2)
		{
			if ($customer2->Id != $customerMap->Id)
			{
				$phone2 = '';
				for ($i = 0; $i < strlen($customer2->Phone); ++$i)
				{
					if (is_numeric($customer2->Phone[$i]))
					{
						$phone2 = $phone2 . $customer2->Phone[$i];
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
		for ($i = 0; $i < strlen($customerMap->Fax); ++$i)
		{
			if (is_numeric($customerMap->Fax[$i]))
			{
				$fax = $fax . $customerMap->Fax[$i];
			}
		}
		$unique = true;
		$customerMap3 = new DB\SQL\Mapper($db, 'Customer');
		$customers3 = $customerMap3->find('');
		foreach ($customers3 as $customer3)
		{
			if ($customer3->Id != $customerMap->Id and $customer3->Fax)
			{
				$fax2 = '';
				for ($i = 0; $i < strlen($customer3->Fax); ++$i)
				{
					if (is_numeric($customer3->Fax[$i]))
					{
						$fax2 = $fax2 . $customer3->Fax[$i];
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

		return $theErrorMessage == '';
	}

	function Update1Act($f3)
	{
		require 'requirements.php';

		if (isset($_POST['cancel'])) 
		{
			$f3->reroute('/customerUpdateAll');
		}

		if (isset($_POST['update'])) 
		{
			$customerMap = new DB\SQL\Mapper($db, 'Customer');
			$customerMap->copyFrom('POST');

			$theErrorMessage = '';
			if (Customer::ValidUpdate($f3, $theErrorMessage, $customerMap))
			{
				$sql = "UPDATE Customer SET CompanyName = ?, ContactName = ?, ContactTitle = ?, Address = ?, City = ?, Region = ?, PostalCode = ?, Country = ?, Phone = ?, Fax = ? WHERE Id = ?";
				$stmt= $db->prepare($sql);
				$stmt->execute([$f3->get('POST.CompanyName'), $f3->get('POST.ContactName'), $f3->get('POST.ContactTitle'), $f3->get('POST.Address'), $f3->get('POST.City'), $f3->get('POST.Region'), $f3->get('POST.PostalCode'), $f3->get('POST.Country'), $f3->get('POST.Phone'), $f3->get('POST.Fax'), $f3->get('PARAMS.id')]);

				$success = 'updated';

				$customerMap = new DB\SQL\Mapper($db, 'Customer');
				$customer = $customerMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

				$f3->set('customer', $customer);
				$f3->set('success', $success);
				$f3->set('html_title', 'NorthWind Customer - UPDATE Effect');
				$f3->set('content', 'customerUpdate1Effect.html');
				echo \Template::instance()->render('Layout.html');
			} 
			else 
			{
				$customerMap = new DB\SQL\Mapper($db, 'Customer');
				$customer = $customerMap->findone(array('Id = ?', $f3->get('PARAMS.id')));
		
				$f3->set('customer', $customer);
				$f3->set('theErrorMessage', $theErrorMessage);
				$f3->set('html_title', 'NorthWind Customer - UPDATE');
				$f3->set('content', 'customerUpdate1.html');
				echo \Template::instance()->render('Layout.html');
			}
		}
	}

	function Delete1($f3, $args)
	{
		require 'requirements.php';

		$customerMap = new DB\SQL\Mapper($db, 'Customer');
		$customer = $customerMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

		$f3->set('customer', $customer);
		$f3->set('html_title', 'NorthWind Customer - DELETE');
		$f3->set('content', 'customerDelete1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Delete1Act($f3)
	{
		require 'requirements.php';

		if (isset($_POST['cancel'])) 
		{
			$f3->reroute('/customerDeleteAll');
		}

		if (isset($_POST['delete'])) 
		{
			$customerMap = new DB\SQL\Mapper($db, 'Customer');
			$customer = $customerMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

			$f3->set('customer', $customer);

			$orderMapDel = new DB\SQL\Mapper($db, 'Order');
			$orderMapDel->load(array('CustomerId = ?', $f3->get('PARAMS.id')));

			if ($orderMapDel->dry())
			{
				$customer->erase();
				$success = 'deleted';
			}
			else
			{
				$success = 'unsuccessful';
			}

			$f3->set('success', $success);
			$f3->set('html_title', 'NorthWind Customer - DELETE Effect');
			$f3->set('content', 'customerDelete1Effect.html');
			echo \Template::instance()->render('Layout.html');
		}
	}
}