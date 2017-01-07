## Equip Twig

[![Latest Stable Version](https://poser.pugx.org/alexmasterov/equip-twig/v/1.0)](https://packagist.org/packages/alexmasterov/equip-twig)
[![License](https://img.shields.io/packagist/l/alexmasterov/equip-twig.svg)](https://github.com/AlexMasterov/equip-twig/blob/1.0/LICENSE)
[![Build Status](https://travis-ci.org/AlexMasterov/equip-twig.svg)](https://travis-ci.org/AlexMasterov/equip-twig)
[![Code Coverage](https://scrutinizer-ci.com/g/AlexMasterov/equip-twig/badges/coverage.png?b=1.0)](https://scrutinizer-ci.com/g/AlexMasterov/equip-twig/?branch=1.0)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/AlexMasterov/equip-twig/badges/quality-score.png?b=1.0)](https://scrutinizer-ci.com/g/AlexMasterov/equip-twig/?branch=1.0)

The [Twig](http://twig.sensiolabs.org/) integration for the [Equip](http://equip.github.io/).

## Installation

The suggested installation method is via [composer](https://getcomposer.org/):

```sh
composer require alexmasterov/equip-twig
```

## Configuration
To use the [`TwigFormatter`](https://github.com/AlexMasterov/equip-twig/blob/master/src/TwigFormatter.php) implementation you need to add [`TwigResponderConfiguration`](https://github.com/AlexMasterov/equip-twig/blob/1.0/src/Configuration/TwigResponderConfiguration.php) into the [application bootstrap](https://equipframework.readthedocs.org/en/latest/#bootstrap):
```php
Equip\Application::build()
->setConfiguration([
    // ...
    AlexMasterov\EquipTwig\Configuration\TwigResponderConfiguration::class
])
// ...
```
### Setting up the Twig environment:
[Default configuration](https://github.com/equip/framework/blob/master/docs/index.md#dependency-injection-container), via dependency injector:
```php
// src/Configuration/TwigConfiguration.php
namespace Acme\Configuration;

use Auryn\Injector;
use Equip\Env;
use Equip\Configuration\ConfigurationInterface;
use AlexMasterov\EquipTwig\Configuration\TwigResponderConfiguration;

class TwigConfiguration implements ConfigurationInterface
{
    public function apply(Injector $injector)
    {
        $twigEnv = new Env([
                'TWIG_TEMPLATES'        => __DIR__.'/../Resources/templates',
                'TWIG_CACHE'            => __DIR__.'/../../var/cache/twig',
                'TWIG_DEBUG'            => false,
                'TWIG_AUTO_RELOAD'      => true,
                'TWIG_STRICT_VARIABLES' => false
            ]);

        $injector->define(TwigResponderConfiguration::class, [
            ':env' => $twigEnv
        ]);
    }
}
```
```php
Equip\Application::build()
->setConfiguration([
    // ...
    Acme\Configuration\TwigConfiguration::class,
    AlexMasterov\EquipTwig\Configuration\TwigResponderConfiguration::class
])
// ...
```
[Optional configuration](https://github.com/equip/framework/blob/legacy-1.0/docs/index.md#setting-the-env-file), via a `.env` file:
```shell
TWIG_TEMPLATES = "../Resources/templates"
TWIG_CACHE = "../var/cache/twig"
TWIG_DEBUG = false
TWIG_AUTO_RELOAD = true
TWIG_STRICT_VARIABLES = false
```
### Extensions
[`TwigDefaultExtension`](https://github.com/AlexMasterov/equip-twig/blob/1.0/src/Configuration/TwigDefaultExtension.php) — provides a Equip specific extensions.

| Variable   | Description                                                       |
|------------|-------------------------------------------------------------------|
| [`session`](https://github.com/equip/framework/blob/legacy-1.0/docs/session.md#usage) | Provides access to an object instance of [`SessionInterface`]( https://github.com/equip/session/blob/legacy-1.0/src/SessionInterface.php)

### Adding extensions
The easiest way to add an extensions is by using the [`TwigExtensionSet`](https://github.com/AlexMasterov/equip-twig/blob/1.0/src/Configuration/TwigExtensionSet.php) as in the example below:
```php
// src/Configuration/ExtraTwigExtension.php
namespace Acme\Configuration;

use AlexMasterov\EquipTwig\Configuration\TwigExtensionSet;
use AlexMasterov\EquipTwig\Configuration\TwigDefaultExtension;

class ExtraTwigExtension extends TwigExtensionSet
{
    public function __construct()
    {
        $defaults = (new TwigDefaultExtension)->toArray();
        $extra = [
            AwesomeExtension::class,
            AmazingExtension::class
        ];

        parent::__construct(array_merge($defaults, $extra));
    }
}
```
```php
Equip\Application::build()
->setConfiguration([
    // ...
    AlexMasterov\EquipTwig\Configuration\TwigResponderConfiguration::class,
    Acme\Configuration\ExtraTwigExtension::class
])
// ...
```
It\`s also possible to expand [`TwigDefaultExtension`](https://github.com/AlexMasterov/equip-twig/blob/master/src/Configuration/TwigDefaultExtension.php) following example of the [Default configuration](#setting-up-the-twig-environment):
```php
// ...
use AlexMasterov\EquipTwig\Configuration\TwigDefaultExtension;

class TwigConfiguration implements ConfigurationInterface
{
   public function apply(Injector $injector)
    {
        // ...
        $extensions = [
            AwesomeExtension::class,
            AmazingExtension::class
        ];

        $injector->define(TwigDefaultExtension::class, [
            ':extensions' => $extensions
        ]);
    }
}
```
## Usage
Basic example:
```php
namespace Acme\Domain;

use Equip\Adr\DomainInterface;
use Equip\Adr\PayloadInterface;

class WidgetDomain implements DomainInterface
{
    /**
     * @var PayloadInterface
     */
    private $payload;

    public function __construct(PayloadInterface $payload)
    {
        $this->payload = $payload;
    }

    public function __invoke(array $input)
    {
        return $this->payload
            ->withStatus(PayloadInterface::STATUS_OK)
            ->withOutput([
                'template' => 'widget.html.twig',
                'message' => 'Just do it!'
            ]);
    }
}
```

Using [`PayloadRenderTrait`](https://github.com/AlexMasterov/equip-twig/blob/1.0/src/Traits/PayloadRenderTrait.php) as wrapper for the usual `render` method:
```php
// ...
use AlexMasterov\EquipTwig\Traits\PayloadRenderTrait;

class WidgetDomain implements DomainInterface
{
    use PayloadRenderTrait;

    public function __invoke(array $input)
    {
        $message = 'Just do it!';
        return $this->render('widget.html.twig', compact('message'));
    }
}
```
