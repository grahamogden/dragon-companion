<?php
if (isset($breadcrumbs)) {
    $crumbs[] = [
        'title' => 'Timeline Segments',
        'url'   => [
            'controller' => 'timeline-segments',
            'action'     => 'index',
        ]
    ];

    $breadcrumbCounter = 0;
    foreach($breadcrumbs as $breadcrumb) {
        $crumbs[] = [
            'title' => $breadcrumb->getTitle(),
            'url'   => [
                'controller' => 'timeline-segments',
                'action'     => 'view',
                $breadcrumb->getId(),
            ],
        ];
        $breadcrumbCounter++;
    }

    $crumbs[$breadcrumbCounter]['url'] = '';

    $this->Breadcrumbs->add($crumbs);
    $this->Breadcrumbs->templates([
        'itemWithoutLink' => '<li{{attrs}}><span{{innerAttrs}}>{{title}}</span></li>{{separator}}',
        'separator'       => '',
    ]);

    echo $this->Breadcrumbs->render(
        ['class' => 'breadcrumbs-trail'],
        ['separator' => '']
    );

}