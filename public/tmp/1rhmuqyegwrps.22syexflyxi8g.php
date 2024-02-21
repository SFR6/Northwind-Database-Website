<div class="row content">
    <div class="row">
        <h2 class="text-center">NorthWind Product <strong><?= ($product->ProductName) ?></strong></h2>
    </div>
    <div class="row">
        Category: <?= ($product->CategoryName) ?> 
        <br>
        Supplier: <?= ($product->CompanyName) ?> 
        <br>
        Quantity Per Unit: <?= ($product->QuantityPerUnit) ?> 
        <br>
        Unit Price: <?= ($product->UnitPrice) ?> 
        <br>
        Units In Stock: <?= ($product->UnitsInStock) ?> 
        <br>
        Units On Order: <?= ($product->UnitsOnOrder) ?> 
        <br>
        Reorder Level: <?= ($product->ReorderLevel) ?> 
        <br>
        Discontinued: 
        <?php if ($product->Discontinued): ?>
            
                Yes
            
            <?php else: ?>
                No
            
        <?php endif; ?>
        <br>
    </div>
</div>