<div class="form-group">
  <label for="CompanyName">Company Name:</label>
  <input type="text" class="form-control" id="CompanyName" name="CompanyName" required
    value="<?= ($shipper->CompanyName) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="Phone">Phone Number:</label>
  <input type="text" class="form-control" id="Phone" name="Phone" required
    value="<?= ($shipper->Phone) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>