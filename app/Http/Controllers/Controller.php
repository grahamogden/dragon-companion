<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

abstract class Controller
{
    use AuthorizesRequests;

    protected function getUser(Request $request): User
    {
        return $request->user();
    }

    protected function getValidatedRequestData(
        Request $request,
        bool $appendUserId = false,
    ): array {
        $validated = $request->validated();

        if ($appendUserId) {
            $validated = array_merge(
                $validated,
                ['user_id' => $this->getUser(request: $request)->id],
            );
        }

        return $validated;
    }

    private function generateLinkForEntityInCampaign(
        Campaign $campaign,
        Model $model,
        string $modelName,
        string $modelRouteName,
        string $actionName,
    ): string {
        return route(
            name: "creator.campaigns.$modelRouteName.$actionName",
            parameters: [
                'campaign' => $campaign->id,
                $modelName => $model->id,
            ]
        );
    }

    protected function generateEditLinkForEntityInCampaign(
        Campaign $campaign,
        Model $model,
        string $modelName,
        string $modelRouteName,
    ): string {
        return $this->generateLinkForEntityInCampaign(
            campaign: $campaign,
            model: $model,
            modelName: $modelName,
            modelRouteName: $modelRouteName,
            actionName: 'edit',
        );
    }

    protected function generateDestroyLinkForEntityInCampaign(
        Campaign $campaign,
        Model $model,
        string $modelName,
        string $modelRouteName,
    ): string {
        return $this->generateLinkForEntityInCampaign(
            campaign: $campaign,
            model: $model,
            modelName: $modelName,
            modelRouteName: $modelRouteName,
            actionName: 'destroy',
        );
    }

    protected function generateShowLinkForEntityInCampaign(
        Campaign $campaign,
        Model $model,
        string $modelName,
        string $modelRouteName,
    ): string {
        return $this->generateLinkForEntityInCampaign(
            campaign: $campaign,
            model: $model,
            modelName: $modelName,
            modelRouteName: $modelRouteName,
            actionName: 'show',
        );
    }
}
