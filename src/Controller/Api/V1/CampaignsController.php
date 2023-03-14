<?php

namespace App\Controller\Api\V1;

use App\Controller\AppController\Api\V1;

/**
 * Campaigns Controller
 *
 * @property \App\Model\Table\CampaignsTable $Campaigns
 *
 * @method \App\Model\Entity\Campaign[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CampaignsController extends ApiAppController
{
    /**
     * Search method
     *
     * @return \Cake\Http\Response|void
     */
    public function search(int $campaignId): void
    {
        $this->autoRender = false;

        $query = (string) $this->request->getQuery('term');

        if (!$query || !is_string($query)) {
            http_response_code(400);
        }

        $data = [];

        $this->loadModel('NonPlayableCharacters');
        /** @var NonPlayableCharacters $nonPlayableCharacters */
        $nonPlayableCharactersModel = $this->NonPlayableCharacters;
        $nonPlayableCharacters = $nonPlayableCharactersModel
            ->find('all', ['limit' => 5])
            ->where(['NonPlayableCharacters.name LIKE' => sprintf('%%%s%%', $query)]);

        foreach ($nonPlayableCharacters as $nonPlayableCharacter) {
            $nonPlayableCharacter['type'] = 'Non-Playable Character';
            $nonPlayableCharacter['model_type'] = 'non-playable-character';
            $data[] = $nonPlayableCharacter;
        }

        $this->loadModel('PlayerCharacters');
        /** @var PlayerCharacters $playerCharacters */
        $playerCharactersModel = $this->PlayerCharacters;
        $playerCharacters = $playerCharactersModel
            ->find('all', ['limit' => 5])
            ->where(['concat(PlayerCharacters.first_name, PlayerCharacters.last_name) LIKE' => sprintf('%%%s%%', $query)]);

        foreach ($playerCharacters as $playerCharacter) {
            $playerCharacter['type'] = 'Player Character';
            $playerCharacter['model_type'] = 'player-character';
            $playerCharacter['name'] = $playerCharacter['first_name'] . ' ' . $playerCharacter['last_name'];
            $data[] = $playerCharacter;
        }

        $this->loadModel('Monsters');
        /** @var Monsters $monsters */
        $monstersModel = $this->Monsters;
        $monsters = $monstersModel
            ->find('all', ['limit' => 5])
            ->where(['Monsters.name LIKE' => sprintf('%%%s%%', $query)]);

        foreach ($monsters as $monster) {
            $monster['type'] = 'monster';
            $monster['model_type'] = 'Monster';
            $data[] = $monster;
        }

        $this->loadModel('Tags');
        /** @var Tags $tags */
        $tagsModel = $this->Tags;
        $tags = $tagsModel
            ->find('all', ['limit' => 5])
            ->where(['Tags.title LIKE' => sprintf('%%%s%%', $query)]);

        foreach ($tags as $tag) {
            $tag['type'] = 'Tag';
            $tag['model_type'] = 'tag';
            $tag['name'] = $tag['title'];
            $data[] = $tag;
        }

        $this->output($data);
    }

    /**
     * Determines whether the user is authorised to be able to use this action
     *
     * @param type $user
     *
     * @return bool
     */
    public function isAuthorized($user): bool
    {
        $action = $this->request->getParam('action');

        // The add and tags actions are always allowed to logged in users
        if (
            in_array($action, [
            'add',
            'index',
        ])) {
            return true;
        }

        // All other actions require an item ID
        $id = $this->request->getParam('id');

        if (!$id) {
            return false;
        }

        // Check that the timelineSegment belongs to the current user
        $campaign = $this->Campaigns->findById($id)->firstOrFail();

        return $campaign->user_id === $user['id'];
    }
}
