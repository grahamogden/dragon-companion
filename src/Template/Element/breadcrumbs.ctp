<?php
if (isset($breadcrumbs)) {
    $breadcrumbCounter = 0; // Must be set to 0 if there is no origin crumb (the above one)

    foreach($breadcrumbs as $breadcrumb) {
        if ($breadcrumbCounter === 0) {
            $crumbs[] = [
                'title' => 'Timeline Segments',
                'url'   => [
                    'campaignId' => $breadcrumb->campaign_id,
                    '_name'      => 'TimelineSegmentsIndex',
                ],
            ];
        }
        $breadcrumbCounter++;
        $crumbs[] = [
            'title' => $breadcrumb->getTitle(),
            'url'   => [
                'controller' => 'TimelineSegments',
                'action'     => 'view',
                'campaignId' => $breadcrumb->campaign_id,
                'id'         => $breadcrumb->getId(),
            ],
        ];
    }

    if ($this->request->getParam('action') !== 'edit') {
        $crumbs[$breadcrumbCounter]['url'] = '';
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