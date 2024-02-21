<?php

class Orders extends Controller
{
	function Read1($f3, $args)
	{
		require 'requirements.php';

		$orderMap = new DB\SQL\Mapper($db, 'OrderECS');
		$order = $orderMap->findone(array('OID = ?', $f3->get('PARAMS.id')));
		
		$orderDetailsMap = new DB\SQL\Mapper($db, 'OrderDetailProduct');
		$orderDetails = $orderDetailsMap->find(array('OrderId = ?', $f3->get('PARAMS.id')));

		$totalPrice = 0;
		foreach ($orderDetails as $orderDetail)
		{
			$totalPrice += (($orderDetail->UnitPrice * (1 - $orderDetail->Discount)) * $orderDetail->Quantity);
		}

		$f3->set('order', $order);
		$f3->set('orderDetails', $orderDetails);
		$f3->set('totalPrice', $totalPrice);
		$f3->set('html_title', 'NorthWind Order');
		$f3->set('content', 'orderRead1.html');
		echo \Template::instance()->render('Layout.html');
	}

	function ReadAllPage($f3, $args)
	{
		require 'requirements.php';

		$ordersMap = new DB\SQL\Mapper($db, 'Order');

		$NoOfRowsPerPage = $f3->get('NoOfRowsPerPage');

		$orderId = '%';
		$EmployeeId = '%';
		$CustomerId = '%';
		$ShipperId = '%';

		if ($f3->get('PARAMS.Filter') != "NoFilter") 
		{
			parse_str($f3->get('PARAMS.Filter'), $output);
			if (!empty($output['filterOrder']))
			{
				$orderId = $output['filterOrder'];
			}
			else
			{
				$orderId = '%';
			}
			if (!empty($output['EmployeeId']))
			{
				$EmployeeId = $output['EmployeeId'];
			}
			else
			{
				$EmployeeId = '%';
			}
			if (!empty($output['CustomerId']))
			{
				$CustomerId = $output['CustomerId'];
			}
			else
			{
				$CustomerId = '%';
			}
			if (!empty($output['ShipperId']))
			{
				$ShipperId = $output['ShipperId'];
			}
			else
			{
				$ShipperId = '%';
			}
		} 
		else 
		{
			$orderId = '%';
			$EmployeeId = '%';
			$CustomerId = '%';
			$ShipperId = '%';
		}

		$order = " Id ASC ";
		if ($f3->get('PARAMS.Order') == "ASC_OrderId")
		{
			$order = " Id ASC ";
		}
		if ($f3->get('PARAMS.Order') == "DESC_OrderId")
		{
			$order = " Id DESC ";
		}
		if ($f3->get('PARAMS.Order') == "ASC_OrderDate")
		{
			$order = " OrderDate ASC ";
		}
		if ($f3->get('PARAMS.Order') == "DESC_OrderDate")
		{
			$order = " OrderDate DESC ";
		}

		$limit = $NoOfRowsPerPage;
		$offset = $NoOfRowsPerPage * ($f3->get('PARAMS.Page') - 1);

		$ordersCount = $ordersMap->count(array('Id LIKE ? AND EmployeeId LIKE ? AND CustomerId LIKE ? AND ShipVia LIKE ?','%' . $orderId . '%', $EmployeeId, $CustomerId, $ShipperId));
		$orders = $ordersMap->find(array('Id LIKE ? AND EmployeeId LIKE ? AND CustomerId LIKE ? AND ShipVia LIKE ?','%' . $orderId . '%', $EmployeeId, $CustomerId, $ShipperId), array('order' => $order, 'limit' => $limit, 'offset' => $offset));

		$first_page = 1;
		$crt_page = $f3->get('PARAMS.Page');
		$prev_page = $crt_page - 1;
		$next_page = $crt_page + 1;

		$last_page = ($ordersCount / $NoOfRowsPerPage == intval($ordersCount / $NoOfRowsPerPage)) ? intval($ordersCount / $NoOfRowsPerPage) : intval($ordersCount / $NoOfRowsPerPage) + 1;

		$f3->set('orders', $orders);
		$f3->set('first_page', $first_page);
		$f3->set('last_page', $last_page);
		$f3->set('prev_page', $prev_page);
		$f3->set('next_page', $next_page);
		$f3->set('crt_page', $crt_page);
		$f3->set('html_title', 'NorthWind Orders');
		$f3->set('content', 'orderReadAllPage.html');
		echo \Template::instance()->render('Layout.html');
	}

