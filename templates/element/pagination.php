<?php if ($this->Paginator->total() > 1) { ?>
    <div class="paginator">
        <div class="pagination btn-group" role="group" aria-label="Pagination">
            <?= $this->Paginator->first(__('First')) ?>
            <?= $this->Paginator->prev(__('Previous')) ?>
            <?= $this->Paginator->numbers(['modulus' => 2]) ?>
            <?= $this->Paginator->next(__('Next')) ?>
            <?= $this->Paginator->last(__('Last')) ?>
        </div>
    </div>
<?php } ?>
    <div><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></div>
