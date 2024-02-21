<div class="row content">
    <div class="row">
        <h2 class="text-center">Customers</h2>
    </div>
    <div class="row">
        <?php foreach (($customers?:[]) as $customer): ?>
            <a href="/customerRead1/<?= ($customer->Id) ?>" class="list-group-item list-group-item-action">
                <?= ($customer->CompanyName)."
" ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>