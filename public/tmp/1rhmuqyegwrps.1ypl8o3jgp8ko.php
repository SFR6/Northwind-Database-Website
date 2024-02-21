<div class="row content">
    <div class="row">
        <h2 class="text-center">Delete Shipper</h2>
    </div>
    <form method="POST" enctype="multipart/form-data">
        <?php echo $this->render('shipperRead1.html',NULL,get_defined_vars(),0); ?>
        <div class="text-center py-3">
            <button name="delete" type="submit" class="btn btn-primary">Delete</button>
            <button name="cancel" type="submit" class="btn btn-primary">Cancel</button>
        </div>
    </form>
</div>