<?php

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
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App;

use App\Middleware\HttpOptionsMiddleware;
use App\Model\Table\UsersTable;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Core\Configure;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Client;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceInterface;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Middleware\AuthorizationMiddleware;
use Authorization\Policy\OrmResolver;
use League\Container\ReflectionContainer;
use Psr\Http\Message\ServerRequestInterface;
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Identifier\AbstractIdentifier;
use Cake\Controller\ComponentRegistry;
use Cake\Core\ContainerInterface;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use DateTime;
use DateTimeImmutable;
use Firebase\JWT\JWT;
use Cake\Http\Middleware\CsrfProtectionMiddleware;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication implements AuthenticationServiceProviderInterface, AuthorizationServiceProviderInterface
{
    public const SESSION_KEY_CAMPAIGN = 'User.Campaign';

    /**
     * {@inheritDoc}
     */
    public function bootstrap(): void
    {
        // Call parent to load bootstrap from files.
        parent::bootstrap();

        $this->addPlugin('Migrations');
        $this->addPlugin('Authorization');
        /*
         * Only try to load DebugKit in development mode
         * Debug Kit should not be installed on a production system
         */
        if (Configure::read('debug')) {
            $this->addPlugin('DebugKit', ['bootstrap' => false]);
        }
        $csrfDisableParam = isset($_GET['disableCsrf'])
            && ($_GET['disableCsrf'] === '1' || $_GET['disableCsrf'] === 1 || $_GET['disableCsrf'] === 'true'  || $_GET['disableCsrf'] === true);

        Configure::write(
            'enableCsrf',
            env('ENV_LEVEL', 'production') === 'production'
                || !$csrfDisableParam
        );
    }

    public function routes(RouteBuilder $routes): void
    {
        if (Configure::read('enableCsrf')) {
            $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
                'secure' => true,
                'samesite' => 'Strict',
                'httponly' => true,
            ]));
        }

        parent::routes($routes);
    }

    /**
     * Setup the middleware queue your application will use.
     *
     * @param MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return MiddlewareQueue The updated middleware queue.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            // Catch any exceptions in the lower layers,
            // and make an error page/response
            ->add(new ErrorHandlerMiddleware(Configure::read('Error')))

            // Handle plugin/theme assets like CakePHP normally does.
            ->add(AssetMiddleware::class)

            // Handle the UI assets rather than letting them go through to the routes
            // ->add(UiAssetLoadingMiddleware::class)

            // Add routing middleware.
            // Routes collection cache enabled by default, to disable route caching
            // pass null as cacheConfig, example: `new RoutingMiddleware($this)`
            // you might want to disable this cache in case your routing is extremely simple
            ->add(new RoutingMiddleware($this))
            ->add(new BodyParserMiddleware())

            // CakePHP doesn't seem to handle OPTIONS requests to the API very well and instead
            // returns errors, so we need to intercept them with this middleware to return back
            // 200 OK responses
            ->add(HttpOptionsMiddleware::class)

            // If you are using Authentication it should be *before* Authorization.
            ->add(new AuthenticationMiddleware($this))

            // Add the AuthorizationMiddleware *after* routing, body parser
            // and authentication middleware.
            ->add(new AuthorizationMiddleware($this));

        return $middlewareQueue;
    }

    public function services(ContainerInterface $container): void
    {
        $container->add(ComponentRegistry::class);
        $container->delegate(new ReflectionContainer(cacheResolutions: true));
    }

    /**
     * Returns a service provider instance.
     *
     * @param ServerRequestInterface $request Request
     *
     * @return AuthenticationServiceInterface
     */
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService();

        $uri = $request->getUri()->getPath();

        if (strpos($uri, '/api') === 0) {
            $service->loadIdentifier('Authentication.JwtSubject', [
                'tokenField' => 'external_user_id',
                'resolver' => [
                    'className' => 'Authentication.Orm',
                    'userModel' => UsersTable::TABLE_NAME,
                    'finder' => 'auth',
                ],
            ]);
            $service->loadAuthenticator('Authentication.Jwt', [
                'jwks' => $this->getSecretKeys(),
                'algorithm' => 'RS256',
                'returnPayload' => false,
                'header' => 'Authorization',
                'queryParam' => null,
                'tokenPrefix' => 'Bearer',
            ]);

            return $service;
        }

        // Define where users should be redirected to when they are not authenticated
        $service->setConfig([
            'unauthenticatedRedirect' => Router::url([
                'prefix'     => false,
                'plugin'     => null,
                'controller' => 'Pages',
                'action'     => 'display',
            ]),
            'queryParam'              => 'redirect',
        ]);

        $fields = [
            AbstractIdentifier::CREDENTIAL_USERNAME => 'username',
            AbstractIdentifier::CREDENTIAL_PASSWORD => 'password',
        ];

        // Session should always come before the form
        $service->loadAuthenticator('Authentication.Session');
        $service->loadAuthenticator('Authentication.Form', [
            'fields'   => $fields,
            'loginUrl' => Router::url([
                'prefix'     => false,
                'plugin'     => null,
                'controller' => 'Pages',
                'action'     => 'display',
            ]),
        ]);

        // Load identifiers
        $service->loadIdentifier('Authentication.Password', compact('fields'));

        return $service;
    }

    public function getAuthorizationService(ServerRequestInterface $request): AuthorizationServiceInterface
    {
        $resolver = new OrmResolver();

        return new AuthorizationService($resolver);
    }

    private function getSecretKeys(): array
    {
        if (env('ENV_LEVEL', 'production') === 'development-integration-test') {
            $publicKey = file_get_contents(CONFIG_KEYS . 'firebase/jwt.public.test.pem');

            return $this->createJwks(publicKeys: [env('TEST_AUTH_KID', '') => $publicKey]);
        }

        $keyExpiration = json_decode(file_get_contents(CONFIG_KEYS . 'firebase/jwt-config.json'), true);
        $keyExpirationDateTime = unserialize($keyExpiration['time'] ?? '') ?: new DateTime();
        $currentDateTime = new DateTime();

        if ($keyExpirationDateTime <= $currentDateTime) {
            $jwks = $this->getJwks();
            $keys = $jwks['keys'];
            $expiryTime = $jwks['expiry'];

            file_put_contents(
                CONFIG_KEYS . 'firebase/jwt-config.json',
                json_encode(
                    [
                        'time' => serialize($expiryTime),
                    ]
                )
            );
            file_put_contents(CONFIG_KEYS . 'firebase/jwks.json', json_encode($keys, JSON_OBJECT_AS_ARRAY));
        } else {
            $keys = json_decode(file_get_contents(CONFIG_KEYS . 'firebase/jwks.json'), true);
        }

        return $keys;
    }

    private function getJwks(): array
    {
        $client = new Client();
        $response = $client->get(
            'https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com'
        );
        $googleKeys = $response->getJson();
        preg_match(
            pattern: '/max-age\=(\d+)/',
            subject: $response->getHeaderLine('Cache-Control') ?: '',
            matches: $cacheControlHeader
        );
        $maxAgeInSeconds = (int) $cacheControlHeader[1];
        $expiryTime = (new DateTimeImmutable())->modify('+' . ($maxAgeInSeconds - 30) . ' seconds');

        $keys = $this->createJwks(publicKeys: $googleKeys);

        return ['keys' => $keys, 'expiry' => $expiryTime];
    }

    private function createJwks(array $publicKeys): array
    {
        $defaultConfig = [
            'use' => 'sig',
            'kty' => 'RSA',
            'alg' => 'RS256',
        ];

        $keys = ['keys' => []];
        foreach ($publicKeys as $kid => $key) {
            $res = openssl_pkey_get_public($key);
            $detail = openssl_pkey_get_details($res);
            $keys['keys'][] = [
                ...$defaultConfig,
                'kid' => $kid,
                'e' => JWT::urlsafeB64Encode($detail['rsa']['e']),
                'n' => JWT::urlsafeB64Encode($detail['rsa']['n']),
            ];
        }

        return $keys;
    }
}
