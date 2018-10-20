<?php
if (isset($breadcrumbs)) {
    $crumbs[] = [
        'title' => 'Timeline Segments',
        'url'   => [
            'controller' => 'timeline-segments',
            'action'     => 'index',
        ],
    ];
    $breadcrumbCounter = 1; // Must be set to 0 if there is no origin crumb (the above one)

    foreach($breadcrumbs as $breadcrumb) {
        $breadcrumbCounter++;
        $crumbs[] = [
            'title' => $breadcrumb->getTitle(),
            'url'   => [
                'controller' => 'timeline-segments',
                'action'     => 'view',
                $breadcrumb->getId(),
            ],
        ];
    }

    if ($this->request->getParam('action') !== 'edit') {
        $crumbs[$breadcrumbCounter - 1]['url'] = '';
    }

    $this->Breadcrumbs->add($crumbs);
    $this->Breadcrumbs->setTemplates([
        'itemWithoutLink' => '<li{{attrs}}><span{{innerAttrs}}>{{title}}</span></li>{{separator}}',
        'separator'       => '',
    ]);

    echo $this->Breadcrumbs->render(
        ['class' => 'breadcrumbs-trail'],
        ['separator' => '']
    );

}