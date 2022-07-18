<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxExtendedShopwareLogging\Subscriber;

use Enlight\Event\SubscriberInterface;
use nlxExtendedShopwareLogging\Services\LoggerService;

class RoutingSubscriber implements SubscriberInterface
{
    /** @var LoggerService */
    private $logger;

    public function __construct(
        LoggerService $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'onPreDispatch',
            'Enlight_Controller_Action_PostDispatchSecure' => 'onPostDispatch',
        ];
    }

    public function onPreDispatch(\Enlight_Controller_ActionEventArgs $args): void
    {
        $this->logRequestResponse('PreDispatch', $args->get('subject'));
    }

    public function onPostDispatch(\Enlight_Controller_ActionEventArgs $eventArgs): void
    {
        $this->logRequestResponse('PostDispatchSecure', $eventArgs->getSubject());
    }

    private function logRedirect(
        \Enlight_Controller_Router $router,
        \Enlight_Controller_Request_RequestHttp $request,
        \Enlight_Controller_Response_ResponseHttp $response
    ): void {
        if ($response->isException()
            || $request->isPost()
            || $request->isXmlHttpRequest()             // is a ajax call
            || $request->has('callback')                // is a jsonp call
            || 'frontend' != $request->getModuleName()  // is not frontend
            || !$request->getParam('rewriteAlias')      // is not a rewrite url alias
        ) {
            return;
        }

        $query = $request->getQuery();
        $location = $router->assemble($query);

        // Fix shop redirect / if it's not a seo url
        if (\preg_match('#\/[0-9]+$#', $location, $match) > 0) {
            $location = $request->getBaseUrl() . '/';
        }

        $current = $request->getScheme() . '://' . $request->getHttpHost() . $request->getRequestUri();
        if ($location !== $current) {
            $this->logger->basic('Shopware internal Redirect: 301', [
                'from' => $current,
                'to'   => $location,
            ]);
        }
    }

    private function logRequestResponse(
        string $logTitle,
        \Enlight_Controller_Action $controller
    ): void {
        $request = $controller->Request();
        $response = $controller->Response();
        $router = $controller->Front()->Router();

        if ($response->isRedirection()) {
            $this->logRedirect($router, $request, $response);
        }

        $this->logger->basic(\sprintf('%s: %s', $logTitle, $response->getHttpResponseCode()), [
            'request' => [
                'url' => $request->getUri(),
                'controller' => $request->getControllerName(),
                'controllerAction' => $request->getActionName(),
                'parameters' => $request->getParams(),
                'cookies' => $request->getCookie(),
            ],
            'response' => [
                'headers' => $response->getHeaders(),
                'cookies' => $response->getCookies(),
                'responseCode' => $response->getHttpResponseCode(),
            ],
        ]);
    }
}
