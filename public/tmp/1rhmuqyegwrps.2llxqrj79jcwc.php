<div class="row">
    <h2 class="text-center">NorthWind Territory <strong><?= ($territory->TerritoryDescription) ?></strong>
    </h2>
</div>
<div class="row">
    Employee In Charge: <?= ($employee->TitleOfCourtesy) ?> <?= ($employee->FirstName) ?> <?= ($employee->LastName) ?>, <?= ($employee->Title)."
" ?>
    <br>
    Region: <?= ($region->RegionDescription)."
" ?>
    <br>
</div>