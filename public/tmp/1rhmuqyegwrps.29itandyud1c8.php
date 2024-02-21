<div class="row content">
    <div class="row">
        <h2 class="text-center">NorthWind Territories</h2>
    </div>
    <div class="row">
        <?php foreach (($territories?:[]) as $territory): ?>
            <div class="row border mx-2 my-2 py-2">
                <div class="col-sm-8">
                    <?= ($territory->TerritoryDescription)."
" ?>
                </div>
                <div class="col-sm-2">
                    <a href="/territoryUpdate1/<?= ($territory->Id) ?>" class="btn btn-info" role="button">Update</a>
                </div>
                <br>
            </div>
        <?php endforeach; ?>
    </div>
</div>