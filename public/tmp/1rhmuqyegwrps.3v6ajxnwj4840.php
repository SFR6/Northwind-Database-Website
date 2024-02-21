<div class="row">
    <h2 class="text-center">NorthWind Employee <strong><?= ($employee->FirstName) ?> <?= ($employee->LastName) ?></strong>
    </h2>
</div>
<div class="row">
    <?= ($employee->TitleOfCourtesy) ?> <?= ($employee->FirstName) ?> <?= ($employee->LastName) ?>, <?= ($employee->Title)."
" ?>
    <br>
    Birth Date: <?= ($employee->BirthDate)."
" ?>
    <br>
    Address: <?= ($employee->Address) ?>, <?= ($employee->City) ?>, <?= ($employee->Region) ?>, <?= ($employee->Country)."
" ?>
    <br>
    Postal code: <?= ($employee->PostalCode)."
" ?>
    <br>
    Phone number: <?= ($employee->HomePhone)."
" ?>
    <br>
    Extension: <?= ($employee->Extension)."
" ?>
    <br>
    Notes: <?= ($employee->Notes)."
" ?>
    <br>
    Reports to:
    <?php if ($employee->Manager != ''): ?>
        
            <?= ($employee->ManTitle) ?>, <?= ($employee->Manager)."
" ?>
        
        <?php else: ?>
            None
        
    <?php endif; ?>
    <br>
    <?php if ($employee->PhotoPath != ''): ?>
        
            <div class="col-sm-6">
                <img src="/assets/<?= ($employee->PhotoPath) ?>" class="rounded w-100" width="500" height="333"
                    alt="<?= ($employee->FirstName) ?> <?= ($employee->LastName) ?>">
            </div>
        
        <?php else: ?>
            <p>No Photo Image</p>
        
    <?php endif; ?>
</div>