<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Query;

/**
 * Participants Controller
 *
 * @property \App\Model\Table\ParticipantsTable $Participants
 *
 * @method \App\Model\Entity\Participant[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ParticipantsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['CombatEncounters'],
        ];
        $participants   = $this->paginate($this->Participants);

        $this->set(compact('participants'));
    }

    /**
     * View method
     *
     * @param string|null $id Participant id.
     *
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $participant = $this->Participants->get(
            $id,
            [
                'contain' => ['CombatEncounters', 'Conditions'],
            ]
        );

        $this->set('participant', $participant);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $participant = $this->Participants->newEntity();
        if ($this->request->is('post')) {
            $participant = $this->Participants->patchEntity($participant, $this->request->getData());
            if ($this->Participants->save($participant)) {
                $this->Flash->success(__('The participant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The participant could not be saved. Please, try again.'));
        }
        $combatEncounters = $this->Participants->CombatEncounters->find('list', ['limit' => 200]);
        $conditions       = $this->Participants->Conditions->find('list', ['limit' => 200]);
        $this->set(compact('participant', 'combatEncounters', 'conditions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Participant id.
     *
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $participant = $this->Participants->get(
            $id,
            [
                'contain' => ['Conditions'],
            ]
        );
        if ($this->request->is(['patch', 'post', 'put'])) {
            $participant = $this->Participants->patchEntity($participant, $this->request->getData());
            if ($this->Participants->save($participant)) {
                $this->Flash->success(__('The participant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The participant could not be saved. Please, try again.'));
        }
        $combatEncounters = $this->Participants->CombatEncounters->find('list', ['limit' => 200]);
        $conditions       = $this->Participants->Conditions->find('list', ['limit' => 200]);
        $this->set(compact('participant', 'combatEncounters', 'conditions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Participant id.
     *
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $participant = $this->Participants->get($id);
        if ($this->Participants->delete($participant)) {
            $this->Flash->success(__('The participant has been deleted.'));
        } else {
            $this->Flash->error(__('The participant could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
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
        if (in_array(
            $action,
            [
                'add',
                'index',
                'getAvailablePlayerCharacters',
                'getAvailableMonsters',
            ]
        )) {
            return true;
        }

        // All other actions require an item ID
        $id = $this->request->getParam('id');

        if (!$id) {
            return false;
        }

        // Check that the combatEncounters belongs to the current user
        $participants = $this->Participants->findById($id)->firstOrFail();

        return $participants->user_id === $user['id'];
    }

    /**
     * Echos a JSON response for the player characters that are available to this user
     * for a combat encounter
     *
     * @return void
     */
    public function getAvailablePlayerCharacters(): void
    {
        $this->autoRender = false;
        // $this->loadModel('Campaigns');
        $this->loadModel('PlayerCharacters');

        $user       = $this->getUserOrRedirect();
        $term       = $this->request->getQuery('term');
        $campaignId = $this->getCampaignIdFromRequest();
        $excludes   = $this->getExcludesFromRequest();

        $conditions = [
            'Campaigns.user_id ='                                                  => $user['id'],
            'concat(PlayerCharacters.first_name, PlayerCharacters.last_name) LIKE' => sprintf('%%%s%%', $term),
            'PlayerCharacters.campaign_id ='                                       => $campaignId,
        ];

        if ($excludes) {
            $conditions['PlayerCharacters.id NOT IN'] = $excludes;
        }

        if ($this->request->is('ajax') && strlen($term) >= 3) {
            $results = $this->PlayerCharacters->find(
                'all',
                [
                    'conditions' => $conditions,
                ]
            )
                ->matching(
                    'Campaigns',
                    static function (Query $q) use ($user) {
                        return $q->where(['Campaigns.user_id =' => $user['id']]);
                    }
                );

            foreach ($results as $result) {
                $playerCharacterName = $result->first_name . ($result->last_name ? ' ' . $result->last_name : '');
                $return[]            = [
                    'label' => $playerCharacterName,
                    'value' => $result->id,
                    'data'  => [
                        'id'                 => $result->id,
                        'name'               => $playerCharacterName,
                        'armour_class'       => $result->armour_class,
                        'max_hit_points'     => $result->max_hit_points,
                        'dexterity_modifier' => $result->dexterity_modifier,
                    ],
                ];
                unset($playerCharacterName);
            }
        }

        if (empty($return)) {
            $return[] = [
                'label' => 'No results found',
                'value' => '',
            ];
        }

        echo json_encode($return);
        exit;
    }

    /**
     * Retrieves the campaign ID from the request object
     *
     * @return int
     */
    private function getCampaignIdFromRequest(): int
    {
        $conditionals = json_decode($this->request->getQuery('conditionals'), true);

        if (json_last_error() !== JSON_ERROR_NONE
            || !isset($conditionals['campaign_id'])
        ) {
            echo json_encode(
                [
                    'label' => 'Please provide a campaign ID',
                ]
            );
            exit;
        }

        $campaignId = $conditionals['campaign_id'];

        if (!is_numeric($campaignId)
            || (int) $campaignId <= 0
        ) {
            echo json_encode(
                [
                    'label' => 'Please provide a campaign ID',
                ]
            );
            exit;
        }

        return (int) $campaignId;
    }

    /**
     * Retrieves the excluding IDs from the request object, removing blanks and
     * non-numeric IDs in the process
     *
     * @return array
     */
    private function getExcludesFromRequest(): array
    {
        $excludes = $this->request->getQuery('excludes')
            ? explode(',', $this->request->getQuery('excludes'))
            : [];

        array_walk(
            $excludes,
            static function (&$value) {
                $value = trim($value);
                $value = is_numeric($value) ? (int) $value : null;
            }
        );

        return array_unique(array_filter($excludes));
    }

    /**
     * Echos a JSON response for the monsters that are available to this user
     * for a combat encounter
     *
     * @return void
     */
    public function getAvailableMonsters(): void
    {
        $this->autoRender = false;
        // $this->loadModel('Campaigns');
        $this->loadModel('Monsters');

        $term         = $this->request->getQuery('term');
        $conditionals = $this->request->getQuery('conditionals');

        echo $this->formatJsonResponse(
            $this->Monsters,
            $term,
            [
                'Monsters.name LIKE' => sprintf('%%%s%%', $term),
            ],
            'name',
            'id',
            [
                'name',
                'id',
                'armour_class',
                'max_hit_points',
                'dexterity_modifier',
                'monster_instance_type_id',
            ]
        );
        exit;
    }
}
