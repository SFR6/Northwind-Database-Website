<div class="row content">
    <div class="row">
        <h2 class="text-center">NorthWind Shippers</h2>
    </div>
    <div class="row">
        <?php foreach (($shippers?:[]) as $shipper): ?>
            <div class="row border mx-2 my-2 py-2">
                <div class="col-sm-8">
                    <?= ($shipper->CompanyName)."
" ?>
                </div>
                <div class="col-sm-2">
                    <a href="/shipperDelete1/<?= ($shipper->Id) ?>" class="btn btn-info" role="button">Delete</a>
                </div>
                <br>
            </div>
        <?php endforeach; ?>
    </div>
</div>