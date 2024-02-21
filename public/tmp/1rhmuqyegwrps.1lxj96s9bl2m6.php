<div class="row content">
    <div class="row">
        <h2 class="text-center">NorthWind Employee <strong><?= ($employee->FirstName) ?> <?= ($employee->LastName) ?></strong>
        </h2>
    </div>
    <div class="row">
        <?= ($employee->Title) ?> <?= ($employee->TitleOfCourtesy) ?> <?= ($employee->FirstName) ?> <?= ($employee->LastName)."
" ?>
        <br>
        <?= ($employee->BirthDate) ?> <?= ($employee->BirthDate)."
" ?>
        <br>
        <?= ($employee->Address) ?> <?= ($employee->City) ?> <?= ($employee->Region) ?> <?= ($employee->PostalCode)."
" ?>
        <?= ($employee->Country)."
" ?>
        <br>
        <?= ($employee->HomePhone) ?> <?= ($employee->Extension)."
" ?>
        <br>
        <?= ($employee->Notes)."
" ?>
        <br>
        Reports To
        <?php if ($employee->Manager != ''): ?>
            
                <?= ($employee->ManTitle) ?> <?= ($employee->Manager)."
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
        <?= ($success)."
" ?>
    </div>
</div>