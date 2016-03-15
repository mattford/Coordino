<?php
namespace Coordino\Controller;

use Coordino\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Inflector;
use Cake\Mailer\Email;

/**
 * Posts Controller
 *
 * @property \Coordino\Model\Table\PostsTable $Posts
 */
class PostsController extends AppController
{
    
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('index', 'view', 'miniSearch');
    }
    
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Relateds', 'Users']
        ];
        $this->set('posts', $this->paginate($this->Posts));
        $this->set('_serialize', ['posts']);
    }

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        if ($this->Auth->user()) {
            $this->Posts->loadExistingVotes($this->Auth->user('id'));
        }
        $post = $this->Posts->get($id, [
            'contain' => [
                'Users', 
                'PostTags.Tags', 
                'Answers', 
                'Answers.Users', 
                'Answers.Comments', 
                'Answers.Comments.Users', 
                'Comments', 
                'Comments.Users', 
                'ExistingVotes'
            ]
        ]);
        $answer = $this->Posts->newEntity();
        $this->set('post', $post);
        $this->set('answer', $answer);
        $this->set('_serialize', ['post']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Post id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $post = $this->Posts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->Posts->patchEntity($post, $this->request->data);
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('The post has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The post could not be saved. Please, try again.'));
            }
        }
        $users = $this->Posts->Users->find('list', ['limit' => 200]);
        $this->set(compact('post', 'users'));
        $this->set('_serialize', ['post']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Post id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $post = $this->Posts->get($id);
        if ($this->Posts->delete($post)) {
            $this->Flash->success(__('The post has been deleted.'));
        } else {
            $this->Flash->error(__('The post could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function ask() {
        $this->set('title_for_layout', __('Ask a question',true));
        
        $post = $this->Posts->newEntity(['type' => 'question']);
        if ($this->request->is('post')) {
            $post = $this->Posts->patchEntity($post, $this->request->data);

            if ($this->Posts->save($post)) {
                return $this->redirect(['controller' => 'posts', 'action' => 'view', $post->id]);
            } else {
                $this->Flash->error("Failed to create post, please check and try again.");
            }                     
        }

    }

    public function answer($postId) 
    {
        $answer = $this->Posts->newEntity(['type' => 'answer', 'parent_post_id' => $postId]);
        $post = $this->Posts->get($postId, ['contain'=>['Users']]);
        if ($this->request->is('post')) {
            $answer = $this->Posts->patchEntity($answer, $this->request->data);
            if ($this->Posts->save($answer)) {
                $email = new Email();
                $email->to($post->user->email)
                      ->template('answered', 'default')
                      ->emailFormat('html')
                      ->subject("Your question has been answered")
                      ->viewVars(['post'=>$post])
                      ->send();      
                return $this->redirect(['controller' => 'posts', 'action' => 'view', $postId]);
            } else {
                $this->Flash->error("Failed to save your answer, please try again");              
                $this->set(compact('post', 'answer'));
                $this->render('view');
            }
        }
        return $this->redirect(['action' => 'view', $postId]);
        
    }
    
    public function comment($postId)
    {
        $comment = $this->Posts->newEntity(['type' => 'comment', 'parent_post_id' => $postId]);
        $post = $this->Posts->get($postId);
        if ($post->type === 'question') {
            $question = $post;
        } else {
            $question = $this->Posts->get($post->parent_post_id);
        }
        if ($this->request->is('post')) {
            $comment = $this->Posts->patchEntity($comment, $this->request->data);
            if ($this->Posts->save($comment)) {
                return $this->redirect(['action' => 'view', $question->id, '#' => 'comment_'.$comment->id]);
            } else {
                $this->Flash->error('Failed to save your comment, please try again.');
                return $this->redirect(['action' => 'view', $question->id]);
            }
        }
        return $this->redirect(['action' => 'view', $question->id]);
    }
    
    /**
     * Vote on a post, this method should only be called via ajax
     * @return array
     */
    public function vote() 
    {
        $this->request->allowMethod('post');   
        
        $data = $this->request->data;
        
        if (!isset($data['postId']) || !isset($data['direction'])) {
            $this->set('response', ['status' => 0, 'error' => 'Data went wrong', 'data' => $data]);
            $this->set('_serialize', ['response']);
            return;
        }
        
        $postId = $data['postId'];
        $direction = $data['direction'];
        
        $this->loadModel('Votes');
        $this->loadModel('Settings');
                       
        $post = $this->Posts->get($postId, ['contain' => 'Users']);
        if (!$post) {
            return 500;
        }
        
        $existing = $this->Votes->find('all', [
            'conditions' => [
                'user_id' => $this->Auth->user('id'),
                'post_id' => $postId,
                'type' => $direction
            ]
        ])->first();
         
        $rep_up = $this->Settings->findByName('rep_vote_up')->first(); 
        $rep_down = $this->Settings->findByName('rep_vote_down')->first();
        
        if ($existing) {
            switch ($direction) {
                case 'up':
                    $rep = -$rep_up->value;
                    $post->votes = $post->votes - 1;
                    break;
                case 'down':
                    $rep = abs($rep_down->value);
                    $post->votes = $post->votes + 1;
                    break;
            }
            $this->Votes->delete($existing);
            $resultantVoteDirection = 'none';
        } else {
            switch($direction) {
                case 'up':
                    $rep_needed = $this->Settings->findByName('rep_needed_vote_up')->first();
                    $rep = $rep_up->value;            
                    $opposite = $this->Votes->find('all', [
                        'conditions' => [
                            'user_id' => $this->Auth->user('id'),
                            'post_id' => $postId,
                            'type' => 'down'
                        ]
                    ])->first();

                    if ($opposite) {
                        $this->Votes->delete($opposite);
                        // Add 2 votes to make up for the downvote we just removed
                        $votes = 2;
                        // Add the rep from the downvote we're removing
                        $rep += abs($rep_down->value);
                    } else {
                        $votes = 1;
                    }

                    $post->votes = $post->votes + $votes;
                    break;
                case 'down':
                    $rep_needed = $this->Settings->findByName('rep_needed_vote_down')->first();
                    $rep = $rep_down->value;         
                    $opposite = $this->Votes->find('all', [
                        'conditions' => [
                            'user_id' => $this->Auth->user('id'),
                            'post_id' => $postId,
                            'type' => 'up'
                        ]
                    ])->first();

                    if ($opposite) {
                        $this->Votes->delete($opposite);
                        // Remove 2 votes to make up for the upvote we just removed
                        $votes = 2;
                        // Remove rep for the upvote we're removing
                        $rep -= $rep_up->value;
                    } else {
                        $votes = 1;
                    }
                    $post->votes = $post->votes - $votes;
                    break;
                default:
                    $this->set('response', ['status' => 0, 'error' => 'Invalid vote direction']);
                    $this->set('_serialize', ['response']);
                    return;
            }
            
            $vote = $this->Votes->newEntity([
                'post_id' => $postId,
                'type' => $direction
            ]);

            if (!$this->Votes->save($vote)) {
                $this->set('response', ['status' => 0, 'error' => "Error saving vote"]);
                $this->set('_serialize', ['response']);
                return;
            }
            
            $resultantVoteDirection = $direction;
        }
        
        if (isset($rep_needed) && $this->Auth->user('reputation') < $rep_needed->value) {
            $this->set('response', ['status' => 0, 'error' => "You need at least ". $rep_needed->value . " reputation to vote ". $direction]);
            $this->set('_serialize', ['response']);
            return;
        }

        $post->user->reputation = $post->user->reputation + $rep;
        $post->dirty('user', true);

        if (!$this->Posts->save($post)) {
            $this->set('response', ['status' => 0, 'error' => "Error saving vote"]);
            $this->set('_serialize', ['response']);
            return;
        }

        $this->set('response', [
            'status' => 1, 
            'postId' => $postId, 
            'userId' => $post->user->id,
            'newVoteCount' => $post->votes, 
            'newVoteDirection' => $resultantVoteDirection, 
            'newUserRep' => $post->user->reputation
        ]);
        $this->set('_serialize', ['response']);
        
    }
    
    public function flag($postId)
    {
        $this->loadModel('Votes');
        $this->loadModel('Settings');
        
        $post = $this->Posts->get($postId);
        
        if (!$post) {
            $this->Flash->error("Post not found.");
            return $this->redirect($this->request->referer());
        }
        
        $existing = $this->Votes->find('all', [
            'conditions' => [
                'post_id' => $postId,
                'user_id' => $this->Auth->user('id'),
                'type' => 'flag'
            ]
        ])->first();
        
        if ($existing) {
            $this->Flash->error("You can only flag a post once.");
            return $this->redirect($this->request->referer());
        }
        
        $post->flags = $post->flags + 1;
        
        if (!$this->Posts->save($post)) {
            $this->Flash->error("Failed to flag post, please try again.");
            return $this->redirect($this->request->referer());
        }
        
        $vote = $this->Votes->newEntity([
           'post_id' => $postId,
           'type' => 'flag'
        ]);
        
        if (!$this->Votes->save($vote)) {
            $this->Flash->error("Failed to flag post, please try again.");
            return $this->redirect($this->request->referer());
        }
        
        $this->Flash->success("Thank you for flagging this post.");
        return $this->redirect($this->request->referer());
        
    }
    
    public function solved($postId, $answerId) 
    {
        $this->loadModel("Settings");
           
        $post = $this->Posts->get($postId, ['contain' => 'Users']);

        if ($post->user->id !== $this->Auth->user("id")) {
            $this->Flash->error("Only the question owner can mark an answer as correct");
            return $this->redirect($this->request->referer());
        }
        
        $rep = $this->Settings->findByName('rep_answer_correct')->first();
        
        $answer = $this->Posts->get($answerId, ['contain' => 'Users']);
        
        $post->status = 'closed';
        
        $answer->status = 'correct';
        $answer->user->reputation = $answer->user->reputation + $rep->value;
        $answer->dirty('user', true);
        
        if (!$this->Posts->save($post) || !$this->Posts->save($answer)) {
            $this->Flash->error("Failed to mark question as solved, please try again.");
        }
        
        return $this->redirect($this->request->referer());
    }
}
