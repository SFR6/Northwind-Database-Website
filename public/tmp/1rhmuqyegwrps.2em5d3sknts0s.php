<div class="row content">
    <div class="row">
        <h2 class="text-center">Employees Territories</h2>
    </div>
    <div class="row">
        <?php foreach (($result?:[]) as $employee): ?>
            <a href="/territoryRead1/<?= ($employee->EID) ?>" class="list-group-item list-group-item-action">
                <?= ($employee->FirstName) ?> <?= ($employee->LastName) ?> - <?= ($employee->NumberOfTerritories)."
" ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>