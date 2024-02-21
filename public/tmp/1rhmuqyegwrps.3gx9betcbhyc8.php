<div class="row content">
  <div class="row">
    <h2 class="text-center">Filter Products</h2>
  </div>
  <div class="row">
    <?php if ($myErrors): ?>
      
        <div class="panel panel-default bg-warning text-white">
          <div class="panel-body py-2">
            <p>
              <?php foreach (($myErrors?:[]) as $myError): ?>
                <?= ($myError)."
" ?>
              <?php endforeach; ?>
            </p>
          </div>
        </div>
      
    <?php endif; ?>
  </div>

  <div class="row">
    <form method="POST">
      <div class="row">
        <div class="col-sm-3">
          <div class="form-group">
            <label for="filterProduct">Product Bane (contain)</label>
            <input type="text" class="form-contrlo" id="filterTitle" name="filterProduct" value="<?= ($filterProduct) ?>">
          </div>
        </div>
        <div class="col-sm-1">
          &nbsp;
        </div>
        <div class="col-sm-3">
          <label for="CategoryId">Category</label><br>
          <select class="form-control" id="CategoryId" name="CategoryID">
            <option value="0">NOT Selected</option>
            <?php foreach (($categories?:[]) as $category): ?>
              <option value="<?= ($category['Id']) ?>"><?= ($category['CompanyName']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-sm-1">
          &nbsp;
        </div>
        <div class="col-sm-3">
          <label for="SupplierId">Supplier</label><br>
          <select class="form-control" id="genre_id" name="genre_id">
            <option value="0">NOT Selected</option>
            <?php foreach (($suppliers?:[]) as $supplier): ?>
              <option value="<?= ($supplier['Id']) ?>"><?= ($supplier['CompanyName']) ?></option>
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
