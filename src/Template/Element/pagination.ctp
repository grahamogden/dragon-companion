<?php if ($this->Paginator->total() > 1) { ?>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first(__('First')) ?>
            <?= $this->Paginator->prev(__('Previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Next')) ?>
            <?= $this->Paginator->last(__('Last')) ?>
        </ul>
    </div>
<?php } ?>
    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>