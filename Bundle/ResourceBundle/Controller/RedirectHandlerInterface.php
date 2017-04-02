<?php

namespace CoreShop\Bundle\ResourceBundle\Controller;

use CoreShop\Component\Resource\Model\ResourceInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
interface RedirectHandlerInterface
{
    /**
     * @param RequestConfiguration $configuration
     * @param ResourceInterface $resource
     *
     * @return RedirectResponse
     */
    public function redirectToResource(RequestConfiguration $configuration, ResourceInterface $resource);

    /**
     * @param RequestConfiguration $configuration
     * @param null|ResourceInterface $resource
     *
     * @return RedirectResponse
     */
    public function redirectToIndex(RequestConfiguration $configuration, ResourceInterface $resource = null);

    /**
     * @param RequestConfiguration $configuration
     * @param string               $route
     * @param array                $parameters
     *
     * @return RedirectResponse
     */
    public function redirectToRoute(RequestConfiguration $configuration, $route, array $parameters = []);

    /**
     * @param RequestConfiguration $configuration
     * @param $url
     * @param int $status
     *
     * @return RedirectResponse
     */
    public function redirect(RequestConfiguration $configuration, $url, $status = 302);

    /**
     * @param RequestConfiguration $configuration
     *
     * @return RedirectResponse
     */
    public function redirectToReferer(RequestConfiguration $configuration);
}
