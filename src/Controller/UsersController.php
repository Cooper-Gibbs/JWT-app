<?php
// src/Controller/UsersController.php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Firebase\JWT\JWT;

class UsersController extends AppController
{
    /*
    public function initialize()
    {
        parent::initialize();
        #$this->Auth->allow(['add', 'login']);
        //$this->loadComponent('RequestHandler');
        #$this->loadComponent("Security");
        #$this->loadComponent("Authentication.Authentication");
    }*/
    
    public function index()
    {
         $this->set('users', $this->Users->find()->all());
    }
    /*public function index() {
        $users = $this->Users->find()->all();
        $this->set([
            'users' => $users,
            '_serialize' => ['users']
        ]);
    }*/

    public function view($id)
    {
         $user = $this->Users->get($id);
         $this->set(compact('user'));
    }
    /*public function view($id) {
        $user = $this->Users->get($id);
        $this->set([
            'user' => $user,
            '_serialize' => ['user']
        ]);
    }*/
    /*
     public function add()
     {
         $user = $this->Users->newEmptyEntity();
         if ($this->request->is('post')) {
             $user = $this->Users->patchEntity($user, $this->request->getData());
             if ($this->Users->save($user)) {
                 $this->Flash->success(__('The user has been saved.'));
                 return $this->redirect(['action' => 'add']);
             }
             $this->Flash->error(__('Unable to add the user.'));
         }
         $this->set('user', $user);
     }
     /*
     
    /*public function add() {
        $this->request->allowMethod(['post', 'put']);
        $user = $this->Users->newEntity($this->request->getData());
        if ($this->Users->save($user)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            'user' => $user,
            '_serialize' => ['message', 'user']
        ]);
    }*/
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        #if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $this->Users->save($user);
            $this->set('data', [
                'id' => $user->id,
                'token' => JWT::encode(
                    [
                        'sub' => $user->id,
                        'exp' =>  time() + 604800
                    ])
                #Security::getSalt())
            ]);
        //echo Security::getSalt();
        #}
        $this->viewBuilder()->setOption('serialize', ['data']);
        $this->RequestHandler->renderAs($this, 'json');
    }
    /*
    public function add()
    {
        #$this->request->allowMethod(['post', 'put']);
        $userNew = $this->Users->newEmptyEntity();
        $userNew = $this->Users->patchEntity($userNew, $this->request->getData());
        $this->Users->save($userNew);
        /*$this->set('data', [
            'id' => $user->id,
            'token' => JWT::encode(
                [
                    'sub' => $user->id,
                    'exp' =>  time() + 604800
                ]
                #Security::getSalt())
            )]);
        //echo Security::getSalt();
        $privateKey = file_get_contents(CONFIG . '/jwt.key');
            #$user = $userNew->getData();
            $payload = [
                'iss' => 'myapp',
                'sub' => $userNew->id,
                'exp' => time() + 60,
            ];
            $json = [
                'token' => JWT::encode($payload, $privateKey, 'RS256'),
            ];
            $this->set(compact('json'));
            $this->viewBuilder()->setOption('serialize', 'json');
        $this->viewBuilder()->setOption('serialize', ['data']);
        $this->RequestHandler->renderAs($this, 'json');
    }*/

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login', 'add']);
        $this->Security->setConfig('unlockedActions', ['login', 'add']);
    }
    /*
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            // redirect to /articles after login success
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Articles',
                'action' => 'index',
            ]);

            return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid email or password'));
        }
    }*/
    
    /*
    public function login()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            /*
            $privateKey = file_get_contents(CONFIG . '/jwt.key');
            $user = $result->getData();
            $payload = [
                'iss' => 'myapp',
                'sub' => $user->id,
                'exp' => time() + 60,
            ];
            $json = [
                'token' => JWT::encode($payload, $privateKey, 'RS256'),
            ];
            $this->set(compact('json'));
            $this->viewBuilder()->setOption('serialize', 'json');
            
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Articles',
                'action' => 'index',
            ]);
            return $this->redirect($redirect);
            
        } else {
            $this->response = $this->response->withStatus(401);
            $json = [];
        }
        $this->set(compact('json'));
        $this->viewBuilder()->setOption('serialize', 'json');

        $redirect = $this->request->getQuery('redirect', [
            'controller' => 'Articles',
            'action' => 'index',
        ]);
        return $this->redirect($redirect);
    }*/
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            // redirect to /articles after login success
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Articles',
                'action' => 'index',
            ]);

            return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid email or password'));
        }
    }
    
    // in src/Controller/UsersController.php
    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }
}
