<h1><?=ucwords($this->request->action)?> Timeline Segment</h1>
<?php

    $this->Breadcrumbs->add($breadcrumbs);

    echo $this->Breadcrumbs->render(
        ['class' => 'breadcrumbs-trail'],
        ['separator' => '']
    );
        
    echo $this->Form->create($timelineSegment);
    // Hard code the user for now.
    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
    echo $this->Form->control('title');
    echo $this->Form->control('body', ['rows' => '7']);
    echo $this->Form->control('tag_string', ['type' => 'text']);
    echo $this->Form->button(__('Save'));
    echo $this->Form->end();
?>