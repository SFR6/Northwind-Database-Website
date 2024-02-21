<div class="row content">
  <div class="row">
    <h2 class="text-center">Order of Products</h2>
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
      <div class="form-group">
        <label for="orderProduct">Order of Products</label><br>
        <select name="orderProduct">
          <option value="NoOrder">NO Order</option>
          <option value="ASC_Name">Product Name - ASCending</option>
          <option value="DESC_Name">Product Name - DESCending </option>
          <option value="ASC_Price">Price - ASCending</option>
          <option value="DESC_Price">Price - DESCending</option>
        </select>
      </div>
      <div class="row">
        <div class="col d-flex justify-content-center py-3">
          <br><br>
          <input type="hidden" class="form-control" id="Page" name="Page" value="<?= ($PARAMS['Page']) ?>">
          <input type="hidden" class="form-control" id="Filter" name="Filter" value="<?= ($PARAMS['Filter']) ?>">
          <input type="hidden" class="form-control" id="Order" name="Order" value="<?= ($PARAMS['Order']) ?>">
          <button type="submit" class="btn btn-primary">Order</button>
          <br>
        </div>
      </div>
    </form>
  </div>
</div>