<?php

namespace CoreShop\Bundle\ResourceBundle\Controller;

use CoreShop\Component\Resource\Model\ResourceInterface;
use CoreShop\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RouterInterface;

final class RedirectHandler implements RedirectHandlerInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function redirectToResource(RequestConfiguration $configuration, ResourceInterface $resource)
    {
        try {
            return $this->redirectToRoute(
                $configuration,
                $configuration->getRedirectRoute(ResourceActions::SHOW),
                $configuration->getRedirectParameters($resource)
            );
        } catch (RouteNotFoundException $exception) {
            return $this->redirectToRoute(
                $configuration,
                $configuration->getRedirectRoute(ResourceActions::INDEX),
                $configuration->getRedirectParameters($resource)
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function redirectToIndex(RequestConfiguration $configuration, ResourceInterface $resource = null)
    {
        return $this->redirectToRoute(
            $configuration,
            $configuration->getRedirectRoute('index'),
            $configuration->getRedirectParameters($resource)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function redirectToRoute(RequestConfiguration $configuration, $route, array $parameters = [])
    {
        if ('referer' === $route) {
            return $this->redirectToReferer($configuration);
        }

        return $this->redirect($configuration, $this->router->generate($route, $parameters));
    }

    /**
     * {@inheritdoc}
     */
    public function redirect(RequestConfiguration $configuration, $url, $status = 302)
    {
        if ($configuration->isHeaderRedirection()) {
            return new Response('', 200, [
                'X-SYLIUS-LOCATION' => $url.$configuration->getRedirectHash(),
            ]);
        }

        return new RedirectResponse($url.$configuration->getRedirectHash(), $status);
    }

    /**
     * {@inheritdoc}
     */
    public function redirectToReferer(RequestConfiguration $configuration)
    {
        return $this->redirect($configuration, $configuration->getRedirectReferer());
    }
}
