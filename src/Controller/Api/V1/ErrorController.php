<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use Authentication\Controller\Component\AuthenticationComponent;
use Authorization\Controller\Component\AuthorizationComponent;
use Cake\Controller\ErrorController as CakeErrorController;
use Cake\Event\EventInterface;
use Cake\View\JsonView;

/**
 * @property AuthenticationComponent $Authentication
 * @property AuthorizationComponent $Authorization
 */
class ErrorController extends CakeErrorController
{
    public function initialize(): void
    {
        // parent::initialize();
        $this->addViewClasses([JsonView::class]);
    }

    public function viewClasses(): array
    {
        return [JsonView::class,];
    }

    public function beforeRender(EventInterface $event): void
    {
        parent::beforeRender($event);

        // Use the below examples to set data and then enable the 'serialize'
        // option to output errors in a specific format. This is because of JsonView

        // $event->setData('message', );
        // $this->set('isDebug', true);
        // $this->viewBuilder()->setOption('serialize', true);

        $this->viewBuilder()->setTemplatePath('Api/V1/Error');
        $this->viewBuilder()->setTemplate('error400');

        $this->viewBuilder()->setOption('serialize', false);
    }
}
