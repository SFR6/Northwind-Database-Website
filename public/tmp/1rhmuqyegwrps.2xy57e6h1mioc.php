<div class="row content px-2 py-2">
    <div class="row">
        <h2 class="text-center">Update Territory</h2>
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
        <form method="POST" enctype="multipart/form-data">
            <?php echo $this->render('territoryForm.html',NULL,get_defined_vars(),0); ?>
            <div class="text-center py-3">
                <input type="hidden" class="form-control" id="Id" name="Id" value="<?= ($PARAMS['id']) ?>">
                <button name="update" type="submit" class="btn btn-primary">Update</button>
                <button name="cancel" type="submit" class="btn btn-primary">Cancel</button>
            </div>
        </form>
    </div>
</div>