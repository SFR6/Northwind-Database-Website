<div class="row content">
  <div class="row">
    <h2 class="text-center">Filter Orders</h2>
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
        <div class="col-sm-2">
          <div class="form-group">
            <label for="filterOrder">Order Id (contain)</label>
            <input type="text" class="form-control" id="filterOrder" name="filterOrder"
              value="<?= ($myForm->filterOrder) ?>">
          </div>
        </div>
        <div class="col-sm-1">
          &nbsp;
        </div>
        <div class="col-sm-3">
          <label for="CustomerId">Customer</label><br>
          <select class="form-control" id="CustomerId" name="CustomerId">
            <option value="0">NOT Selected</option>
            <?php foreach (($customers?:[]) as $customer): ?>
              <option value="<?= ($customer->Id) ?>" <?= (($customer->Id == $myForm->CustomerId) ? ' selected ' : '') ?>>
                <?= ($customer->CompanyName) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-sm-1">
          &nbsp;
        </div>
        <div class="col-sm-2">
          <label for="ShipperId">Shipper</label><br>
          <select class="form-control" id="ShipperId" name="ShipperId">
            <option value="0">NOT Selected</option>
            <?php foreach (($shippers?:[]) as $shipper): ?>
              <option value="<?= ($shipper->Id) ?>" <?= (($shipper->Id == $myForm->ShipperId) ? ' selected ' : '') ?>>
                <?= ($shipper->CompanyName) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-sm-1">
          &nbsp;
        </div>
        <div class="col-sm-2">
          <label for="EmployeeId">Employee</label><br>
          <select class="form-control" id="EmployeeId" name="EmployeeId">
            <option value="0">NOT Selected</option>
            <?php foreach (($employees?:[]) as $employee): ?>
              <option value="<?= ($employee->Id) ?>" <?= (($employee->Id == $myForm->EmployeeId) ? ' selected ' : '') ?>>
                <?= ($employee->FirstName) ?> <?= ($employee->LastName) ?></option>
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