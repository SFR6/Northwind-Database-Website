<div class="row content">
    <div class="row">
        <h2 class="text-center">NorthWind Order No. <strong><?= ($order->OID) ?></strong></h2>
    </div>
    <div class="row">
        Customer Company: <?= ($order->CustomerCompanyName)."
" ?>
        <br>
        Employee In Charge: <?= ($order->TitleOfCourtesy) ?> <?= ($order->FirstName) ?> <?= ($order->LastName) ?>, <?= ($order->Title)."
" ?>
        <br>
        Order Date: <?= ($order->OrderDate)."
" ?>
        <br>
        Required Date: <?= ($order->RequiredDate)."
" ?>
        <br>
        Shipped Date: <?= ($order->ShippedDate)."
" ?>
        <br>
        Shipping Company: <?= ($order->ShipperCompanyName)."
" ?>
        <br>
        Freight: <?= ($order->Freight)."
" ?>
        <br>
        Ship Name: <?= ($order->ShipName)."
" ?>
        <br>
        Ship Address: <?= ($order->ShipAddress) ?>, <?= ($order->ShipCity) ?>, <?= ($order->ShipPostalCode) ?>, <?= ($order->ShipCountry) ?> (<?= ($order->ShipRegion) ?>)
        <br>
        Product(s):
        <br>
        <ol>
            <?php foreach (($orderDetails?:[]) as $orderDetail): ?>
                <br>
                <li>
                    Name: <?= ($orderDetail->ProductName)."
" ?>
                    <br>
                    Price: $<?= ($orderDetail->UnitPrice)."
" ?>
                    <br>
                    Quantity: <?= ($orderDetail->Quantity)."
" ?>
                    <br>
                    Discount: <?= ($orderDetail->Discount * 100) ?>%
                    <br>
                    Discounted Price: $<?= ($orderDetail->UnitPrice * (1 - $orderDetail->Discount))."
" ?>
                    <br>
                </li>
                <br>
            <?php endforeach; ?>
        </ol>
        <br>
        Total Price: $<?= ($totalPrice)."
" ?>
        <br>
    </div>
</div>