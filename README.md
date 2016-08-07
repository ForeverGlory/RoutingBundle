Routing Bundle
======

Use alias path to access the original Controller

使用别名路径访问原始Controller

###Usage
```sh
composer require foreverglory/routing-bundle
```
###AppKernel
```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles[] = new Glory\Bundle\RoutingBundle\GloryRoutingBundle();
    }
}
```
###Configure
routing config `routing.yml`
```yaml
homepage:
    path: /homepage
    defaults: { _controller: AppBundle:Default:index }
newpage:
    path: /new
    defaults: { _alias: homepage }
```

###Code
```php
//generate alias url
$url = $container->get('router')->generate('homepage');
//$url: /new
```
```twig
{{path("homepage")}}
```