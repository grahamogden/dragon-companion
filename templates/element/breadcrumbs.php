<?php

use App\Model\Entity\TimelineSegment;

if (isset($breadcrumbs)) {
    $breadcrumbCounter = 0; // Must be set to 0 if there is no origin crumb (the above one)

    /** @var TimelineSegment[] $breadcrumbs */
    foreach($breadcrumbs as $breadcrumb) {
        if ($breadcrumbCounter === 0) {
            $crumbs[] = [
                'title' => 'Timeline Segments',
                'url'   => [
                    'controller' => 'TimelineSegments',
                    'action'     => 'index',
                ],
            ];
        }
        $breadcrumbCounter++;
        $crumbs[] = [
            'title' => $breadcrumb->title,
            'url'   => [
                'controller' => 'TimelineSegments',
                'action'     => 'view',
                'id'         => $breadcrumb->id,
            ],
        ];
    }

    if ($this->request->getParam('action') !== 'edit') {
        $crumbs[$breadcrumbCounter]['url'] = '';
    }

    $this->Breadcrumbs->add($crumbs ?? []);
    $this->Breadcrumbs->setTemplates([
        'itemWithoutLink' => '<li{{attrs}}><span{{innerAttrs}}>{{title}}</span></li>{{separator}}',
        'separator'       => '',
    ]);

    echo $this->Breadcrumbs->render(
        ['class' => 'breadcrumbs-trail'],
        ['separator' => '']
    );

}