	//! Paint filter form
	function Filter($f3)
	{
		require 'requirements.php';

		$myForm = new class
		{
		}; // Instantiate anonymous class
		$myForm->filterOrder = '';
		$myForm->EmployeeId = 0;
		$myForm->CustomerId = 0;
		$myForm->ShipperId = 0;

		$employeesMap = new DB\SQL\Mapper($db, 'Employee');
		$employees = $employeesMap->find(array(''), array('order' => 'LastName','FirstName'));

		$customersMap = new DB\SQL\Mapper($db, 'Customer');
		$customers = $customersMap->find(array(''), array('order' => 'CompanyName'));

		$shippersMap = new DB\SQL\Mapper($db, 'Shipper');
		$shippers = $shippersMap->find(array(''), array('order' => 'CompanyName'));

		$theErrorMessage = '';

		$f3->set('myForm', $myForm);
		$f3->set('theErrorMessage', $theErrorMessage);
		$f3->set('employees', $employees);
		$f3->set('customers', $customers);
		$f3->set('shippers', $shippers);
		$f3->set('html_title', 'Filter Orders');
		$f3->set('content', 'orderFilter.html');
		echo \Template::instance()->render('Layout.html');
	}

	function FilterValid($f3, &$theErrorMessage, $myForm)
	{
		require 'requirements.php';

		if ($myForm->filterOrder and !is_numeric($myForm->filterOrder)) 
		{
			$theErrorMessage = $theErrorMessage . " - Only numbers are allowed in Order Id filter - ";
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

		$myForm->filterOrder = $_POST['filterOrder'];
		$myForm->EmployeeId = $_POST['EmployeeId'];
		$myForm->CustomerId = $_POST['CustomerId'];
		$myForm->ShipperId = $_POST['ShipperId'];

		$theErrorMessage = '';
		if (Orders::FilterValid($f3, $theErrorMessage, $myForm)) 
		{
			$Page = 1;
			$Filter = "filterOrder=" . $myForm->filterOrder . "&EmployeeId=" . strval($myForm->EmployeeId) . "&CustomerId=" . strval($myForm->CustomerId) . "&ShipperId=" . strval($myForm->ShipperId);
			$Order = $_POST['Order'];

			$reRouteStr = "/orderReadAllPage/" . strval($Page) . "/" . $Filter . "/" . $Order;
			$f3->reroute($reRouteStr);
		} 
		else 
		{
			$myForm->filterOrder = '';

			$employeesMap = new DB\SQL\Mapper($db, 'Employee');
			$employees = $employeesMap->find(array(''), array('order' => 'FirstName', 'LastName'));

			$customersMap = new DB\SQL\Mapper($db, 'Customer');
			$customers = $customersMap->find(array(''), array('order' => 'CompanyName'));

			$shippersMap = new DB\SQL\Mapper($db, 'Shipper');
			$shippers = $shippersMap->find(array(''), array('order' => 'CompanyName'));

			$f3->set('myForm', $myForm);
			$f3->set('theErrorMessage', $theErrorMessage);
			$f3->set('employees', $employees);
			$f3->set('customers', $customers);
			$f3->set('shippers', $shippers);
			$f3->set('html_title', 'Filter Orders');
			$f3->set('content', 'orderFilter.html');
			echo \Template::instance()->render('Layout.html');
		}
	}

	function MyReadAllPage($f3, $args)
	{
		require 'requirements.php';

		$ordersMap = new DB\SQL\Mapper($db, 'Order');

		$NoOfRowsPerPage = $f3->get('NoOfRowsPerPage');

		$orderId = '%';
		$CustomerId = '%';
		$ShipperId = '%';

		if ($f3->get('PARAMS.Filter') != "NoFilter") 
		{
			parse_str($f3->get('PARAMS.Filter'), $output);
			if (!empty($output['filterOrder']))
			{
				$orderId = $output['filterOrder'];
			}
			else
			{
				$orderId = '%';
			}
			if (!empty($output['CustomerId']))
			{
				$CustomerId = $output['CustomerId'];
			}
			else
			{
				$CustomerId = '%';
			}
			if (!empty($output['ShipperId']))
			{
				$ShipperId = $output['ShipperId'];
			}
			else
			{
				$ShipperId = '%';
			}
		} 
		else 
		{
			$orderId = '%';
			$CustomerId = '%';
			$ShipperId = '%';
		}

		$order = " Id ASC ";
		if ($f3->get('PARAMS.Order') == "ASC_OrderId")
		{
			$order = " Id ASC ";
		}
		if ($f3->get('PARAMS.Order') == "DESC_OrderId")
		{
			$order = " Id DESC ";
		}
		if ($f3->get('PARAMS.Order') == "ASC_OrderDate")
		{
			$order = " OrderDate ASC ";
		}
		if ($f3->get('PARAMS.Order') == "DESC_OrderDate")
		{
			$order = " OrderDate DESC ";
		}

		$limit = $NoOfRowsPerPage;
		$offset = $NoOfRowsPerPage * ($f3->get('PARAMS.Page') - 1);

		$EmployeeId = $f3->get('users_id');
		$ordersCount = $ordersMap->count(array('Id LIKE ? AND EmployeeId = ? AND CustomerId LIKE ? AND ShipVia LIKE ?','%' . $orderId . '%', $EmployeeId, $CustomerId, $ShipperId));
		$orders = $ordersMap->find(array('Id LIKE ? AND EmployeeId = ? AND CustomerId LIKE ? AND ShipVia LIKE ?','%' . $orderId . '%', $EmployeeId, $CustomerId, $ShipperId), array('order' => $order, 'limit' => $limit, 'offset' => $offset));

		$first_page = 1;
		$crt_page = $f3->get('PARAMS.Page');
		$prev_page = $crt_page - 1;
		$next_page = $crt_page + 1;

		$last_page = ($ordersCount / $NoOfRowsPerPage == intval($ordersCount / $NoOfRowsPerPage)) ? intval($ordersCount / $NoOfRowsPerPage) : intval($ordersCount / $NoOfRowsPerPage) + 1;

		$f3->set('orders', $orders);
		$f3->set('first_page', $first_page);
		$f3->set('last_page', $last_page);
		$f3->set('prev_page', $prev_page);
		$f3->set('next_page', $next_page);
		$f3->set('crt_page', $crt_page);
		$f3->set('html_title', 'NorthWind My Orders');
		$f3->set('content', 'orderReadAllPageMy.html');
		echo \Template::instance()->render('Layout.html');
	}

	//! Paint filter form
	function MyFilter($f3)
	{
		require 'requirements.php';

		$myForm = new class
		{
		}; // Instantiate anonymous class
		$myForm->filterOrder = '';
		$myForm->CustomerId = 0;
		$myForm->ShipperId = 0;

		$customersMap = new DB\SQL\Mapper($db, 'Customer');
		$customers = $customersMap->find(array(''), array('order' => 'CompanyName'));

		$shippersMap = new DB\SQL\Mapper($db, 'Shipper');
		$shippers = $shippersMap->find(array(''), array('order' => 'CompanyName'));

		$theErrorMessage = '';

		$f3->set('myForm', $myForm);
		$f3->set('theErrorMessage', $theErrorMessage);
		$f3->set('customers', $customers);
		$f3->set('shippers', $shippers);
		$f3->set('html_title', 'Filter My Orders');
		$f3->set('content', 'orderFilterMy.html');
		echo \Template::instance()->render('Layout.html');
	}

	//! Process form
	function MyFilterAct($f3, $args)
	{
		require 'requirements.php';

		$myForm = new class
		{
		}; // Instantiate anonymous class

		$myForm->filterOrder = $_POST['filterOrder'];
		$myForm->CustomerId = $_POST['CustomerId'];
		$myForm->ShipperId = $_POST['ShipperId'];

		$theErrorMessage = '';
		if (Orders::FilterValid($f3, $theErrorMessage, $myForm)) 
		{
			$Page = 1;
			$Filter = "filterOrder=" . $myForm->filterOrder . "&CustomerId=" . strval($myForm->CustomerId) . "&ShipperId=" . strval($myForm->ShipperId);
			$Order = $_POST['Order'];

			$reRouteStr = "/orderReadAllPageMy/" . strval($Page) . "/" . $Filter . "/" . $Order;
			$f3->reroute($reRouteStr);
		} 
		else 
		{
			$myForm->filterOrder = '';

			$customersMap = new DB\SQL\Mapper($db, 'Customer');
			$customers = $customersMap->find(array(''), array('order' => 'CompanyName'));

			$shippersMap = new DB\SQL\Mapper($db, 'Shipper');
			$shippers = $shippersMap->find(array(''), array('order' => 'CompanyName'));

			$f3->set('myForm', $myForm);
			$f3->set('theErrorMessage', $theErrorMessage);
			$f3->set('customers', $customers);
			$f3->set('shippers', $shippers);
			$f3->set('html_title', 'Filter My Orders');
			$f3->set('content', 'orderFilterMy.html');
			echo \Template::instance()->render('Layout.html');
		}
	}

	//! Paint order form
	function Order($f3, $args)
	{
		require 'requirements.php';

		$theErrorMessage = '';

		$f3->set('theErrorMessage', $theErrorMessage);
		$f3->set('html_title', 'Order of Orders');
		$f3->set('content', 'orderOrder.html');
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

		if (Orders::OrderValid($f3, $theErrorMessage)) 
		{
			$Page = $_POST['Page'];
			$Filter = $_POST['Filter'];
			if (!empty($_POST['orderOrder']))
			{
				$Order = $_POST['orderOrder'];
			}
			else
			{
				$Order = 'NoOrder';
			}

			$reRouteStr = "/orderReadAllPage/" . strval($Page) . "/" . $Filter . "/" . $Order;
			$f3->reroute($reRouteStr);
		} 
		else 
		{
			$f3->set('theErrorMessage', $theErrorMessage);
			$f3->set('html_title', 'Order of Orders');
			$f3->set('content', 'orderOrder.html');
			echo \Template::instance()->render('Layout.html');
		}
	}

	//! Paint order form
	function MyOrder($f3, $args)
	{
		require 'requirements.php';

		$theErrorMessage = '';

		$f3->set('theErrorMessage', $theErrorMessage);
		$f3->set('html_title', 'Order of My Orders');
		$f3->set('content', 'orderOrderMy.html');
		echo \Template::instance()->render('Layout.html');
	}

	//! Process form
	function MyOrderAct($f3, $args)
	{
		require 'requirements.php';

		$theErrorMessage = '';

		if (Orders::OrderValid($f3, $theErrorMessage)) 
		{
			$Page = $_POST['Page'];
			$Filter = $_POST['Filter'];
			if (!empty($_POST['orderOrder']))
			{
				$Order = $_POST['orderOrder'];
			}
			else
			{
				$Order = 'NoOrder';
			}

			$reRouteStr = "/orderReadAllPageMy/" . strval($Page) . "/" . $Filter . "/" . $Order;
			$f3->reroute($reRouteStr);
		} 
		else 
		{
			$f3->set('theErrorMessage', $theErrorMessage);
			$f3->set('html_title', 'Order of My Orders');
			$f3->set('content', 'orderOrderMy.html');
			echo \Template::instance()->render('Layout.html');
		}
	}
}