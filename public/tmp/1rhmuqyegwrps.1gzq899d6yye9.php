<div class="row content">
    <div class="row">
        <h2 class="text-center">NorthWind Products</h2>
    </div>
    <div class="row">
        <div class="panel panel-default bg-success text-white">
            <div class="panel-body py-2">
                <div class="row">
                    <div class="col-sm-1">
                        <a href="/filterProducts/<?= ($PARAMS['Page']) ?>/<?= ($PARAMS['Filter']) ?>/<?= ($PARAMS['Order']) ?>"
                            class="btn btn-primary">
                            Filter </a>
                    </div>
                    <div class="col-sm-1">
                        <a href="/orderProducts/<?= ($PARAMS['Page']) ?>/<?= ($PARAMS['Filter']) ?>/<?= ($PARAMS['Order']) ?>"
                            class="btn btn-primary">
                            Order </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <?php if (!$products): ?>
            
                None
            
            <?php else: ?>
                <?php foreach (($products?:[]) as $product): ?>
                    <a href="/productRead1/<?= ($product->Id) ?>" class="list-group-item list-group-item-action">
                        <?= ($product->ProductName) ?>  ($<?= ($product->UnitPrice) ?>)
                    </a>
                <?php endforeach; ?>
            
        <?php endif; ?>
    </div>

    <div class="row">
        <div class="panel panel-default bg-success text-white">
            <div class="panel-body py-2">
                <div class="row">
                    <div class="col-sm-1">
                        <?php if ($crt_page != $first_page): ?>
                            
                                <a href="/productReadAllPage/<?= ($first_page) ?>/<?= ($PARAMS['Filter']) ?>/<?= ($PARAMS['Order']) ?>"
                                    class="btn btn-primary">
                                    First
                                </a>
                            
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-1">
                        <?php if ($prev_page >= $first_page): ?>
                            
                                <a href="/productReadAllPage/<?= ($prev_page) ?>/<?= ($PARAMS['Filter']) ?>/<?= ($PARAMS['Order']) ?>"
                                    class="btn btn-primary">
                                    Prev
                                </a>
                            
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-7 d-flex justify-content-center">
                        <a href="/productReadAllPage/<?= ($crt_page) ?>/<?= ($PARAMS['Filter']) ?>/<?= ($PARAMS['Order']) ?>"
                            class="btn btn-primary">
                            <?= ($crt_page) ?> of <?= ($last_page)."
" ?>
                        </a>
                    </div>
                    <div class="col-sm-1">
                        <?php if ($next_page <= $last_page): ?>
                            
                                <a href="/productReadAllPage/<?= ($next_page) ?>/<?= ($PARAMS['Filter']) ?>/<?= ($PARAMS['Order']) ?>"
                                    class="btn btn-primary">
                                    Next
                                </a>
                            
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-1">
                        <?php if ($crt_page != $last_page): ?>
                            
                                <a href="/productReadAllPage/<?= ($last_page) ?>/<?= ($PARAMS['Filter']) ?>/<?= ($PARAMS['Order']) ?>"
                                    class="btn btn-primary">
                                    Last
                                </a>
                            
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>