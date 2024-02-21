<div class="row content">
  <div class="row">
    <h2 class="text-center">NorthWind Product's Categories</h2>
  </div>
  <div class="row">
    <?php foreach (($categories?:[]) as $category): ?>

      <div class="card" style="width: 18rem;">
        <img class="card-img-top" src="/assets/<?= ($category->CategoryName . '.png') ?>" width="400" height="300"
          alt="<?= ($category->CategoryName) ?>">
        <div class="card-body">
          <a href="/productReadAll1Category/<?= ($category->Id) ?>" class="btn btn-primary"><?= ($category['CategoryName']) ?></a>
          <p class="card-text"><?= ($category->Description) ?> </p>
        </div>
      </div>
      &nbsp;
    <?php endforeach; ?>
  </div>
</div>