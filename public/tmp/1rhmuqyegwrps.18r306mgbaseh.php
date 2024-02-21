<div class="row content">
  <div class="row">
    <h2 class="text-center">Filter Products</h2>
  </div>
  <div class="row">
    <?php if ($theErrorMessage != ''): ?>
      
        <div class="panel panel-default bg-warning text-white">
          <div class="panel-body">
            <?= ($theErrorMessage)."
" ?>
          </div>
        </div>
      
    <?php endif; ?>
  </div>

  <div class="row">
    <form method="POST">
      <div class="row">
        <div class="col-sm-3">
          <div class="form-group">
            <label for="filterProduct">Product Name (contain)</label>
            <input type="text" class="form-contrlo" id="filterProduct" name="filterProduct"
              value="<?= ($myForm->filterProduct) ?>">
          </div>
        </div>
        <div class="col-sm-1">
          &nbsp;
        </div>
        <div class="col-sm-3">
          <label for="CategoryId">Category</label><br>
          <select class="form-control" id="CategoryId" name="CategoryId">
            <option value="0">NOT Selected</option>
            <?php foreach (($categories?:[]) as $category): ?>
              <option value="<?= ($category->Id) ?>" <?= (($category->Id == $myForm->CategoryId) ? ' selected ' : '') ?>>
                <?= ($category->CategoryName) ?> </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-sm-1">
          &nbsp;
        </div>
        <div class="col-sm-3">
          <label for="SupplierId">Supplier</label><br>
          <select class="form-control" id="SupplierId" name="SupplierId">
            <option value="0">NOT Selected</option>
            <?php foreach (($suppliers?:[]) as $supplier): ?>
              <option value="<?= ($supplier->Id) ?>" <?= (($supplier->Id == $myForm->SupplierId) ? ' selected ' : '') ?>><?= ($supplier->CompanyName) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col d-flex justify-content-center py-3">
          <br><br>
          <input type="hidden" class="form-control" id="Page" name="Page" value="<?= ($PARAMS['Page']) ?>">
          <input type="hidden" class="form-control" id="Filter" name="Filter" value="<?= ($PARAMS['Filter']) ?>">
          <input type="hidden" class="form-control" id="Order" name="Order" value="<?= ($PARAMS['Order']) ?>">
          <button type="submit" class="btn btn-primary">Filter</button>
          <br>
        </div>
      </div>
    </form>
  </div>
</div>