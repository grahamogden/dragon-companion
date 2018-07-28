        <tr class="add-item-row">
            <td colspan="2">
                <?php
                    if (isset($timelineSegment) && $timelineSegment->level < MAX_TIMELINE_SEGMENT_DEPTH) {
                        echo $this->Html->link(__('New Timeline Segment'), [
                            'action' => 'add',
                            'parent' => $timelineSegment->id,
                        ]);
                    }
                ?>
            </td>
        </tr>