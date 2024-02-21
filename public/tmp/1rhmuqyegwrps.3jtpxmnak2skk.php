<div class="row content">
    <div class="row">
        <h2 class="text-center">NorthWind Products of Category <strong><?= ($category->CategoryName) ?></strong></h2>
    </div>
    <div class="row">
        <?php foreach (($products?:[]) as $product): ?>
            <a href="/productRead1/<?= ($product->Id) ?>" class="list-group-item list-group-item-action">
                <?= ($product->ProductName) ?> ($<?= ($product->UnitPrice) ?>)
            </a>
        <?php endforeach; ?>
    </div>
</div>