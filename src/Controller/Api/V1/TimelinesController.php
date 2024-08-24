<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Model\Table\TimelinesTable;
use App\Model\Entity\Timeline;
use App\Model\Table\UsersTable;
use App\Error\Api\BadRequestError;
use App\Error\Api\NotFoundError;
use App\Services\Api\Response\ApiResponseHeaderService;
use Cake\Event\EventManagerInterface;
use Cake\Http\ServerRequest;
use App\InputFilter\Api\V1\Timelines\IndexQueryParameterInputFilter;
use App\InputFilter\Api\V1\Timelines\ViewQueryParameterInputFilter;

/**
 * Timelines Controller
 *
 * @property TimelinesTable $Timelines
 */
class TimelinesController extends ApiAppController
{
    protected array $paginate = [
        'limit' => 1,
        'order' => [],
    ];

    public function __construct(
        private readonly IndexQueryParameterInputFilter $indexQueryParameterInputFilter,
        private readonly ViewQueryParameterInputFilter $viewQueryParameterInputFilter,
        ServerRequest $request = null,
        ApiResponseHeaderService $apiResponseHeaderService,
        ?string $name = null,
        ?EventManagerInterface $eventManager = null,
    ) {
        parent::__construct(
            request: $request,
            apiResponseHeaderService: $apiResponseHeaderService,
            name: $name,
            eventManager: $eventManager,
        );
    }

    public function view(int $campaignId, int $id): void
    {
        $params = $this->viewQueryParameterInputFilter->validateAndFilter($this->request->getQueryParams());

        $timeline = $this->Timelines->findOneByIdAndCampaignId(
            campaignId: $campaignId,
            id: $id,
            includeChildren: $params[ViewQueryParameterInputFilter::PARAM_INCLUDE_CHILDREN] ?? false
        );

        if ($timeline === null) {
            throw new NotFoundError(message: "Timeline $id not found");
        }

        $this->isAuthorized(entity: $timeline);

        $this->output(compact('timeline'));
    }

    public function index(int $campaignId): void
    {
        $params = $this->indexQueryParameterInputFilter->validateAndFilter($this->request->getQueryParams());
        $level = $params[IndexQueryParameterInputFilter::PARAM_LEVEL] ?? null;
        $includeChildren = $params[IndexQueryParameterInputFilter::PARAM_INCLUDE_CHILDREN] ?? false;

        if (null === $level) {
            $timelines = $this->Timelines->findByCampaignIdWithPermissionsCheck(
                campaignId: $campaignId,
                includeChildren: $includeChildren,
                identity: $this->user,
            )->all()->toList();
        } else {
            $timelines = $this->Timelines->findByCampaignIdForLevelWithPermissionsCheck(
                campaignId: $campaignId,
                level: $level,
                includeChildren: $includeChildren,
                identity: $this->user
            )->all()->toList();
        }

        // Skip the authorization because it happens when we get the entities from the DB
        $this->Authorization->skipAuthorization();

        $this->output(['timelines' => $timelines]);
    }

    public function add(int $campaignId): void
    {
        $data = $this->request->getData();
        $data[Timeline::FIELD_CAMPAIGN_ID] = $campaignId;
        $data[Timeline::FIELD_USER_ID] = $this->user['id'];

        /** @var Timeline $timeline */
        $timeline = $this->Timelines->newEmptyEntity();

        $timeline->setAccess(field: Timeline::FIELD_USER_ID, set: true);
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
