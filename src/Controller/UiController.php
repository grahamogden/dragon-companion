<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * UI Controller
 */
class UiController extends AppController
{
    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
    }
}
