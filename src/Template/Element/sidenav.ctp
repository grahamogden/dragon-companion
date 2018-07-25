<nav id="actions-side-nav">
    <h6 class="heading menu-button"><?= __('Actions') ?></h6>
    <ul class="menu side-nav">
        <?php if (strtolower($this->request->action) === 'view') { ?>
            <li><?= $this->Html->link(__('Edit Timeline Segment'), ['action' => 'edit', $timelineSegment->getId()]); ?></li>
            <!-- <li><?= $this->Form->postLink(__('Delete Timeline Segment'), [ 'action' => 'delete', $timelineSegment->getId()], [ 'confirm' => __('Are you sure you want to delete # {0}?', $timelineSegment->getId())] ) ?></li> -->
        <?php } ?>
        <li><?= $this->Html->link(__('New Timeline Segment'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Timeline Segments'), ['action' => 'index']); ?></li>
    </ul>
</nav>