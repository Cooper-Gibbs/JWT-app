<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;
use Cake\Event\EventInterface;
use Cake\Controller\Controller;
use Cake\Event\EventListenerInterface;
use Cake\Utility\Security;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Security');
         // Add this line to check authentication result and lock your site
        $this->loadComponent('Authentication.Authentication');
        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        #$this->loadComponent('FormProtection');
        
        $this->loadComponent('Auth', [
            'storage' => 'Memory',
            'authenticate' => [
                'Form' => [
                    'scope' => ['Users.active' => 1]
                ],
                'ADmad/JwtAuth.Jwt' => [
                    'parameter' => 'token',
                    'userModel' => 'Users',
                    'scope' => ['Users.active' => 1],
                    'fields' => [
                       'username' => 'id'
                    ],
                    'queryDatasource' => true
                ]
            ],
            'unauthorizedRedirect' => 'Users/login',
            'checkAuthIn' => 'AppController.initialize'
        ]);
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
                    'queryDatasource' => True,
                ]
            ],

            'unauthorizedRedirect' => '/users/login',
            'checkAuthIn' => 'Controller.initialize',

            // If you don't have a login action in your application set
            // 'loginAction' to false to prevent getting a MissingRouteException.
            'loginAction' => true
        ]);*/
    }

    // in src/Controller/AppController.php
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        #$actions = ['index', 'view', 'add', 'edit', 'delete'];
        
        #if(in_array($this->request->params['action'], $actions)) {
            // for csrf
            #$this->eventManager()->off($this->Csrf);
        
            // for security component
        #$this->Security->setConfig('unlockedActions', $actions);
        #}
        // for all controllers in our application, make index and view
        // actions public, skipping the authentication check.
        #$this->Security->setConfig('unlockedActions', ['edit', 'view', 'add', 'delete']);
        $this->Authentication->addUnauthenticatedActions(['index', 'view', 'add', 'delete', 'edit']);
        #$this->Security->setConfig('unlockedActions', ['edit', 'view', 'add', 'delete']);
    }
}
