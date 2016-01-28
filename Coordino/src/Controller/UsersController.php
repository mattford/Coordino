<?php
namespace Coordino\Controller;

use Coordino\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Utility\Text;

/**
 * Users Controller
 *
 * @property \Coordino\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * 
     * @param \Coordino\Controller\Event $event
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['login', 'register', 'reset']);
    }

    /**
     * 
     * @return type
     */
    public function login() 
    {
        $this->pageTitle = 'Login';

        if ($this->request->is('post')) {
           $user = $this->Auth->identify();
           if ($user) {
               $this->Auth->setUser($user);
               return $this->redirect($this->Auth->redirectUrl());
           } else {
               $this->Flash->error(__('Username or password is incorrect'), [
                   'key' => 'auth'
               ]);
           }
        }
    }
     
    /**
     * 
     */
    public function register() {
        $this->pageTitle = 'Register';
       
        $user = $this->Users->newEntity();
        
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success('User successfully registered.');
                $this->Auth->setUser($user->toArray());
                return $this->redirect('/');
            } else {
                $this->Flash->error('Failed to create user, please check the input and try again.');
            }
        }
       
        $this->set(compact('user'));
    }
    
    public function settings() {
        
        $user = $this->Users->findById($this->Auth->user('id'))->first();
        
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success('Settings updated');
            } else {
                $this->Flash->error('Failed to update settings');
            }
        }
		
        $this->set(compact('user'));
		
    }
        
    public function requestPasswordReset() {
        if ($this->request->is('post')) {
            $user = $this->Users->findByEmail($this->request->data['email'])->first();
            if(!empty($user)) {
                $resetKey = Text::uuid();
                $user = $this->Users->patchEntity($user, [
                    'id' => $user->id,
                    'reset_key' => $resetKey,
                    'reset_timestamp' => new \DateTime()                      
                ]);
                if ($this->Users->save($user)) {
                    $email = new Email();
                    $email->template('reset', 'default')
                          ->emailFormat('html')
                          ->to($user->email)
                          ->subject('Password Reset Requested')
                          ->viewVars(['user' => $user])
                          ->send();
                    $this->Flash->success('An email has been sent to you with a link to reset your password.');
                } else {
                    $this->Flash->error('An error occured when trying to reset your password, please try again.');
                }
            }
        }
    }
    
    public function resetPassword($userId, $resetKey)
    {
        $user = $this->Users->find('all', [
            'conditions' => [
                'id' => $userId,
                'reset_key' => $resetKey,
            ]
        ])->first();
        if (!$user) {
            $this->Flash->error("This password reset link is either incorrect or expired, you can request a new one below.");
            return $this->redirect(['action'=>'requestPasswordReset']);
        }
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            $user->reset_key = null;
            $user->reset_timestamp = null;
            if ($this->Users->save($user)) {
                $this->Flash->success("Password updated successfully");
                $this->Auth->setUser($user->toArray());
                return $this->redirect('/');
            } else {
                $this->Flash->error("Password failed to update, please try again");
            }
        }
    }
	
    public function logout(){
        if($this->Setting->getValue('remote_auth_only') == 'yes') {
            $this->Auth->logout();
            $this->redirect($this->Setting->getValue('remote_auth_logout_url'));
        }
        $this->redirect($this->Auth->logout());
    }
	
    public function view($id) {
        $user = $this->Users->findById($id)->first();
        $this->pageTitle = $user->username . '\'s Profile';
        $this->set(compact('user'));
    }

    
}
