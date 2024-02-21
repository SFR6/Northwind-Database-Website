<div class="form-group">
  <label for="ProductName">Name:</label>
  <input type="text" class="form-control" id="ProductName" name="ProductName" required
    value="<?= ($product->ProductName) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="col-sm-3">
  <label for="SupplierId">Supplier:</label><br>
  <select class="form-control" id="SupplierId" name="SupplierId" required 
  value="<?= ($product->CompanyName) ?>">
    <?php foreach (($supplier?:[]) as $supp): ?>
      <option value="<?= ($supp->Id) ?>" <?= (($supp->Id == $product->SupplierId) ? ' selected ' : '') ?>>
        <?= ($supp->CompanyName) ?></option>
    <?php endforeach; ?>
  </select>
</div>
<div class="col-sm-3">
  <label for="CategoryId">Category:</label><br>
  <select class="form-control" id="CategoryId" name="CategoryId" required
  value="<?= ($product->CategoryName) ?>">
    <?php foreach (($category?:[]) as $cat): ?>
      <option value="<?= ($cat->Id) ?>" <?= (($cat->Id == $product->CategoryId) ? ' selected ' : '') ?>>
        <?= ($cat->CategoryName) ?></option>
    <?php endforeach; ?>
  </select>
</div>
<div class="form-group">
  <label for="QuantityPerUnit">Quantity Per Unit:</label>
  <input type="text" class="form-control" id="QuantityPerUnit" name="QuantityPerUnit" required
    value="<?= ($product->QuantityPerUnit) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="UnitPrice">Unit Price:</label>
  <input type="text" class="form-control" id="UnitPrice" name="UnitPrice" required
    value="<?= ($product->UnitPrice) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="UnitsInStock">Unit In Stock:</label>
  <input type="text" class="form-control" id="UnitsInStock" name="UnitsInStock" required
    value="<?= ($product->UnitsInStock) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="form-group">
  <label for="ReorderLevel">Reorder Level:</label>
  <input type="text" class="form-control" id="ReorderLevel" name="ReorderLevel" required
    value="<?= ($product->ReorderLevel) ?>">
  <div class="invalid-feedback">Please fill out this field.</div>
</div>
<div class="col-sm-3">
  <label for="Discontinued">Discontinued:</label><br>
  <select class="form-control" id="Discontinued" name="Discontinued" required value="<?= ($product->Discontinued) ?>">
    <option value="0">No</option>
    <option value="1">Yes</option>
  </select>
</div>