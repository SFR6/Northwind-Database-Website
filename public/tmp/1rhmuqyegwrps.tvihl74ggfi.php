<div class="row content">
    <div class="row">
        <h2 class="text-center">NorthWind Employees</h2>
    </div>
    <div class="row">
        <?php foreach (($employees?:[]) as $employee): ?>
            <div class="row border mx-2 my-2 py-2">
                <div class="col-sm-8">
                    <?= ($employee->FirstName) ?> <?= ($employee->LastName)."
" ?>
                </div>
                <div class="col-sm-2">
                    <a href="/employeeUpdate1/<?= ($employee->Id) ?>" class="btn btn-info" role="button">Update</a>
                </div>
                <br>
            </div>
        <?php endforeach; ?>
    </div>
</div>