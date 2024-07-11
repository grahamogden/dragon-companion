<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Model\Table\TimelinesTable;
use App\Model\Entity\Timeline;
use App\Model\Table\UsersTable;
use App\Error\Api\BadRequestError;
use App\Error\Api\NotFoundError;
use App\Error\Api\UnauthorizedError;

/**
 * Timelines Controller
 *
 * @property TimelinesTable $Timelines
 */
class TimelinesController extends ApiAppController
{
    public function view(int $campaignId, int $id): void
    {
        $timeline = $this->Timelines->findByIdAndCampaignId(campaignId: $campaignId, id: $id);

        if ($timeline === null) {
            throw new NotFoundError(message: "Timeline $id not found");
        }

        $this->isAuthorized(entity: $timeline);

        $this->output(compact('timeline'));
    }

    public function index(int $campaignId): void
    {
        $user = $this->user;

        if ($user === null) {
            throw new UnauthorizedError();
        }

        $timelines = $this->Timelines->findByCampaignId(campaignId: $campaignId);

        if (count($timelines) === 0) {
            // If there are no species, then we can't authorize for anything
            $this->Authorization->skipAuthorization();
        }

        $outputTimelines = [];
        foreach ($timelines as $specum) {
            if ($this->isAuthorizedCheck(entity: $specum)) {
                $outputTimelines[] = $specum;
            }
        }

        $this->output(['timelines' => $outputTimelines]);
    }

    public function add(int $campaignId): void
    {
        $data = $this->request->getData();
        $data[Timeline::FIELD_CAMPAIGN_ID] = $campaignId;
        $data[Timeline::FIELD_USER_ID] = $this->user['id'];

        /** @var Timeline $timeline */
        $timeline = $this->Timelines->newEmptyEntity();

        $timeline->setAccess(field: UsersTable::TABLE_NAME, set: true);
        $timeline = $this->Timelines->patchEntity(
            entity: $timeline,
            data: $data
        );

        $this->isAuthorized(entity: $timeline);

        if ($this->Timelines->save(entity: $timeline)) {
            $this->output(compact('timeline'));
            $this->response = $this->apiResponseHeaderService->returnCreatedResponse(response: $this->response);
        } elseif ($timeline->getErrors()) {
            throw new BadRequestError(message: "Error adding Timeline", errors: $timeline->getErrors());
        }
    }

    public function edit(int $campaignId, int $id): void
    {
        $timeline = $this->Timelines->get(primaryKey: $id, contain: 'Users');

        if ($timeline === null) {
            throw new NotFoundError(message: "Timeline $id not found");
        }

        $data = $this->request->getData();

        $this->isAuthorized(entity: $timeline);

        $timeline = $this->Timelines->patchEntity(entity: $timeline, data: $data);

        if ($this->Timelines->save(entity: $timeline)) {
            $this->output(compact('timeline'));
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse(response: $this->response);
        } else {
            throw new BadRequestError(message: "Error saving Timeline: $id", errors: $timeline->getErrors());
        }
    }

    public function delete(int $campaignId, int $id): void
    {
        $timeline = $this->Timelines->get(primaryKey: $id, contain: 'Users');

        if ($timeline === null || $timeline->campaign_id !== $campaignId) {
            throw new NotFoundError(message: "Timeline $id not found");
        }

        $this->isAuthorized(entity: $timeline);

        if ($this->Timelines->delete(entity: $timeline)) {
            $this->output([]);
            $this->response = $this->apiResponseHeaderService->returnNoContentResponse(response: $this->response);
        } else {
            throw new BadRequestError(message: "Error deleting Timeline: $id", errors: $timeline->getErrors());
        }
    }
}
