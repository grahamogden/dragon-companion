<?php

namespace App\Controller;

use App\Model\Entity\CombatEncounter;
use App\Model\Entity\Participant;
use App\Model\Table\CombatActionsTable;
use App\Model\Table\CombatEncountersTable;
use App\Model\Table\CombatTurnsTable;
use App\Model\Table\MonstersTable;
use App\Model\Table\ParticipantsTable;
use Authentication\IdentityInterface;
use Cake\Controller\ComponentRegistry;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\EventManager;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use DateTime;
use Exception;
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

    /** @var CombatTurnsTable|null */
    private $combatTurnsTable;

    /** @var CombatActionsTable|null*/
    private $combatActionsTable;

    /** @var MonstersTable */
    private $monstersTable;

    /** @var ParticipantsTable */
    private $participantsTable;

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
        $this->combatActionsTable = $this->fetchTable('CombatActions');
        $this->combatTurnsTable = $this->fetchTable('CombatTurns');
        $this->monstersTable = $this->fetchTable('Monsters');
        $this->participantsTable = $this->fetchTable('Participants');
    }

    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => [
                'Users',
                'Campaigns',
            ],
        ];

        $user = $this->getUserOrRedirect();

        $combatEncounters = $this->CombatEncounters
            ->find()
            ->where(['CombatEncounters.user_id =' => $user['id']])
            ->order(['CombatEncounters.created DESC']);

        $combatEncountersPagination = $this->paginate($combatEncounters);

        $this->set('combatEncounters', $combatEncountersPagination);
    }

    /**
     * View method
     *
     * @param string|null $id Combat Encounter id.
     *
     * @return void
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
                    'Participants' => [
                        'sort' => ['Participants.initiative' => 'DESC',],
                        'Monsters',
                        'PlayerCharacters',
                    ],
                    'CombatTurns'  => [
                        'sort'              => ['CombatTurns.turn_order' => 'ASC',],
                        'CombatActions',
                        'SourceParticipant' => ['Monsters', 'PlayerCharacters',],
                        'TargetParticipant' => ['Monsters', 'PlayerCharacters',],
                    ],
                ],
            ]
        );

        $this->set(compact('combatEncounter'));
    }

    /**
     * Add method
     *
     * @return Response|void Redirects on successful add, renders view otherwise.
     * @throws Exception
     */
    public function add()
    {
        /** @var CombatEncounter $combatEncounter */
        $combatEncounter = $this->CombatEncounters->newEmptyEntity();
        $user            = $this->getUserOrRedirect();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            [$validated, $newData] = $this->validateAndBlessData(
                $data,
                $user,
                $combatEncounter
            );

            if ($validated) {
                $combatEncounter = $this->CombatEncounters->newEntity(
                    $newData,
                    ['associated' => ['Participants',],]
                );

                if ($this->CombatEncounters->save($combatEncounter)) {
                    $participantsAfterSave = $this->participantsTable->findByCombatEncounterId($combatEncounter->id);

                    $this->saveCombatTurns(
                        json_decode($data['turns'], true),
                        $combatEncounter,
                        $participantsAfterSave,
                        $this->combatActionsTable
                            ->find(
                                'list',
                                [
                                    'keyField'   => 'external_id',
                                    'valueField' => 'id',
                                ]
                            )
                            ->where(['visible' => true])
                            ->toArray()
                    );

                    $this->Flash->success(__('The combat encounter has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The combat encounter could not be saved. Please, try again.'));
            }
        }

        $campaigns = $this->CombatEncounters->Campaigns
            ->find('list', ['limit' => 200])
            ->order(['Campaigns.name ASC']);

        $combatActions = $this->combatActionsTable
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
        $this->set(
            'combatEncounterSuggestedName',
            sprintf('Combat Encounter (%s)', (new DateTime())->format('Y-m-d H:i'))
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

        return $combatEncounters->user_id === $user['id'];
    }

    /**
     * @param array             $data
     * @param IdentityInterface $user
     * @param CombatEncounter   $combatEncounter
     *
     * @return array
     */
    private function validateAndBlessData(array $data, IdentityInterface $user, CombatEncounter $combatEncounter): array
    {
        // Check that the campaign is for this user
        $campaign = $this->CombatEncounters->Campaigns
            ->findById($data['campaign_id'])
            ->contain(['PlayerCharacters'])
            ->firstOrFail();

        $participantsData  = json_decode($data['participants'], true);
        $monsterIdsToCheck = [];

        // For each participant from the form, loop over them and validate whether they are allowed for this configuration
        foreach ($participantsData as $participantData) {
            if ($participantData['participantType'] === self::PARTICIPANT_TYPE_PLAYER_CHARACTER) {
                // If we have a player character, then we want to enter here

                // If the player character is not for this campaign, however, then throw an error message
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
                }
            } elseif ($participantData['participantType'] === self::PARTICIPANT_TYPE_MONSTER) {
                // If this is a monster, then add it to the list of IDs we need to check
                $monsterIdsToCheck[] = $participantData['id'];
            } else {
                // If it is not a player character or a monster, then what is it?! Error!
                $errorMsg = __('Participant is not a known type (Monster or Player Character)');
                $combatEncounter->setError('participants', $errorMsg);
                $this->Flash->error(__('The combat encounter could not be saved. Please try again.'));
                return [false];
            }
            unset($participantData);
        }

        // Remove duplicate monster IDs
        $monsterIdsToCheck = array_unique($monsterIdsToCheck);

        // Find all of the monsters that have been used and ensure that they actually exist
        if (!empty($monsterIdsToCheck)) {
            $monsters      = $this->monstersTable->find()
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
            'user_id'      => $user->getIdentifier(),
            'campaign_id'  => $data['campaign_id'],
            'participants' => $this->getParticipantEntities($participantsData),
        ];

        return [true, $newData,];
    }

    /**
     * @param array $participantsData
     *
     * @return array
     */
    private function getParticipantEntities(array $participantsData): array
    {
        $participants = [];

        foreach ($participantsData as $participantData) {
            $formattedParticipantData = [
                'initiative'          => $participantData['initiative'],
                'starting_hit_points' => $participantData['startingHitPoints'],
                'current_hit_points'  => $participantData['currentHitPoints'],
                'armour_class'        => $participantData['armourClass'],
                'name'                => $participantData['name'],
                'temporary_id'        => $participantData['tempId'],
                'combat_turns'        => [],
            ];

            if ($participantData['participantType'] === self::PARTICIPANT_TYPE_PLAYER_CHARACTER) {
                $formattedParticipantData['player_character_id'] = $participantData['id'];
            } elseif ($participantData['participantType'] === self::PARTICIPANT_TYPE_MONSTER) {
                $formattedParticipantData['monster_id'] = $participantData['id'];
            } else {
                throw new InvalidArgumentException('Participant type not known');
            }

            $participants[] = $formattedParticipantData;
        }

        return $participants;
    }

    /**
     * @param array $combatTurnsData
     * @param       $combatEncounter
     * @param       $participantEntities
     * @param array $combatActions
     */
    private function saveCombatTurns(
        array $combatTurnsData,
        $combatEncounter,
        $participantEntities,
        array $combatActions
    ): void {
        $participantEntitiesMapped = [];

        /** @var Participant $participantEntity */
        foreach ($participantEntities as $participantEntity) {
            $participantEntitiesMapped[$participantEntity->temporary_id] = $participantEntity;
            unset($participantEntity);
        }

        $combatTurns = [];

        foreach ($combatTurnsData as $combatTurnData) {
            $combatTurnArray = [
                'combat_encounter_id' => $combatEncounter['id'],
                'round_number'        => $combatTurnData['roundNumber'] ?: 0,
                'turn_order'          => $combatTurnData['turnNumber'] ?: 0,
                'combat_action_id'    => $combatActions[$combatTurnData['action']],
                'roll_total'          => $combatTurnData['roll'] ?: 0,
                'net_action_total'    => $combatTurnData['total'] ?: 0,
                'movement'            => $combatTurnData['movement'] ?: 0,
            ];

            if ($combatTurnData['sourceTempId']) {
                $combatTurnArray['source_participant_id'] = $participantEntitiesMapped[$combatTurnData['sourceTempId']]->id;
            }

            if ($combatTurnData['targetTempId']) {
                $combatTurnArray['target_participant_id'] = $participantEntitiesMapped[$combatTurnData['targetTempId']]->id;
            }

            $combatTurns[] = $this->combatTurnsTable->newEntity($combatTurnArray);
        }
        try {
            $combatTurnsSaveResult = $this->combatTurnsTable->saveMany($combatTurns);

            if (!$combatTurnsSaveResult) {
                $this->Flash->error(
                    'The combat turn data could not be saved, but the combat encounter itself has been. Apologies, but you will need to re-enter the combat turns again.'
                );
            }
        } catch (Exception $e) {
            debug($e);
        }
    }
}
