<?php
if (isset($breadcrumbs)) {
    $crumbs[] = [
        'title' => 'Timeline Segments',
        'url'   => [
            'controller' => 'timeline-segments',
            'action'     => 'index',
        ]
    ];
    foreach($breadcrumbs as $breadcrumb) {
        $crumbs[] = [
            'title' => $breadcrumb->getTitle(),
            'url'   => [
                'controller' => 'timeline-segments',
                'action'     => 'view',
                $breadcrumb->getId(),
            ],
        ];
    }

    $this->Breadcrumbs->add($crumbs);

    echo $this->Breadcrumbs->render(
        ['class' => 'breadcrumbs-trail'],
        ['separator' => '']
    );

}