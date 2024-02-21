<div class="row content">
    <div class="row">
        <h2 class="text-center">NorthWind Suppliers</h2>
    </div>
    <div class="row">
        <?php foreach (($suppliers?:[]) as $supplier): ?>
            <div class="row border mx-2 my-2 py-2">
                <div class="col-sm-8">
                    <?= ($supplier->CompanyName)."
" ?>
                </div>
                <div class="col-sm-2">
                    <a href="/supplierDelete1/<?= ($supplier->Id) ?>" class="btn btn-info" role="button">Delete</a>
                </div>
                <br>
            </div>
        <?php endforeach; ?>
    </div>
</div>