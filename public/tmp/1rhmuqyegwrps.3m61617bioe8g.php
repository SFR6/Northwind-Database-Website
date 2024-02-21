<div class="row content">
    <div class="row">
        <h2 class="text-center">Employee <strong><?= ($employee->FirstName) ?> <?= ($employee->LastName) ?></strong> Territories</h2>
    </div>
    <div class="row">
        <?php if ($result[0]->TerritoryDescription): ?>
            
                <?php foreach (($result?:[]) as $res): ?>
                    <a href="/territoryReadOne/<?= ($res->TerritoryId) ?>" class="list-group-item list-group-item-action">
                        <?= ($res->TerritoryDescription)."
" ?>
                    </a>
                <?php endforeach; ?>
            
            <?php else: ?>
                No Territories
            
        <?php endif; ?>
    </div>
</div>