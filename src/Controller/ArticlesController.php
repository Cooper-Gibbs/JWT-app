<?php
declare(strict_types=1);

// src/Controller/ArticlesController.php
namespace App\Controller;
use Cake\Event\EventInterface;

class ArticlesController extends AppController
{
    public function initialize(): void 
    {
        parent::initialize();
        #$this->loadComponent('RequestHandler');
        $this->loadComponent('Security');
        $this->loadComponent('Authentication.Authentication');
        #$this->loadComponent('Csrf');
        /*$this->loadComponent('Auth', [
            'storage' => 'Memory',
            'authenticate' => [
                'ADmad/JwtAuth.Jwt' => [
                    'userModel' => 'Users',
                    'fields' => [
                        'username' => 'id'
                    ],

                    'parameter' => 'token',

                    // Boolean indicating whether the "sub" claim of JWT payload
                    // should be used to query the Users model and get user info.
                    // If set to `false` JWT's payload is directly returned.
                    'queryDatasource' => true,
                ]
            ],

            'unauthorizedRedirect' => false,
            'checkAuthIn' => 'Controller.initialize',

            // If you don't have a login action in your application set
            // 'loginAction' to false to prevent getting a MissingRouteException.
            'loginAction' => false
        ]);*/
        //$this->loadComponent("RequestHandler");
    }
    /*public function index() 
    {
        $this->set('articles', $this->Articles->find()->all()); 
    }*/
    public function index() {
        $article = $this->Articles->find('all');
        $this->set([
            'articles' => $article,
            '_serialize' => ['articles']
        ]);
    }
    /*public function view($id = null) {
        $article = $this->Articles->get($id);
        $this->set(compact('article'));
    }*/
    /*
    public function view($id = null) {
        $article = $this->Articles->get($id);
        $this->set([
            'article' => $article,
            '_serialize' => ['article']
        ]);
    }
    */

    public function view($id)
    {
        $article = $this->Articles->get($id);
        $this->set([
            'article' => $article,
            '_serialize' => ['article']
        ]);
    }

    /*public function add()
    {
        $article = $this->Articles->newEmptyEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }
        $this->set('article', $article);

        // Just added the categories list to be able to choose
        // one category for an article
        $categories = $this->Articles->Categories->find('treeList')->all();
        $this->set(compact('categories'));
    }*/
    
    public function add() {
        $article = $this->Articles->newEntity($this->request->getData());
        if($this->request->is(['post', 'put'])) {
            if ($this->Articles->save($article)) {
                $message = 'Saved';
            } else {
                $message = 'Error';
            }
            $this->set([
                'message' => $message,
                'article' => $article,
                '_serialize' => ['message', 'article']
            ]);
            
           # return $this->redirect(['action' => 'index']);
            }
        $this->set('article', $article);
        $categories = $this->Articles->Categories->find('treeList')->all();
        $this->set(compact('categories'));
        #return $this->redirect(['action' => 'index']);
    }
    
    /*
    public function add()
    {
        if(!$this->request->is(['post', 'put'])) {
            return;
        }
        $article = $this->Articles->newEntity($this->request->getData());
        if ($this->Articles->save($article)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $categories = $this->Articles->Categories->find('treeList')->all();
        $this->set(compact('categories'));
        $this->set([
            'message' => $message,
            'article' => $article,
            '_serialize' => ['message', 'article']
        ]);
    }
    */
    /*public function edit($id = null)
    {
        $article = $this->Articles->get($id);
        if ($this->request->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your article.'));
        }

        $this->set('article', $article);
    }*/
    
    public function edit($id = null) {
        $article = $this->Articles->get($id);
        if($this->request->is(['patch', 'post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
              $message = 'Saved';
            } else {
                $message = 'Error';
            }
            $this->set([
                'message' => $message,
                '_serialize' => ['message']
            ]);
            #return $this->redirect(['action' => 'index']);
        }
        $this->set('article', $article);
    }
    
    /*
    public function edit($id)
    {
        if(!$this->request->is(['post', 'put', 'patch'])) {
            return;
        }
        $article = $this->Articles->get($id);
        $article = $this->Articles->patchEntity($article, $this->request->getData());
        if ($this->Articles->save($article)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }
    */
    /*public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);

        $article = $this->Articles->get($id);
        if($this->Articles->delete($article)) {
            $this->Flash->success(__('The article with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
        }

    }*/
    /*
    public function delete($id = null)
    {
        if(!$this->request->is(['delete'])) {
            return;
        }
        $article = $this->Articles->get($id);
        $message = 'Deleted';
        if (!$this->Articles->delete($article)) {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }
*/
    
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        $message = 'Deleted';
        if (!$this->Articles->delete($article)) {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
        return $this->redirect(['action' => 'index']);
    }
    
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        #$this->getEventManager()->off($this->Csrf);
        $this->Security->setConfig('unlockedActions', ['edit', ' index', 'view', 'add', 'delete']);
        
        #$this->Security->setConfig('unlockedActions', ['view', 'index']);
        $this->Authentication->addUnauthenticatedActions(['index', 'view', 'add', 'edit', 'delete']);
        #$this->Security->setConfig('unlockedActions', ['edit', 'view', 'add', 'delete']);
    }
}