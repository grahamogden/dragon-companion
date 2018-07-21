<h1>Add Timeline Segment</h1>
<?php
    //ucwords($this->request->action)
    // $this->Breadcrumbs->add($breadcrumbs);

    // echo $this->Breadcrumbs->render(
    //     ['class' => 'breadcrumbs-trail'],
    //     ['separator' => '']
    // );

    echo $this->element('breadcrumbs');
        
    echo $this->Form->create($timelineSegment);
    echo $this->Form->hidden('order_number', ['value' => $orderNumber]);
    echo $this->Form->control('title');
    echo $this->Form->control('body', ['rows' => '7']);
    echo $this->Form->control('tag_string', ['type' => 'text']);
    // echo $this->Form->button(__('Save'));
    echo $this->Form->submit(__('Save'));
    echo $this->Form->end();
?>