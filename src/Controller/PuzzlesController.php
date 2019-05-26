<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Puzzles Controller
 *
 * @property \App\Model\Table\PuzzlesTable $Puzzles
 *
 * @method \App\Model\Entity\Puzzle[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PuzzlesController extends AppController
{
    const CONTROLLER_NAME = 'Puzzles';
    public $paginate = [
        'limit' => 50,
        'order' => [
            'Puzzles.title' => 'asc'
        ]
    ];

    /**
     * Initialises the class, including authentication
     * 
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash');
        // $this->Auth->allow();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        // $this->paginate = [
        //     'contain' => ['Users']
        // ];
        $puzzles = $this->paginate($this->Puzzles);

        $this->set(compact('puzzles'));
        $this->set('title', self::CONTROLLER_NAME);
    }

    /**
     * View method
     *
     * @param string|null $id Puzzle id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $puzzle = $this->Puzzles->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('puzzle', $puzzle);
        $this->set('title', sprintf(
            'View %s - %s',
            self::CONTROLLER_NAME,
            $puzzle->title
        ));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $puzzle = $this->Puzzles->newEntity();
        if ($this->request->is('post')) {
            $puzzle = $this->Puzzles->patchEntity($puzzle, $this->request->getData());
            // Set the user ID on the item
            $puzzle->user_id = $this->Auth->user('id');
            // echo'<pre>';var_dump($puzzle);exit;
            if ($this->Puzzles->save($puzzle)) {
                $this->Flash->success(__('The puzzle, {0}, has been saved.', $puzzle->title));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The puzzle could not be saved. Please, try again.'));
        }
        $users = $this->Puzzles->Users->find('list', ['limit' => 200]);

        $this->set(compact('puzzle', 'users'));
        $this->set('title', sprintf(
            'Add %s - %s',
            self::CONTROLLER_NAME,
            $puzzle->title
        ));
    }

    /**
     * Edit method
     *
     * @param string|null $id Puzzle id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $puzzle = $this->Puzzles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $puzzle = $this->Puzzles->patchEntity($puzzle, $this->request->getData());
            // Set the user ID on the item
            // $puzzle->user_id = $this->Auth->user('id');
            if ($this->Puzzles->save($puzzle)) {
                $this->Flash->success(__('The puzzle, {0}, has been saved.', $puzzle->title));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The puzzle could not be saved. Please, try again.'));
        }
        $users = $this->Puzzles->Users->find('list', ['limit' => 200]);

        $this->set(compact('puzzle', 'users'));
        $this->set('title', sprintf(
            'Edit %s - %s',
            self::CONTROLLER_NAME,
            $puzzle->title
        ));
    }

    /**
     * Delete method
     *
     * @param string|null $id Puzzle id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $puzzle = $this->Puzzles->get($id);
        if ($this->Puzzles->delete($puzzle)) {
            $this->Flash->success(__('The puzzle, {0}, has been deleted.', $puzzle->title));
        } else {
            $this->Flash->error(__('The puzzle could not be deleted. Please, try again.'));
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
        // The add and tags actions are always allowed to logged in users
        if (in_array($action, [
            'add', 'edit',
        ])) {
            return true;
        }

        // All other actions require an item ID
        $id = $this->request->getParam('id');

        if (!$id) {
            return false;
        }

        // Check that the puzzle belongs to the current user
        $puzzle = $this->Puzzle->findById($id)->firstOrFail();

        return $puzzle->user_id === $user['id'];
    }
}

//29|29|000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000011100000000000000000000000001010000011110000000000000000101000001001000001000000000010100011100100000100000000001010001000040000010000000000001000101111111421000000000000111110111111100100110000000000000011000114110010000000000100001100011000001000000000011110110001100000100000000000001011111110000011411111110000041111111000000001111111000001000000000000110110001100000101111000000001011000110000010010100000000101100011000001111010000000010111111100000000001000000001411111114100000100011100000100000000010000011100010000010022000001000001010001000001141100000111111100000000000000220000000100011111111000000000000000050000000000000