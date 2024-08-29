<?php

namespace App\Controller\Api\V1;

use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use Cake\Http\Exception\BadRequestException;
use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * Users Controller
 *
 * @property UsersTable $Users
 */
class UsersController extends ApiAppController
{
    public function add(): void
    {
        if (env('ENABLE_REGISTRATIONS', 0) !== 1) {
            $this->response = $this->apiResponseHeaderService->returnLockedResponse($this->response);
            return;
        }
        $this->Authorization->skipAuthorization();
        // $result = $this->Authentication->getResult();
        // dd($this->Authentication->getIdentity());

        $data = $this->request->getData();
        $existingUser = $this->Users->findByExternalUserId($data['external_user_id']);

        if ($existingUser !== null) {
            throw new BadRequestException();
        }

        /** @var User $user */
        $user = $this->Users->newEmptyEntity();
        $user->setUsername($data[User::FIELD_USERNAME])
            ->setExternalUserId($data[User::FIELD_EXTERNAL_USER_ID])
            ->setStatus(User::STATUS_PENDING);

        if ($this->Users->save($user)) {
            $this->set(compact('user'));
            $this->response = $this->apiResponseHeaderService->returnCreatedResponse($this->response);
        } else {
            $this->response = $this->apiResponseHeaderService->returnBadRequestResponse($this->response);
        }
    }

    public function beforeFilter(EventInterface $event): ?Response
    {
        // $response = parent::beforeFilter($event);
        // Configure the add action to not require authentication, otherwise it will attempt
        // to check that they exist before the user has even been added
        $this->Authentication->addUnauthenticatedActions(['add']);

        return null;
    }
}
