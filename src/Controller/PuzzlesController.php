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
        $this->Auth->allow();
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
}
