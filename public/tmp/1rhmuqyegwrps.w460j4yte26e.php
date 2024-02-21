<div class="row content">
    <div class="row">
        <h2 class="text-center">Supplier <strong><?= ($supplier->CompanyName) ?></strong></h2>
    </div>
    <div class="row">
        Contact Person: <?= ($supplier->ContactName) ?>, <?= ($supplier->ContactTitle)."
" ?>
        <br>
        Address: <?= ($supplier->Address) ?>, <?= ($supplier->City) ?>, <?= ($supplier->PostalCode) ?>, <?= ($supplier->Country) ?> (<?= ($supplier->Region) ?>)
        <br>
        Phone Number: <?= ($supplier->Phone)."
" ?>
        <br>
        Fax Number:
        <?php if ($supplier->Fax): ?>
            
                <?= ($supplier->Fax)."
" ?>
            
            <?php else: ?>
                -
            
        <?php endif; ?>
        <br>
        Website:
        <?php if ($supplier->HomePage): ?>
            
               <a href="<?= ($website) ?>"><?= ($websiteText) ?></a>
            
            <?php else: ?>
                -
            
        <?php endif; ?>
        <br>
    </div>
</div>