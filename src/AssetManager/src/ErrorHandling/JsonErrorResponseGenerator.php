<?php
declare(strict_types=1);

namespace AssetManager\ErrorHandling;

use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Log\Processor\RequestId;
use Laminas\Stratigility\Utils;
use Mezzio\Response\ErrorResponseGeneratorTrait;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

/**
 *  JsonErrorResponseGenerator
 *
 * Generates error messages as json. Compare Zend\Expressive\Middleware\ErrorResponseGenerator
 */
class JsonErrorResponseGenerator
{
    use ErrorResponseGeneratorTrait;

    public const TEMPLATE_DEFAULT = 'error::error';
    public const LAYOUT_DEFAULT = 'layout::default';

    /**
     * JsonErrorResponseGenerator constructor.
     * @param bool $isDevelopmentMode
     * @param TemplateRendererInterface|null $renderer
     * @param string $template
     * @param string $layout
     */
    public function __construct(
        bool $isDevelopmentMode = false,
        TemplateRendererInterface $renderer = null,
        string $template = self::TEMPLATE_DEFAULT,
        string $layout = self::LAYOUT_DEFAULT
    ) {
        $this->debug     = $isDevelopmentMode;
    }

    /**
     * @param Throwable $e
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(
        Throwable $e,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) : ResponseInterface {
        $response = $response->withStatus(Utils::getStatusCode($e, $response));

        return $this->prepareDefaultResponse($e, $this->debug, $response);
    }

    private function prepareDefaultResponse(
        Throwable $e,
        bool $debug,
        ResponseInterface $response
    ) : ResponseInterface {
        $message = ['message' => 'An unexpected error occurred'];

        if ($debug) {
            $message['error_trail'] = "stack trace:" . $this->prepareStackTrace($e);
        }

        $req = new RequestId();
        $reqId = $req->process([])['extra']['requestId'];

        $message['error_id'] = $reqId;

        $response = new JsonResponse($message, StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);

        return $response;
    }
}
