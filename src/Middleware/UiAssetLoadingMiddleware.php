<?php

// declare(strict_types=1);

// namespace App\Middleware;

// use Cake\Routing\Middleware\AssetMiddleware;
// use Psr\Http\Message\ResponseInterface;
// use Psr\Http\Message\ServerRequestInterface;
// use Psr\Http\Server\MiddlewareInterface;
// use Psr\Http\Server\RequestHandlerInterface;
// use SplFileInfo;
// use Cake\Http\Response;

// class UiAssetLoadingMiddleware extends AssetMiddleware implements MiddlewareInterface
// {
//     public function process(
//         ServerRequestInterface $request,
//         RequestHandlerInterface $handler
//     ): ResponseInterface {
//         $path = $request->getUri()->getPath();

//         if (str_contains($path, '/ui/assets')) {
//             dd('going through cakephp');
//             $file = new SplFileInfo(
//                 WWW_ROOT . str_replace('/ui/assets', 'ui/dist/assets', $path)
//             );
//             $modifiedTime = $file->getMTime();
//             if ($this->isNotModified($request, $file)) {
//                 return (new Response())
//                     ->withStringBody('')
//                     ->withStatus(304)
//                     ->withHeader(
//                         'Last-Modified',
//                         date(DATE_RFC850, $modifiedTime)
//                     );
//             }
//             return $this->deliverAsset($request, $file);
//         }

//         return $handler->handle($request);
//     }
// }
