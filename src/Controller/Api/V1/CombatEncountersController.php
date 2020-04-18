<?php
namespace App\Controller\Api\V1;

use App\Controller\AppController\Api\V1;

/**
 * CombatEncounters Controller
 *
 * @property \App\Model\Table\CombatEncountersTable $CombatEncounters
 *
 * @method \App\Model\Entity\CombatEncounter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CombatEncountersController extends ApiAppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $combatEncounters = $this->CombatEncounters->find('all');
        $this->set([
            'CombatEncounters' => $combatEncounters,
            '_serialize' => [
                'CombatEncounters'
            ]
        ]);
    }

    public function view()
    {
        $combatEncounter = $this->CombatEncounters->findById($this->request->getParam('id'));
        $this->set([
            'CombatEncounters' => $combatEncounter,
            '_serialize' => [
                'CombatEncounters'
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
        $combatEncounters = $this->CombatEncounters->findById($id)->firstOrFail();

        return $combatEncounters->user_id === $user['id'];
    }
}
