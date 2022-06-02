<?php

namespace App\Controller;

use App\Application;
use App\Controller\AppController;
use App\Model\Entity\Participant;
use App\Model\Table\MonstersTable;
use App\Model\Table\ParticipantsTable;
use App\Model\Table\PlayerCharactersTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;
use Cake\ORM\Query;

/**
 * Participants Controller
 *
 * @property ParticipantsTable $Participants
 *
 * @method Participant[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class ParticipantsController extends AppController
{
    /** @var PlayerCharactersTable */
    private $playerCharactersTable;

    /** @var MonstersTable */
    private $monstersTable;

    /**
     * Index method
     *
     * @return void
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
     * @return void
     * @throws RecordNotFoundException When record not found.
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
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $participant = $this->Participants->newEmptyEntity();
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
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
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
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
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
     * @param $user
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
        $this->playerCharactersTable = $this->fetchTable('PlayerCharacters');

        // $user       = $this->getUserOrRedirect();
        $term       = $this->request->getQuery('term');
        $campaignId = $this->getCampaignIdFromSession();
        $excludes   = $this->getExcludesFromRequest();

        $conditions = [
            // TODO: May need to come back to this and add back in a check for the Campaigns.user_id
            // 'Campaigns.user_id ='                                                  => $user['id'],
            'concat(PlayerCharacters.first_name, PlayerCharacters.last_name) LIKE' => sprintf('%%%s%%', $term),
            'PlayerCharacters.campaign_id ='                                       => $campaignId,
        ];

        if ($excludes) {
            $conditions['PlayerCharacters.id NOT IN'] = $excludes;
        }

        if ($this->request->is('ajax') && strlen($term) >= 3) {
            $results = $this->playerCharactersTable->find(
                'all',
                [
                    'conditions' => $conditions,
                ]
            )
                /*->matching(
                    'Campaigns',
                    static function (Query $q) use ($user) {
                        return $q->where(['Campaigns.user_id =' => $user['id']]);
                    }
                )*/;

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

        header('Content-Type: application/json');
        echo json_encode($return);
        exit;
    }

    /**
     * Retrieves the campaign ID from the request object
     *
     * @return int
     */
    private function getCampaignIdFromSession(): int
    {
        $campaign = $this->request->getSession()->read(Application::SESSION_KEY_CAMPAIGN);

        if (!$campaign || !$campaign['id']) {

            header('Content-Type: application/json');
            echo json_encode(
                [
                    'label' => 'Please provide a campaign ID ' . debug($campaign),
                ]
            );
            exit;
        }

        return (int) $campaign['id'];
    }
}
