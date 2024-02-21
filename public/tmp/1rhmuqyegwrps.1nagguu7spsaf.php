<div class="row content">
  <div class="row">
    <h2 class="text-center">Order Orders</h2>
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
        <label for="orderOrder">Order of Orders</label><br>
        <select name="orderOrder">
          <option value="NoOrder">NO Order</option>
          <option value="ASC_OrderId">Order Id - ASCending</option>
          <option value="DESC_OrderId">Order Id - DESCending </option>
          <option value="ASC_OrderDate">Order Date - ASCending</option>
          <option value="DESC_OrderDate">Order Date - DESCending </option>
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