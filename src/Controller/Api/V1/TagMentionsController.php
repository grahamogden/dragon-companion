<?php
namespace App\Controller\Api\V1;

use App\Application;
use App\Model\Entity\Campaign;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\ORM\Query;

class TagMentionsController extends ApiAppController
{

    /**
     * Looks up tags based on a wildcard search term,
     * starting with at least three character
     *
     * @return void
     */
    public function get(): void
    {
        $this->autoRender = false;
        $term             = $this->request->getQuery('search');
        $conditions       = json_decode($this->request->getQuery('conditions'), true);
// debug($term);
        if (/*$this->request->is('ajax') &&*/ strlen($term) >= 3) {
            /** @var Campaign $campaign */
            $campaign = $this->request->getSession()->read(Application::SESSION_KEY_CAMPAIGN);

            if (!isset($campaign) || !$campaign['id']) {
                header('HTTP/1.0 400 Bad request');
                $this->output(['label' => 'Please submit a campaign ID']);
            }

            $types = [
                'CharacterRaces' => [['name'], false],
                'Monsters' => [['name'], false],
                'NonPlayableCharacters' => [['name'], false],
                'PlayerCharacters' => [['first_name', 'last_name'], true],
                'Tags' => [['title'], false],
                'TimelineSegments' => [['title'], true],
            ];

            foreach ($types as $type => $options) {
                $table = $this->fetchTable($type);

                $whereConditions = [];
                foreach ($options[0] as $fieldName) {
                    $whereConditions[$fieldName . ' LIKE '] = $term . '%';
                }
                if ($options[1]) {
                    $whereConditions['campaign_id ='] = $campaign->id;
                }

                $results = $table->find()
                    // ->notMatching('Campaigns',
                    //     function (Query $q) use ($campaign) {
                    //         return $q->where(['Campaigns.id =' => $campaign['id']]);
                    //     })
                    ->where($whereConditions)
                    // ->limit(20)
                ;
// debug($results);
//exit;
                if ($results->count()) {
                    foreach ($results as $result) {
                        // debug($result);
                        // debug($options[0][0]);
                        // debug($result->{$options[0][0]});
                        $return[] = [
                            'label' => $result->{$options[0][0]},
                            'value' => $result->id,
                            'type'  => $result->id,
                        ];
                    }
                }
            }
        }

        $this->output($return ?? [
                'label' => 'No results found',
                'value' => '',
                'type'  => '',
            ]);
    }

    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        exit('index');
        $combatEncounters = $this->usersTable->find('all');
        $this->set([
            'Users' => $combatEncounters,
            '_serialize' => [
                'Users'
            ]
        ]);
    }

    public function view()
    {
        exit('view');
        $combatEncounter = $this->usersTable->findById($this->request->getParam('id'));
        $this->set([
            'Users' => $combatEncounter,
            '_serialize' => [
                'Users'
            ]
        ]);
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
        // The add and index actions are always allowed to logged in users
        if (in_array($action, [
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

        // Check that the combatEncounters belongs to the current user
        $combatEncounters = $this->usersTable->findById($id)->firstOrFail();

        return $combatEncounters->user_id === $user['id'];
    }
}
