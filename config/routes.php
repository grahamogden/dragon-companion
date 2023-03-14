<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\RouteBuilder;
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
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
/** @var RouteBuilder $routes */
$routes->setRouteClass(DashedRoute::class);

$routes->scope(
    '/',
    function (RouteBuilder $routes) {
        $routes->prefix(
            'Api/V1',
            function (RouteBuilder $routes) {
                $routes->setExtensions(['json']);
                $routes->resources(
                    'CombatEncounters',
                    [
                        // 'actions' => [
                        //     'create' => 'apiAdd',
                        //     'read'   => 'apiView',
                        //     'update' => 'apiUpdate',
                        //     'delete' => 'apiDelete',
                        // ],
                        'path' => 'combat-encounters',
                    ]
                );

                $routes->resources(
                    'Users',
                    [
                        'only' => [
                            'index',
                        ],
                        'actions' => [
                            'index' => 'get-users',
                        ],
                    ]
                );

                // $routes->connect(
                //     '/combat-encounters',
                //     [
                //         'controller' => 'CombatEncounters',
                //         'action' => 'add',
                //         // 'prefix' => 'api',
                //     ]);
            }
        );

        $routes->connect(
            '/api/v1/tag-mentions',
            [
                'prefix' => 'Api/V1',
                'controller' => 'TagMentions',
                'action' => 'get'
            ],
            ['_name' => 'tagmentions']
        );
        /**
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, src/Template/Pages/home.ctp)...
         */
        $routes->connect(
            '/',
            [
                'controller' => 'Pages',
                'action'     => 'display',
                'home',
            ]
        );

        $routes->connect(
            '/login',
            ['controller' => 'Users', 'action' => 'login'],
            ['_name' => 'login']
        );

        $routes->connect(
            '/users/register',
            ['controller' => 'Users', 'action' => 'add'],
            ['_name' => 'register']
        );

        $routes->connect(
            '/logout',
            ['controller' => 'Users', 'action' => 'logout'],
            ['_name' => 'logout']
        );

        /**
         * START Campaigns and Timeline Segments
         */

        $routes->connect(
            '/timeline-segments/{action}/{id}',
            [
                'controller' => 'TimelineSegments',
            ]
        )
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        // $routes->connect(
        //     '/timeline-segments/delete/{id}',
        //     [
        //         'action'     => 'delete',
        //         'controller' => 'TimelineSegments',
        //     ],
        //     [
        //         '_name' => 'TimelineSegmentsDelete',
        //     ]
        // )
        //     ->setMethods(['POST','DELETE'])
        //     ->setPatterns(['id' => '\d+'])
        //     ->setPass(['id']);

        // $routes->connect(
        //     '/campaigns/{campaignId}/timeline-segments',
        //     [
        //         'action'     => 'index',
        //         'controller' => 'TimelineSegments',
        //     ],
        //     [
        //         '_name' => 'TimelineSegmentsIndex',
        //     ]
        // )
        //     ->setMethods(['GET'])
        //     ->setPatterns(['campaignId' => '\d*'])
        //     ->setPass(['campaignId']);
        //
        // $routes->connect(
        //     '/campaigns/{campaignId}/timeline-segments/{action}/{id}',
        //     [
        //         'controller' => 'TimelineSegments',
        //     ],
        //     [
        //         '_name' => 'TimelineSegmentsId',
        //     ]
        // )
        //     ->setPatterns(['campaignId' => '\d*'])
        //     ->setPatterns(['id' => '\d*'])
        //     ->setPass(
        //         [
        //             'campaignId',
        //             'id',
        //         ]
        //     );
        //
        // $routes->connect(
        //     '/campaigns/{campaignId}/timeline-segments/{action}',
        //     [
        //         'controller' => 'TimelineSegments',
        //     ],
        //     [
        //         '_name' => 'TimelineSegments',
        //     ]
        // )
        //     ->setPatterns(['campaignId' => '\d*'])
        //     ->setPass(
        //         [
        //             'campaignId',
        //         ]
        //     );

        $routes->connect(
            '/campaigns/{action}/{id}',
            [
                'controller' => 'Campaigns',
            ]
        )
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        /**
         * END Campaigns and Timeline Segments
         */

        $routes->connect(
            '/tags/{action}/{id}',
            ['controller' => 'Tags']
        )
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        $routes->connect(
            '/non-playable-characters/{action}/{id}',
            ['controller' => 'NonPlayableCharacters']
        )
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        $routes->connect(
            '/puzzles/{action}/{id}',
            ['controller' => 'Puzzles']
        )
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        $routes->connect(
            '/player-characters/{action}/{id}',
            ['controller' => 'PlayerCharacters']
        )
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        $routes->connect(
            '/character-classes/{action}/{id}',
            ['controller' => 'CharactersClasses']
        )
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        $routes->connect(
            '/character-races/{action}/{id}',
            ['controller' => 'CharacterRaces']
        )
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        $routes->connect(
            '/monsters/{action}/{id}',
            ['controller' => 'Monsters']
        )
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        $routes->connect(
            '/monster-instances/{action}/{id}',
            ['controller' => 'MonsterInstances']
        )
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        $routes->connect(
            '/combat-encounters/{action}/{id}',
            ['controller' => 'CombatEncounters']
        )
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        $routes->connect(
            '/clans/{action}/{id}',
            ['controller' => 'Clans']
        )
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        $routes->connect(
            '/participants/{action}/{id}',
            ['controller' => 'Participants']
        )
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);

        /**
         * Connect catchall routes for all controllers.
         *
         * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
         *    `$routes->connect('/{controller}', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
         *    `$routes->connect('/{controller}/{action}/*', [], ['routeClass' => 'DashedRoute']);`
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
    }
);

// Router::extensions('json');

// New route we're adding for our tagged action.
// The trailing `*` tells CakePHP that this action has
// passed parameters.
// Router::scope(
//     '/timeline-segments/',
//     ['controller' => 'TimelineSegments'],
//     function ($routes) {
//         $routes->connect('/tagged/*', ['action' => 'tags']);
//         $routes->connect('/segments/*', ['action' => 'segments']);
//     }
// );
