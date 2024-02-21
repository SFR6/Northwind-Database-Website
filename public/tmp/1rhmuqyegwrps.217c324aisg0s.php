<div class="row content px-2 py-2">
  <div class="row">
    <h2 class="text-center">Log In</h2>
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
        <label for="email">E-mail Address:</label>
        <input type="text" class="form-control" id="email" name="email" required value="<?= ($users['email']) ?>">
          <div class="invalid-feedback">Please fill out this field.</div>
      </div>
      <div class="form-group">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" id="passWord" name="password" value="<?= ($users['password']) ?>">
      </div>
      <div class="text-center py-3">
        <button type="submit" class="btn btn-primary">Log In</button>
      </div>
    </form>
  </div>
</div>