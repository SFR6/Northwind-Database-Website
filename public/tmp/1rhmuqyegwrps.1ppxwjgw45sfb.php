<div class="form-group">
  <label for="TerritoryDescription">Territory Name:</label>
  <input type="text" class="form-control" id="TerritoryDescription" name="TerritoryDescription" required
    value="<?= ($territory->TerritoryDescription) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="col-sm-3">
  <label for="RegionId">Region:</label><br>
  <select class="form-control" id="RegionId" name="RegionId" required 
  value="<?= ($territory->RegionId) ?>">
    <option value="0">NOT Selected</option>
    <?php foreach (($region?:[]) as $reg): ?>
      <option value="<?= ($reg->Id) ?>" <?= (($reg->Id == $territory->RegionId) ? ' selected ' : '') ?>>
        <?= ($reg->RegionDescription) ?></option>
    <?php endforeach; ?>
  </select>
</div>
<div class="col-sm-3">
  <label for="EmployeeId">Employee:</label><br>
  <select class="form-control" id="EmployeeId" name="EmployeeId" required
  value="<?= ($employeeTerritory->EmployeeId) ?>">
    <option value="0">NOT Selected</option>
    <?php foreach (($employee?:[]) as $emp): ?>
      <option value="<?= ($emp->Id) ?>" <?= (($emp->Id == $employeeTerritory->EmployeeId) ? ' selected ' : '') ?>>
        <?= ($emp->FirstName) ?> <?= ($emp->LastName) ?></option>
    <?php endforeach; ?>
  </select>
</div>
