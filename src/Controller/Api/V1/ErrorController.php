<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

// use Cake\Event\EventInterface;
use Authentication\Controller\Component\AuthenticationComponent;
use Authorization\Controller\Component\AuthorizationComponent;
use Cake\Controller\ErrorController as CakeErrorController;
use Cake\View\JsonView;

/**
 * @property AuthenticationComponent $Authentication
 * @property AuthorizationComponent $Authorization
 */
class ErrorController extends CakeErrorController
{
    // public function initialize(): void
    // {
    //     parent::initialize();
    //     $this->addViewClasses([JsonView::class]);
    // }

    // public function beforeRender(EventInterface $event): void
    // {
    //     // echo '<pre>';
    //     // dd($event);
    //     $this->viewBuilder()->setTemplatePath('Api/V1/Error');
    //     $this->viewBuilder()->setTemplate('error400');
    //     // $this->set('file', null);
    //     // $this->set('line', null);
    //     // $event->setData();
    // }

    public function viewClasses(): array
    {
        return [JsonView::class,];
    }
}
