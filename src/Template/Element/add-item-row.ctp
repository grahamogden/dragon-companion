<?php //if (isset($timelineSegment) && $timelineSegment->level <= MAX_TIMELINE_SEGMENT_DEPTH || !isset($timelineSegment)) { ?>
    <tr class="add-item-row">
        <td colspan="2">
            <?= $this->Html->link(__('New Timeline Segment'), [
                'action' => 'add',
                'parent' => $timelineSegment->id ?? null,
            ]); ?>
        </td>
    </tr>
<?php //} // endif; ?>