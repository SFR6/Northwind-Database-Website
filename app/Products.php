<?php

class Products extends Controller
{
	function ReadAll1Category($f3, $args)
	{
		require 'requirements.php';

		$categoryMap = new DB\SQL\Mapper($db, 'Category');
		$category = $categoryMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

		$productsMap = new DB\SQL\Mapper($db, 'ProductDetails');
		$products = $productsMap->find(array('CategoryId = ?', $f3->get('PARAMS.id')), array('order' => 'ProductName'));

		$f3->set('category', $category);
		$f3->set('products', $products);
		$f3->set('html_title', 'NorthWind Products');
		$f3->set('content', 'productReadAll1Category.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Read1($f3, $args)
	{

		require 'requirements.php';

		$productMap = new DB\SQL\Mapper($db, 'ProductDetails');
		$product = $productMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

		$f3->set('product', $product);
		$f3->set('html_title', 'NorthWind Product');
		$f3->set('content', 'productRead1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function ReadAllPage($f3, $args)
	{

		require 'requirements.php';

		$productsMap = new DB\SQL\Mapper($db, 'Product');

		$NoOfRowsPerPage = $f3->get('NoOfRowsPerPage');

		$productName = '%';
		$CategoryId = '%';
		$SupplierId = '%';

		if ($f3->get('PARAMS.Filter') != "NoFilter") 
		{
			parse_str($f3->get('PARAMS.Filter'), $output);
			if (!empty($output['filterProduct']))
			{
				$productName = $output['filterProduct'];
			}
			else
			{
				$productName = '%';
			}
			if (!empty($output['CategoryId']))
			{
				$CategoryId = $output['CategoryId'];
			}
			else
			{
				$CategoryId = '%';
			}
			if (!empty($output['SupplierId']))
			{
				$SupplierId =  $output['SupplierId'];
			}
			else
			{
				$SupplierId = '%';
			}
		} 
		else 
		{
			$productName = '%';
			$CategoryId = '%';
			$SupplierId = '%';
		}

		$order = " ProductName ASC ";
		if ($f3->get('PARAMS.Order') == "ASC_Name")
		{
			$order = " ProductName ASC ";
		}
		if ($f3->get('PARAMS.Order') == "DESC_Name")
		{
			$order = " ProductName DESC ";
		}
		if ($f3->get('PARAMS.Order') == "ASC_Price")
		{
			$order = " UnitPrice ASC ";
		}
		if ($f3->get('PARAMS.Order') == "DESC_Price")
		{
			$order = " UnitPrice DESC ";
		}

		$limit = $NoOfRowsPerPage;
		$offset = $NoOfRowsPerPage * ($f3->get('PARAMS.Page') - 1);

		$productsCount = $productsMap->count(array('ProductName LIKE ? AND CategoryId LIKE ? AND SupplierId LIKE ?','%' . $productName . '%', $CategoryId, $SupplierId));
		$products = $productsMap->find(array('ProductName LIKE ? AND CategoryId LIKE ? AND SupplierId LIKE ?','%' . $productName . '%', $CategoryId, $SupplierId), array('order' => $order, 'limit' => $limit, 'offset' => $offset));

		$first_page = 1;
		$crt_page = $f3->get('PARAMS.Page');
		$prev_page = $crt_page - 1;
		$next_page = $crt_page + 1;

		$last_page = ($productsCount / $NoOfRowsPerPage == intval($productsCount / $NoOfRowsPerPage)) ? intval($productsCount / $NoOfRowsPerPage) : intval($productsCount / $NoOfRowsPerPage) + 1;

		$f3->set('products', $products);
		$f3->set('first_page', $first_page);
		$f3->set('last_page', $last_page);
		$f3->set('prev_page', $prev_page);
		$f3->set('next_page', $next_page);
		$f3->set('crt_page', $crt_page);
		$f3->set('html_title', 'NorthWind Products');
		$f3->set('content', 'productReadAllPage.html');
		echo \Template::instance()->render('Layout.html');
	}

	//! Paint filter form
	function Filter($f3)
	{
		require 'requirements.php';

		$myForm = new class
		{
		}; // Instantiate anonymous class
		$myForm->filterProduct = '';
		$myForm->CategoryId = 0;
		$myForm->SupplierId = 0;

		$categoriesMap = new DB\SQL\Mapper($db, 'Category');
		$categories = $categoriesMap->find(array(''), array('order' => 'CategoryName'));

		$suppliersMap = new DB\SQL\Mapper($db, 'Supplier');
		$suppliers = $suppliersMap->find(array(''), array('order' => 'CompanyName'));

		$theErrorMessage = '';

		$f3->set('myForm', $myForm);
		$f3->set('theErrorMessage', $theErrorMessage);
		$f3->set('categories', $categories);
		$f3->set('suppliers', $suppliers);
		$f3->set('html_title', 'Filter Products');
		$f3->set('content', 'productFilter.html');
		echo \Template::instance()->render('Layout.html');
	}

	function FilterValid($f3, &$theErrorMessage, $myForm)
	{
		require 'requirements.php';

		if (!preg_match("/^[a-zA-Z-' ]*$/", $myForm->filterProduct)) 
		{
			$theErrorMessage = $theErrorMessage . " - Only letters and numbers are allowed in Product Name filter - ";
		}

		return $theErrorMessage == '';
	}

	//! Process form
	function FilterAct($f3, $args)
	{
		require 'requirements.php';

		$myForm = new class
		{
		}; // Instantiate anonymous class

		$myForm->filterProduct = $_POST['filterProduct'];
		$myForm->CategoryId = $_POST['CategoryId'];
		$myForm->SupplierId = $_POST['SupplierId'];

		$theErrorMessage = '';
		if (Products::FilterValid($f3, $theErrorMessage, $myForm)) 
		{
			$Page = 1;
			$Filter = "filterProduct=" . $myForm->filterProduct . "&CategoryId=" . strval($myForm->CategoryId) . "&SupplierId=" . strval($myForm->SupplierId);
			$Order = $_POST['Order'];

			$reRouteStr = "/productReadAllPage/" . strval($Page) . "/" . $Filter . "/" . $Order;
			$f3->reroute($reRouteStr);
		} 
		else 
		{
			$myForm->filterProduct = '';

			$categoriesMap = new DB\SQL\Mapper($db, 'Category');
			$categories = $categoriesMap->find(array(''), array('order' => 'CategoryName'));

			$suppliersMap = new DB\SQL\Mapper($db, 'Supplier');
			$suppliers = $suppliersMap->find(array(''), array('order' => 'CompanyName'));

			$f3->set('myForm', $myForm);
			$f3->set('theErrorMessage', $theErrorMessage);
			$f3->set('categories', $categories);
			$f3->set('suppliers', $suppliers);
			$f3->set('html_title', 'Filter Products');
			$f3->set('content', 'productFilter.html');
			echo \Template::instance()->render('Layout.html');
		}
	}

	//! Paint order form
	function Order($f3, $args)
	{
		require 'requirements.php';

		$theErrorMessage = '';

		$f3->set('theErrorMessage', $theErrorMessage);
		$f3->set('html_title', 'Order of Products');
		$f3->set('content', 'productOrder.html');
		echo \Template::instance()->render('Layout.html');
	}

	function OrderValid($f3, &$theErrorMessage)
	{
		require 'requirements.php';
		return true;
	}

	//! Process form
	function OrderAct($f3, $args)
	{
		require 'requirements.php';

		$theErrorMessage = '';

		if (Products::OrderValid($f3, $theErrorMessage)) 
		{
			$Page = $_POST['Page'];
			$Filter = $_POST['Filter'];
			if (!empty($_POST['orderProduct']))
			{
				$Order = $_POST['orderProduct'];
			}
			else
			{
				$Order = 'NoOrder';
			}

			$reRouteStr = "/productReadAllPage/" . strval($Page) . "/" . $Filter . "/" . $Order;
			$f3->reroute($reRouteStr);
		} 
		else 
		{
			$f3->set('theErrorMessage', $theErrorMessage);
			$f3->set('html_title', 'Order of Products');
			$f3->set('content', 'productOrder.html');
			echo \Template::instance()->render('Layout.html');
		}
	}

	function Create($f3)
	{
		require 'requirements.php';

		$productMap = new DB\SQL\Mapper($db, 'ProductDetails');

		$categoryMap = new DB\SQL\Mapper($db, 'Category');
		$category = $categoryMap->find(array(''), array('order' => 'CategoryName'));

		$supplierMap = new DB\SQL\Mapper($db, 'Supplier');
		$supplier = $supplierMap->find(array(''), array('order' => 'CompanyName'));

		$f3->set('product', $productMap);
		$f3->set('category', $category);
		$f3->set('supplier', $supplier);
		$f3->set('theErrorMessage', '');
		$f3->set('html_title', 'NorthWind - Create New Product');
		$f3->set('content', 'productCreate.html');
		echo \Template::instance()->render('Layout.html');
	}

	function ValidCreate($f3, &$theErrorMessage, $productMap)
	{
		require 'requirements.php';

		if (!preg_match("/^[a-zA-Z-' ]*$/", $productMap->ProductName)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Name: Only letters and white space are allowed - ";
		}
		if (!is_numeric($productMap->UnitPrice))
		{
			$theErrorMessage = $theErrorMessage . " - in Unit Price: Only numbers are allowed - ";
		}
		if (!is_numeric($productMap->UnitsInStock))
		{
			$theErrorMessage = $theErrorMessage . " - in Units In Stock: Only numbers are allowed - ";
		}
		if (!is_numeric($productMap->ReorderLevel))
		{
			$theErrorMessage = $theErrorMessage . " - in Reorder Level: Only numbers are allowed - ";
		}

		$productMap1 = new DB\SQL\Mapper($db, 'Product');
		$productMap1->load(array('UPPER(ProductName) = ? ', strtoupper($productMap->ProductName)));
		if (!$productMap1->dry()) 
		{
			$theErrorMessage = $theErrorMessage . " - Name is Not UNIQUE - ";
		}

		return $theErrorMessage == '';
	}

	function CreateAct($f3)
	{
		require 'requirements.php';

		$productMap = new DB\SQL\Mapper($db, 'Product');
		$productMap->copyfrom('POST');

		$theErrorMessage = '';
		if (Products::ValidCreate($f3, $theErrorMessage, $productMap))
		{
			$rows = $db->exec('SELECT MAX(Id) AS LastId FROM Product;');
			foreach ($rows as $row)
			{
				$Id = $row['LastId'];
			}
			++$Id;

			$sql = "INSERT INTO Product (Id, ProductName, SupplierId, CategoryId, QuantityPerUnit, UnitPrice, UnitsInStock, UnitsOnOrder, ReorderLevel, Discontinued) VALUES (?,?,?,?,?,?,?,?,?,?)";
			$stmt= $db->prepare($sql);
			$stmt->execute([$Id, $f3->get('POST.ProductName'), $f3->get('POST.SupplierId'), $f3->get('POST.CategoryId'), $f3->get('POST.QuantityPerUnit'), $f3->get('POST.UnitPrice'), $f3->get('POST.UnitsInStock'), 0, $f3->get('POST.ReorderLevel'), $f3->get('POST.Discontinued')]);

			$f3->reroute('/');
		} 
		else 
		{
			$productMap = new DB\SQL\Mapper($db, 'ProductDetails');

			$categoryMap = new DB\SQL\Mapper($db, 'Category');
			$category = $categoryMap->find(array(''), array('order' => 'CategoryName'));
	
			$supplierMap = new DB\SQL\Mapper($db, 'Supplier');
			$supplier = $supplierMap->find(array(''), array('order' => 'CompanyName'));
	
			$f3->set('product', $productMap);
			$f3->set('category', $category);
			$f3->set('supplier', $supplier);
			$f3->set('theErrorMessage', $theErrorMessage);
			$f3->set('html_title', 'NorthWind - Create New Product');
			$f3->set('content', 'productCreate.html');
			echo \Template::instance()->render('Layout.html');
		}
	}

	function Browse($f3, $args)
	{
		require 'requirements.php';

		$productsMap = new DB\SQL\Mapper($db, 'Product');
		$products = $productsMap->find(array(''), array('order' => 'ProductName'));

		$f3->set('products', $products);
		$f3->set('html_title', 'NorthWind Products');
		$f3->set('content', 'productBrowse.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Browse2($f3, $args)
	{
		require 'requirements.php';

		$productsMap = new DB\SQL\Mapper($db, 'Product');
		$products = $productsMap->find(array(''), array('order' => 'ProductName'));

		$f3->set('products', $products);
		$f3->set('html_title', 'NorthWind Products');
		$f3->set('content', 'productBrowse2.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Update1($f3, $args)
	{
		require 'requirements.php';

		$productMap = new DB\SQL\Mapper($db, 'ProductDetails');
		$product = $productMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

		$categoryMap = new DB\SQL\Mapper($db, 'Category');
		$category = $categoryMap->find(array(''), array('order' => 'CategoryName'));

		$supplierMap = new DB\SQL\Mapper($db, 'Supplier');
		$supplier = $supplierMap->find(array(''), array('order' => 'CompanyName'));

		$f3->set('product', $product);
		$f3->set('category', $category);
		$f3->set('supplier', $supplier);
		$f3->set('theErrorMessage', '');
		$f3->set('html_title', 'NorthWind Product - UPDATE');
		$f3->set('content', 'productUpdate1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function ValidUpdate($f3, &$theErrorMessage, $productMap)
	{
		require 'requirements.php';

		if (!preg_match("/^[a-zA-Z-' ]*$/", $productMap->ProductName)) 
		{
			$theErrorMessage = $theErrorMessage . " - in Name: Only letters and white space are allowed - ";
		}
		if (!is_numeric($productMap->UnitPrice))
		{
			$theErrorMessage = $theErrorMessage . " - in Unit Price: Only numbers are allowed - ";
		}
		if (!is_numeric($productMap->UnitsInStock))
		{
			$theErrorMessage = $theErrorMessage . " - in Units In Stock: Only numbers are allowed - ";
		}
		if (!is_numeric($productMap->ReorderLevel))
		{
			$theErrorMessage = $theErrorMessage . " - in Reorder Level: Only numbers are allowed - ";
		}

		$productMap1 = new DB\SQL\Mapper($db, 'Product');
		$productMap1->load(array('UPPER(ProductName) = ? AND Id != ?', strtoupper($productMap->ProductName), $productMap->Id));
		if (!$productMap1->dry()) 
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
			$f3->reroute('/productUpdateAll');
		}

		if (isset($_POST['update'])) 
		{
			$productMap = new DB\SQL\Mapper($db, 'Product');
			$productMap->copyFrom('POST');

			$theErrorMessage = '';
			if (Products::ValidUpdate($f3, $theErrorMessage, $productMap))
			{
				$sql = "UPDATE Product SET ProductName = ?, SupplierId = ?, CategoryId = ?, QuantityPerUnit = ?, UnitPrice = ?, UnitsInStock = ?, ReorderLevel = ?, Discontinued = ?  WHERE Id = ?";
				$stmt= $db->prepare($sql);
				$stmt->execute([$f3->get('POST.ProductName'), $f3->get('POST.SupplierId'), $f3->get('POST.CategoryId'), $f3->get('POST.QuantityPerUnit'), $f3->get('POST.UnitPrice'), $f3->get('POST.UnitsInStock'), $f3->get('POST.ReorderLevel'), $f3->get('POST.Discontinued'), $f3->get('POST.Id')]);

				$success = 'updated';

				$productMap = new DB\SQL\Mapper($db, 'ProductDetails');
				$product = $productMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

				$f3->set('product', $product);
				$f3->set('success', $success);
				$f3->set('html_title', 'NorthWind Product - UPDATE Effect');
				$f3->set('content', 'productUpdate1Effect.html');
				echo \Template::instance()->render('Layout.html');
			} 
			else 
			{
				$productMap = new DB\SQL\Mapper($db, 'ProductDetails');
				$product = $productMap->findone(array('Id = ?', $f3->get('PARAMS.id')));
		
				$categoryMap = new DB\SQL\Mapper($db, 'Category');
				$category = $categoryMap->find(array(''), array('order' => 'CategoryName'));
		
				$supplierMap = new DB\SQL\Mapper($db, 'Supplier');
				$supplier = $supplierMap->find(array(''), array('order' => 'CompanyName'));
		
				$f3->set('product', $product);
				$f3->set('category', $category);
				$f3->set('supplier', $supplier);
				$f3->set('theErrorMessage', $theErrorMessage);
				$f3->set('html_title', 'NorthWind Product - UPDATE');
				$f3->set('content', 'productUpdate1.html');
				echo \Template::instance()->render('Layout.html');
			}
		}
	}

	function Delete1($f3, $args)
	{
		require 'requirements.php';

		$productMap = new DB\SQL\Mapper($db, 'ProductDetails');
		$product = $productMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

		$categoryMap = new DB\SQL\Mapper($db, 'Category');
		$category = $categoryMap->find(array(''), array('order' => 'CategoryName'));

		$supplierMap = new DB\SQL\Mapper($db, 'Supplier');
		$supplier = $supplierMap->find(array(''), array('order' => 'CompanyName'));

		$f3->set('product', $product);
		$f3->set('category', $category);
		$f3->set('supplier', $supplier);
		$f3->set('html_title', 'NorthWind Product - DELETE');
		$f3->set('content', 'productDelete1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function Delete1Act($f3)
	{
		require 'requirements.php';

		if (isset($_POST['cancel'])) 
		{
			$f3->reroute('/productDeleteAll');
		}

		if (isset($_POST['delete'])) 
		{
			$productDetailsMap = new DB\SQL\Mapper($db, 'ProductDetails');
			$productDetails = $productDetailsMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

			$f3->set('product', $productDetails);

			$productDelMap = new DB\SQL\Mapper($db, 'Product');
			$productDel = $productDelMap->findone(array('Id = ?', $f3->get('PARAMS.id')));

			$orderDetailMapDel = new DB\SQL\Mapper($db, 'OrderDetail');
			$orderDetailMapDel->load(array('ProductId = ?', $f3->get('PARAMS.id')));

			if ($orderDetailMapDel->dry())
			{
				$productDel->erase();
				$success = 'deleted';
			}
			else
			{
				$success = 'unsuccessful';
			}

			$f3->set('success', $success);
			$f3->set('html_title', 'NorthWind Product - DELETE Effect');
			$f3->set('content', 'productDelete1Effect.html');
			echo \Template::instance()->render('Layout.html');
		}
	}
}