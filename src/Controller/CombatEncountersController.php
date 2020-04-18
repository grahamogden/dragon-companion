<?php

namespace App\Controller;

use App\Model\Entity\CombatAction;
use App\Model\Entity\CombatEncounter;
use App\Model\Entity\Participant;
use App\Model\Table\CombatActionsTable;
use App\Model\Table\CombatEncountersTable;
use App\Model\Table\ParticipantsTable;
use Cake\Controller\ComponentRegistry;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\EventManager;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use http\Exception\InvalidArgumentException;

/**
 * CombatEncounters Controller
 *
 * @property CombatEncountersTable $CombatEncounters
 *
 * @method CombatEncounter[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class CombatEncountersController extends AppController
{
    private const PARTICIPANT_TYPE_PLAYER_CHARACTER = 'PlayerCharacter';
    private const PARTICIPANT_TYPE_MONSTER          = 'Monster';

//    /** @var CombatActionsTable */
//    private $CombatActions;
//
//    /** @var MonstersTable */
//    private $Monsters;
//
//    /** @var ParticipantsTable */
//    private $Participants;

    /**
     * CombatEncountersController constructor.
     *
     * @param ServerRequest|null     $request
     * @param Response|null          $response
     * @param string|null            $name
     * @param EventManager|null      $eventManager
     * @param ComponentRegistry|null $components
     */
    public function __construct(
        ServerRequest $request = null,
        Response $response = null,
        $name = null,
        $eventManager = null,
        $components = null
    ) {
        parent::__construct($request, $response, $name, $eventManager, $components);

        // Load in all necessary models
        $this->loadModel('CombatActions');
        $this->loadModel('Monsters');
        $this->loadModel('Participants');
    }

    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];

        $user = $this->getUserOrRedirect();

        $combatEncounters = $this->CombatEncounters
            ->find()
            ->where(['user_id =' => $user['id']])
            ->order(['CombatEncounters.created DESC']);

        $combatEncountersPagination = $this->paginate($combatEncounters);

        $this->set('combatEncounters', $combatEncountersPagination);
    }

    /**
     * View method
     *
     * @param string|null $id Combat Encounter id.
     *
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $combatEncounter = $this->CombatEncounters->get(
            $id,
            [
                'contain' => [
                    'Users',
                    'Campaigns',
                    'Participants',
                ],
            ]
        );

        $this->set('combatEncounter', $combatEncounter);
    }

    /**
     * Add method
     *
     * @return Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $combatEncounter = $this->CombatEncounters->newEntity();
        $user            = $this->getUserOrRedirect();

        if ($this->request->is('post')) {
            [$validated, $newData] = $this->validateAndBlessData(
                $this->request->getData(),
                $user,
                $combatEncounter
            );
            debug($newData);
            exit;
            if ($validated) {
                $combatEncounter = $this->CombatEncounters->patchEntity($combatEncounter, $newData);
                if ($this->CombatEncounters->save($combatEncounter)) {
                    $this->Flash->success(__('The combat encounter has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The combat encounter could not be saved. Please, try again.'));
            }
        }

        $campaigns = $this->CombatEncounters->Campaigns
            ->find('list', ['limit' => 200])
            ->where(['user_id =' => $user['id']])
            ->order(['Campaigns.name ASC']);

        $combatActions = $this->CombatActions
            ->find(
                'list',
                [
                    'keyField'   => 'external_id',
                    'valueField' => 'name',
                    'limit'      => 200,
                ]
            )
            ->where(['visible' => 1])
            ->order(['CombatActions.name ASC']);

        $this->set(
            compact(
                'combatEncounter',
                'campaigns',
                'combatActions'
            )
        );
    }

    /**
     * Edit method
     *
     * @param string|null $id Combat Encounter id.
     *
     * @return Response|void Redirects on successful edit, renders view otherwise.
     */
    public function edit(?string $id = null)
    {
        return $this->redirect(
            [
                'action' => 'view',
                $id,
            ]
        );
    }

    /**
     * Delete method
     *
     * @param string|null $id Combat Encounter id.
     *
     * @return Response|void Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(
            [
                'post',
                'delete',
            ]
        );
        $combatEncounter = $this->CombatEncounters->get($id);
        if ($this->CombatEncounters->delete($combatEncounter)) {
            $this->Flash->success(__('The combat encounter has been deleted.'));
        } else {
            $this->Flash->error(__('The combat encounter could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Determines whether the user is authorised to be able to use this action
     *
     * @param array $user
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
        $combatEncounters = $this->CombatEncounters->findById($id)
            ->firstOrFail();

        return $combatEncounters->user_id
               === $user['id'];
    }

    /**
     * @param array           $data
     * @param array           $user
     * @param CombatEncounter $combatEncounter
     *
     * @return array
     */
    private function validateAndBlessData(array $data, array $user, CombatEncounter $combatEncounter): array
    {
        $campaign = $this->CombatEncounters->Campaigns
            ->findById($data['campaign_id'])
            ->contain(['PlayerCharacters'])
            ->firstOrFail();

        if ($campaign->user_id !== $user['id']) {
            $errorMsg = __('Please select a campaign that you own.');
            $combatEncounter->setError('campaign_id', $errorMsg);
            $this->Flash->error(__('The combat encounter could not be saved. Please try again.'));
            return [false];
        }

        $participantsData  = json_decode($data['participants'], true);
        $monsterIdsToCheck = [];
//        debug($participantsData);
//        debug($campaign);
//        debug($campaign->player_characters);
//        debug(array_column($campaign->player_characters, 'id'));

        foreach ($participantsData as $participantData) {
            if ($participantData['participantType'] === self::PARTICIPANT_TYPE_PLAYER_CHARACTER) {
                // If we have a player character,
                if (!in_array(
                    $participantData['id'],
                    array_column($campaign->player_characters, 'id'),
                    true
                )) {
                    $errorMsg = __(
                        'Player Character is not in your campaign, please check your selected campaign and player characters'
                    );
                    $combatEncounter->setError('campaign_id', $errorMsg);
                    $this->Flash->error(__('The combat encounter could not be saved. Please try again.'));
                    return [false];
                    break;
                }
            } elseif ($participantData['participantType'] === self::PARTICIPANT_TYPE_MONSTER) {
                $monsterIdsToCheck[] = $participantData['id'];
            } else {
                $errorMsg = __('Participant is not a known type (Monster or Player Character)');
                $combatEncounter->setError('participants', $errorMsg);
                $this->Flash->error(__('The combat encounter could not be saved. Please try again.'));
                return [false];
                break;
            }
            unset($participantData);
        }

        // Remove duplicate monster IDs
        $monsterIdsToCheck = array_unique($monsterIdsToCheck);

        if (!empty($monsterIdsToCheck)) {
            $monsters      = $this->Monsters->find()
                ->where(['id IN' => $monsterIdsToCheck]);
            $monstersCount = $monsters->count();

            if ($monstersCount !== count($monsterIdsToCheck)) {
                $errorMsg = __(
                    'You have selected a monster that does not exist, please try adding the monster again'
                );
                $combatEncounter->setError('participants', $errorMsg);
                $this->Flash->error(__('The combat encounter could not be saved. Please try again.'));
                return [false];
            }
        }

        $newData = [
            'name'         => $data['name'],
            'user_id'      => $user['id'],
            'campaign_id'  => $data['campaign_id'],
            'participants' => $this->getParticipantEntities($participantsData),
        ];

//        debug($newData);
//        debug($participantsData);
//        debug($combatEncounter->getErrors());
//        exit;
        return [true, $newData, $participantsData];
    }

    /**
     * @param array $participantsData
     *
     * @return array
     */
    private function getParticipantEntities(
        array $participantsData
    ): array {
        $participants = [];
        foreach ($participantsData as $participantData) {
//            $data = [
//                'first_name' => 'Sally',
//                'last_name' => 'Parker',
//                'courses' => [
//                    [
//                        'id' => 10,
//                        '_joinData' => [
//                            'grade' => 80.12,
//                            'days_attended' => 30
//                        ]
//                    ],
//                    // Other courses.
//                ]
//            ];
//            $student = $this->Students->newEntity($data, [
//                'associated' => ['Courses._joinData']
//            ]);

            $formattedParticipantData = [
                'initiative'          => $participantData['initiative'],
                //                'combat_encounter_id' => 0,
                /************* NEED TO ATTACH THIS TO THE COMBAT ENCOUNTER **********/
                'starting_hit_points' => $participantData['startingHitPoints'],
                'current_hit_points'  => $participantData['currentHitPoints'],
                'armour_class'        => $participantData['armourClass'],
                //                'combat_encounter'    => $combatEncounter,
                //                'conditions'          =>
                //                'monsters'            =>
                //                'player_characters'   =>
            ];

            if ($participantData['participantType'] === self::PARTICIPANT_TYPE_PLAYER_CHARACTER) {
                $formattedParticipantData['player_characters'] = [
                    'id' => $participantData['id'],
                ];
            } elseif ($participantData['participantType'] === self::PARTICIPANT_TYPE_MONSTER) {
                $formattedParticipantData['monsters'] = [
                    'id'        => $participantData['id'],
                    '_joinData' => ['name' => $participantData['name'],],
                ];
            } else {
                throw new InvalidArgumentException('Participant type not known');
            }

            /** @var Participant $participant */
            $participant = $this->Participants->newEntity(
                $formattedParticipantData,
                [
                    'associated' => ['PlayerCharacters._joinData',],
                ]
            );

//            $this->Participants->save($participant);
            $participants[] = $participant;
        }

        return $participants;
    }
}
