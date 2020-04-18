<?php //if (isset($timelineSegment) && $timelineSegment->level <= MAX_TIMELINE_SEGMENT_DEPTH || !isset($timelineSegment)) { ?>
    <tr class="add-item-row">
        <td colspan="2" class="text-center">
            <?= $this->Html->link(
                __('New Timeline Segment'),
                [
                    'action'     => 'add',
                    '_name'      => 'TimelineSegments',
                    'campaignId' => $this->request->getParam('campaignId'),
                    'id'         => $timelineSegment->id ?? null,
                ]
            ) ?>
        </td>
    </tr>
<?php //} // endif; ?>