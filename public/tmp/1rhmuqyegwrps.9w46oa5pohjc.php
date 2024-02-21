<div class="row content">
    <div class="row">
        <h2 class="text-center">Customer <strong><?= ($customer->CompanyName) ?></strong></h2>
    </div>
    <div class="row">
        Contact Person: <?= ($customer->ContactName) ?>, <?= ($customer->ContactTitle)."
" ?>
        <br>
        Address: <?= ($customer->Address) ?>, <?= ($customer->City) ?>, <?= ($customer->PostalCode) ?>, <?= ($customer->Country) ?> (<?= ($customer->Region) ?>)
        <br>
        Phone Number: <?= ($customer->Phone)."
" ?>
        <br>
        Fax Number:
        <?php if ($customer->Fax): ?>
            
                <?= ($customer->Fax)."
" ?>
            
            <?php else: ?>
                -
            
        <?php endif; ?>
        <br>
    </div>
</div>