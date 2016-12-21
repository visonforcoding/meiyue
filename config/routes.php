<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    //$routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
    $routes->extensions(['json', 'xml', 'shtml']);
    //子域名模式
    $subdomain = substr(env('HTTP_HOST'), 0, strpos(env('HTTP_HOST'), '.'));
    if (in_array($subdomain, ['admin', 'm','m-my','admin-my'])) {
        if(in_array($subdomain,['m-my','m'])){
            $subdomain = 'mobile';
        }
        if(in_array($subdomain,['admin','admin-my'])){
            $subdomain = 'admin';
        }
        $routes->connect('/:controller/:action/*', ['prefix' => $subdomain]);
    }
    if ($subdomain == 'admin') {
   
        //wpadmin 的路由重置
        $routes->connect('/admin/login', ['plugin' => 'wpadmin', 'controller' => 'admin', 'action' => 'login']);
        $routes->connect('/admin/index', ['plugin' => 'wpadmin', 'controller' => 'admin', 'action' => 'index']);
        $routes->connect('/admin/edit/*', ['plugin' => 'wpadmin', 'controller' => 'admin', 'action' => 'edit']);
        $routes->connect('/menu/index', ['plugin' => 'wpadmin', 'controller' => 'menu', 'action' => 'index']);
        $routes->connect('/menu/edit/*', ['plugin' => 'wpadmin', 'controller' => 'menu', 'action' => 'edit']);
        $routes->connect('/menu/add/*', ['plugin' => 'wpadmin', 'controller' => 'menu', 'action' => 'add']);
        $routes->connect('/group/index', ['plugin' => 'wpadmin', 'controller' => 'group', 'action' => 'index']);
        $routes->connect('/group/add', ['plugin' => 'wpadmin', 'controller' => 'group', 'action' => 'add']);
        $routes->connect('/group/edit', ['plugin' => 'wpadmin', 'controller' => 'group', 'action' => 'edit']);
        $routes->connect('/actionlog/index', ['plugin' => 'wpadmin', 'controller' => 'actionlog', 'action' => 'index']);
        $routes->connect('/admin/', ['plugin' => 'wpadmin', 'controller' => 'index', 'action' => 'index']);
        $routes->connect('/', ['plugin' => 'wpadmin', 'controller' => 'index', 'action' => 'index']);
    }
    //上传
    $routes->connect('/do-upload/*', ['plugin' => 'wpadmin', 'controller' => 'util', 'action' => 'doUpload']);

    $routes->connect('/do-download/*', ['plugin' => 'wpadmin', 'controller' => 'util', 'action' => 'download']);
    //m端
    if($subdomain=='mobile'){
        $routes->connect('/', ['prefix' => 'mobile', 'controller' => 'index', 'action' => 'index']);
    }

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    //$routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
