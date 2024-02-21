<div class="form-group">
  <label for="CompanyName">Company Name:</label>
  <input type="text" class="form-control" id="CompanyName" name="CompanyName" required
    value="<?= ($customer->CompanyName) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="ContactName">Contact Person Name:</label>
  <input type="text" class="form-control" id="ContactName" name="ContactName" required
    value="<?= ($customer->ContactName) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="ContactTitle">Contact Person Title:</label>
  <input type="text" class="form-control" id="ContactTitle" name="ContactTitle" required
    value="<?= ($customer->ContactTitle) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="Address">Address:</label>
  <input type="text" class="form-control" id="Address" name="Address" required
    value="<?= ($customer->Address) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="City">City:</label>
  <input type="text" class="form-control" id="City" name="City" required
    value="<?= ($customer->City) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="Region">Region:</label>
  <input type="text" class="form-control" id="Region" name="Region" required
    value="<?= ($customer->Region) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="PostalCode">Postal Code:</label>
  <input type="text" class="form-control" id="PostalCode" name="PostalCode" required
    value="<?= ($customer->PostalCode) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="Country">Country:</label>
  <input type="text" class="form-control" id="Country" name="Country" required
    value="<?= ($customer->Country) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="Phone">Phone Number:</label>
  <input type="text" class="form-control" id="Phone" name="Phone" required
    value="<?= ($customer->Phone) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="Fax">Fax Number:</label>
  <input type="text" class="form-control" id="Fax" name="Fax"
    value="<?= ($customer->Fax) ?>">
</div>