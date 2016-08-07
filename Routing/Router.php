<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\RoutingBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\Router as BaseRouter;

/**
 * Description of Router
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class Router extends BaseRouter
{

    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        foreach ($this->getRouteCollection()->all() as $routeName => $route) {
            if ($name == $route->getDefault('_alias')) {
                return parent::generate($routeName, $parameters, $referenceType);
            }
        }
        return parent::generate($name, $parameters, $referenceType);
    }

}
