<div class="form-group">
  <label for="FirstName">First Name:</label>
  <input type="text" class="form-control" id="FirstName" name="FirstName" required
    value="<?= ($employee->FirstName) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="LastName">Last Name:</label>
  <input type="text" class="form-control" id="LastName" name="LastName" required
    value="<?= ($employee->LastName) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="Title">Title:</label>
  <input type="text" class="form-control" id="FirstName" name="Title" required
    value="<?= ($employee->Title) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="TitleOfCourtesy">Title of Courtesy:</label>
  <input type="text" class="form-control" id="TitleOfCourtesy" name="TitleOfCourtesy"
    value="<?= ($employee->TitleOfCourtesy) ?>">
</div>
<div class="form-group">
  <label for="BirthDate">Date of Birth:</label>
  <input type="text" class="form-control" id="BirthDate" name="BirthDate" required
    value="<?= ($employee->BirthDate) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="HireDate">Date of Hire:</label>
  <input type="text" class="form-control" id="HireDate" name="HireDate" required
    value="<?= ($employee->HireDate) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="Address">Address:</label>
  <input type="text" class="form-control" id="Address" name="Address"
    value="<?= ($employee->Address) ?>">
</div>
<div class="form-group">
  <label for="City">City:</label>
  <input type="text" class="form-control" id="City" name="City" value="<?= ($employee->City) ?>">
</div>
<div class="form-group">
  <label for="Region">Region:</label>
  <input type="text" class="form-control" id="Region" name="Region"
    value="<?= ($employee->Region) ?>">
</div>
<div class="form-group">
  <label for="PostalCode">Postal Code:</label>
  <input type="text" class="form-control" id="PostalCode" name="PostalCode"
    value="<?= ($employee->PostalCode) ?>">
</div>
<div class="form-group">
  <label for="Country">Country:</label>
  <input type="text" class="form-control" id="Country" name="Country"
    value="<?= ($employee->Country) ?>">
</div>
<div class="form-group">
  <label for="HomePhone">Phone Number:</label>
  <input type="text" class="form-control" id="HomePhone" name="HomePhone"
    value="<?= ($employee->HomePhone) ?>">
</div>
<div class="form-group">
  <label for="Extension">Extension:</label>
  <input type="text" class="form-control" id="Extension" name="Extension"
    value="<?= ($employee->Extension) ?>">
</div>
<div class="form-group">
  <label for="Notes">Notes:</label><br>
  <textarea name="Notes" rows="6" cols="134"><?= ($employee->Notes) ?></textarea>
</div>
<div class="form-group">
  <label for="salary">Salary:</label>
  <input type="number" class="form-control" id="salary" name="salary" value="<?= ($employee['salary']) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="col-sm-3">
  <label for="ReportsTo">Reports to Manager:</label><br>
  <select class="form-control" id="ReportsTo" name="ReportsTo">
    <option value="0">NOT Selected</option>
    <?php foreach (($managers?:[]) as $manager): ?>
      <option value="<?= ($manager->Id) ?>" <?= (($manager->Id == $employee->ReportsTo) ? ' selected ' : '') ?>>
        <?= ($manager->LastName) ?> <?= ($manager->FirstName) ?></option>
    <?php endforeach; ?>
  </select>
</div>
<div class="form-group">
  <label for="email">E-Mail:</label>
  <input type="text" class="form-control" id="email" name="email" required value="<?= ($employee['email']) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="password">Password:</label>
  <input type="password" class="form-control" id="password" name="password" value="">
</div>
<div class="form-group">
  <label for="PassWordR">Repeat Password:</label>
  <input type="password" class="form-control" id="PassWordR" name="PassWordR" value="">
</div>
<?php if ($employee->PhotoPath != ''): ?>
  
    <div class="col-sm-6">
      <img src="/assets/<?= ($employee->PhotoPath) ?>" class="rounded w-100" width="500" height="333"
        alt="<?= ($employee->FirstName) ?> <?= ($employee->LastName) ?>">
    </div>
  
  <?php else: ?>
    <p>No Photo Image</p>
  
<?php endif; ?>
<div class="form-group">
    <label for="picture">Picture:</label>
    <input type="file" class="form-control" id="picture" name="picture" value="<?= ($employee->PhotoPath) ?>">
</div>
