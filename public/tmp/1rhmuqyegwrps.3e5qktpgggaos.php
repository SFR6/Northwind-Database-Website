<div class="row content px-2 py-2">
  <div class="row">
    <h2 class="text-center">My Web Page</h2>
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
    <h2><?= ($myForm->TitleOfCourtesy) ?> <?= ($myForm->FirstName) ?> <?= ($myForm->LastName) ?></h2>
    <p><?= ($myForm->Title) ?></p>

    <?php if ($myForm->PhotoPath != ''): ?>
      
        <div class="col-sm-6">
          <img src="/assets/<?= ($myForm->PhotoPath) ?>" class="rounded w-100" width="500" height="333"
            alt="<?= ($myForm->FirstName) ?> <?= ($myForm->LastName) ?>">
        </div>
      
      <?php else: ?>
        <p>No Photo Image</p>
      
    <?php endif; ?>
  </div>

  <div class="row">
    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="picture">Picture:</label>
        <input type="file" class="form-control" id="picture" name="picture" value="<?= ($myForm->PhotoPath) ?>">
      </div>
      <div class="text-center py-3">
        <input type="hidden" class="form-control" id="Id" name="Id" value="<?= ($myForm->Id) ?>">
        <input type="hidden" class="form-control" id="LastName" name="LastName" value="<?= ($myForm->LastName) ?>">
        <button type="submit" class="btn btn-primary">O.K.</button>
      </div>
    </form>
  </div>
</div>