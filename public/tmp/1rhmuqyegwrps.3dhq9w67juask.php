<div class="row content">
    <div class="row">
        <h2 class="text-center">NorthWind Customers</h2>
    </div>
    <div class="row">
        <?php foreach (($customers?:[]) as $customer): ?>
            <div class="row border mx-2 my-2 py-2">
                <div class="col-sm-8">
                    <?= ($customer->CompanyName)."
" ?>
                </div>
                <div class="col-sm-2">
                    <a href="/customerDelete1/<?= ($customer->Id) ?>" class="btn btn-info" role="button">Delete</a>
                </div>
                <br>
            </div>
        <?php endforeach; ?>
    </div>
</div>