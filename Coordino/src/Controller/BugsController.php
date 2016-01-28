<?php
namespace Coordino\Controller;

use Coordino\Controller\AppController;

/**
 * Bugs Controller
 *
 * @property \Coordino\Model\Table\BugsTable $Bugs
 */
class BugsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('bugs', $this->paginate($this->Bugs));
        $this->set('_serialize', ['bugs']);
    }

    /**
     * View method
     *
     * @param string|null $id Bug id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bug = $this->Bugs->get($id, [
            'contain' => []
        ]);
        $this->set('bug', $bug);
        $this->set('_serialize', ['bug']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bug = $this->Bugs->newEntity();
        if ($this->request->is('post')) {
            $bug = $this->Bugs->patchEntity($bug, $this->request->data);
            if ($this->Bugs->save($bug)) {
                $this->Flash->success(__('The bug has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The bug could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('bug'));
        $this->set('_serialize', ['bug']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Bug id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bug = $this->Bugs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bug = $this->Bugs->patchEntity($bug, $this->request->data);
            if ($this->Bugs->save($bug)) {
                $this->Flash->success(__('The bug has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The bug could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('bug'));
        $this->set('_serialize', ['bug']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Bug id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bug = $this->Bugs->get($id);
        if ($this->Bugs->delete($bug)) {
            $this->Flash->success(__('The bug has been deleted.'));
        } else {
            $this->Flash->error(__('The bug could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
