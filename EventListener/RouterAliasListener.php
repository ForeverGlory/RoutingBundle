<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\RoutingBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Description of RoutAliasListener
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class RouterAliasListener implements EventSubscriberInterface
{

    /**
     * @var RouterInterface 
     */
    protected $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                'onKernelRequest', 30
            ]
        ];
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->attributes->has('_alias')) {
            return;
        }
        $routeName = $request->attributes->get('_alias');

        $route = $this->router->getRouteCollection()->get($routeName);
        if ($defaults = $route->getDefaults()) {
            //$request->attributes->set('_route', $routeName);
            $request->attributes->set('_controller', $defaults['_controller']);
        } else {
            $message = sprintf('No alias found for "%s %s"', $request->getMethod(), $request->getPathInfo());
            throw new NotFoundHttpException($message);
        }

        $parameters = $request->attributes->get('_route_params');
        unset($parameters['_alias']);
        $request->attributes->set('_route_params', $parameters);
    }

}
