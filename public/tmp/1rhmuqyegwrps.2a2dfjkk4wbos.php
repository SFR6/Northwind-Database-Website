<div class="row content">
    <div class="row">
        <h2 class="text-center">Suppliers</h2>
    </div>
    <div class="row">
        <?php foreach (($suppliers?:[]) as $supplier): ?>
            <a href="/supplierRead1/<?= ($supplier->Id) ?>" class="list-group-item list-group-item-action">
                <?= ($supplier->CompanyName)."
" ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>