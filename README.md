## Equip Twig

[![Latest Stable Version](https://poser.pugx.org/asmaster/equip-twig/v/stable)](https://packagist.org/packages/asmaster/equip-twig)
[![License](https://img.shields.io/packagist/l/asmaster/equip-twig.svg)](https://github.com/AlexMasterov/equip-twig/blob/master/LICENSE)
[![Build Status](https://travis-ci.org/AlexMasterov/equip-twig.svg)](https://travis-ci.org/AlexMasterov/equip-twig)
[![Code Coverage](https://scrutinizer-ci.com/g/AlexMasterov/equip-twig/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/AlexMasterov/equip-twig/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/AlexMasterov/equip-twig/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/AlexMasterov/equip-twig/?branch=master)

The [Twig](http://twig.sensiolabs.org/) integration for the [Equip](http://equip.github.io/).

## Installation

The suggested installation method is via [composer](https://getcomposer.org/):

```sh
composer require asmaster/equip-twig
```

## Configuration
To use the [`TwigFormatter`](https://github.com/AlexMasterov/equip-twig/blob/master/src/TwigFormatter.php) implementation you need to add [`TwigResponderConfiguration`](https://github.com/AlexMasterov/equip-twig/blob/master/src/Configuration/TwigResponderConfiguration.php) into the [application bootstrap](https://equipframework.readthedocs.org/en/latest/#bootstrap):
```php
Equip\Application::build()
->setConfiguration([
    // ...
    Asmaster\EquipTwig\Configuration\TwigResponderConfiguration::class
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
use Asmaster\EquipTwig\Configuration\TwigResponderConfiguration;

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
    Asmaster\EquipTwig\Configuration\TwigResponderConfiguration::class
])
// ...
```
[Optional configuration](https://github.com/equip/framework/blob/master/docs/index.md#setting-the-env-file), via a `.env` file:
```shell
TWIG_TEMPLATES = "../Resources/templates"
TWIG_CACHE = "../var/cache/twig"
TWIG_DEBUG = false
TWIG_AUTO_RELOAD = true
TWIG_STRICT_VARIABLES = false
```
### Extensions
[`TwigDefaultExtension`](https://github.com/AlexMasterov/equip-twig/blob/master/src/Configuration/TwigDefaultExtension.php) — provides a Equip specific extensions.

| Variable   | Description                                                       |
|------------|-------------------------------------------------------------------|
| [`session`](https://github.com/equip/framework/blob/master/docs/session.md#usage) | Provides access to an object instance of [`SessionInterface`]( https://github.com/equip/session/blob/master/src/SessionInterface.php)

### Adding extensions
The easiest way to add an extensions is by using the [`TwigExtensionSet`](https://github.com/AlexMasterov/equip-twig/blob/master/src/Configuration/TwigExtensionSet.php) as in the example below:
```php
// src/Configuration/ExtraTwigExtension.php
namespace Acme\Configuration;

use Asmaster\EquipTwig\Configuration\TwigExtensionSet;
use Asmaster\EquipTwig\Configuration\TwigDefaultExtension;

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
    Asmaster\EquipTwig\Configuration\TwigResponderConfiguration::class,
    Acme\Configuration\ExtraTwigExtension::class
])
// ...
```
It\`s also possible to expand [`TwigDefaultExtension`](https://github.com/AlexMasterov/equip-twig/blob/master/src/Configuration/TwigDefaultExtension.php) following example of the [Default configuration](#setting-up-the-twig-environment):
```php
// ...
use Asmaster\EquipTwig\Configuration\TwigDefaultExtension;

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
            ->withSetting('template', 'widget.html.twig')
            ->withOutput([
                'message' => 'Just do it!'
            ]);
    }
}
```

Using [`PayloadRenderTrait`](https://github.com/AlexMasterov/equip-twig/blob/master/src/Traits/PayloadRenderTrait.php) as wrapper for the usual `render` method:
```php
// ...
use Asmaster\EquipTwig\Traits\PayloadRenderTrait;

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
