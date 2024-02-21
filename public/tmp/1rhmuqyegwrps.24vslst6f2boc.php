<div class="row content">
    <div class="row">
        <h2 class="text-center">NorthWind Orders</h2>
    </div>
    <div class="row">
        <div class="panel panel-default bg-success text-white">
            <div class="panel-body py-2">
                <div class="row">
                    <div class="col-sm-1">
                        <a href="/filterOrders/<?= ($PARAMS['Page']) ?>/<?= ($PARAMS['Filter']) ?>/<?= ($PARAMS['Order']) ?>"
                            class="btn btn-primary">
                            Filter </a>
                    </div>
                    <div class="col-sm-1">
                        <a href="/orderOrders/<?= ($PARAMS['Page']) ?>/<?= ($PARAMS['Filter']) ?>/<?= ($PARAMS['Order']) ?>"
                            class="btn btn-primary">
                            Order </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <?php if (!$orders): ?>
            
                No Orders
            
            <?php else: ?>
                <?php foreach (($orders?:[]) as $order): ?>
                    <a href="/orderRead1/<?= ($order->Id) ?>" class="list-group-item list-group-item-action">
                        <?= ($order->Id) ?>  (<?= ($order->OrderDate) ?>)
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
                            
                                <a href="/orderReadAllPage/<?= ($first_page) ?>/<?= ($PARAMS['Filter']) ?>/<?= ($PARAMS['Order']) ?>"
                                    class="btn btn-primary">
                                    First
                                </a>
                            
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-1">
                        <?php if ($prev_page >= $first_page): ?>
                            
                                <a href="/orderReadAllPage/<?= ($prev_page) ?>/<?= ($PARAMS['Filter']) ?>/<?= ($PARAMS['Order']) ?>"
                                    class="btn btn-primary">
                                    Prev
                                </a>
                            
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-7 d-flex justify-content-center">
                        <a href="/orderReadAllPage/<?= ($crt_page) ?>/<?= ($PARAMS['Filter']) ?>/<?= ($PARAMS['Order']) ?>"
                            class="btn btn-primary">
                            <?= ($crt_page) ?> of <?= ($last_page)."
" ?>
                        </a>
                    </div>
                    <div class="col-sm-1">
                        <?php if ($next_page <= $last_page): ?>
                            
                                <a href="/orderReadAllPage/<?= ($next_page) ?>/<?= ($PARAMS['Filter']) ?>/<?= ($PARAMS['Order']) ?>"
                                    class="btn btn-primary">
                                    Next
                                </a>
                            
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-1">
                        <?php if ($crt_page != $last_page): ?>
                            
                                <a href="/orderReadAllPage/<?= ($last_page) ?>/<?= ($PARAMS['Filter']) ?>/<?= ($PARAMS['Order']) ?>"
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