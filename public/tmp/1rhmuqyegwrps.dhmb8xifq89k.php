<div class="row content">
    <div class="row">
        <h2 class="text-center">NorthWind Employees</h2>
    </div>
    <div class="row">
        <?php foreach (($employees?:[]) as $employee): ?>
            <a href="/employeeRead1/<?= ($employee->Id) ?>" class="list-group-item list-group-item-action">
                <?= ($employee->FirstName) ?> <?= ($employee->LastName)."
" ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>