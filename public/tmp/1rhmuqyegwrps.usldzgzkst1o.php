<div class="row content">
    <div class="row">
        <h2 class="text-center">Shippers</h2>
    </div>
    <div class="row">
        <?php foreach (($shippers?:[]) as $shipper): ?>
            <a href="/shipperRead1/<?= ($shipper->Id) ?>" class="list-group-item list-group-item-action">
                <?= ($shipper->CompanyName)."
" ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>