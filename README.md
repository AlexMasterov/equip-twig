## Equip Twig

[![Latest Stable Version](https://poser.pugx.org/alexmasterov/equip-twig/v/stable)](https://packagist.org/packages/alexmasterov/equip-twig)
[![License](https://img.shields.io/packagist/l/alexmasterov/equip-twig.svg)](https://github.com/AlexMasterov/equip-twig/blob/master/LICENSE)
[![Build Status](https://travis-ci.org/AlexMasterov/equip-twig.svg)](https://travis-ci.org/AlexMasterov/equip-twig)
[![Code Coverage](https://scrutinizer-ci.com/g/AlexMasterov/equip-twig/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/AlexMasterov/equip-twig/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/AlexMasterov/equip-twig/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/AlexMasterov/equip-twig/?branch=master)

The [Twig](http://twig.sensiolabs.org/) integration for the [Equip](http://equip.github.io/).

## Installation

The suggested installation method is via [composer](https://getcomposer.org/):

```sh
composer require alexmasterov/equip-twig
```

## Configuration
To use the [`TwigFormatter`](https://github.com/AlexMasterov/equip-twig/blob/master/src/TwigFormatter.php) implementation you need to add [`TwigConfiguration`](https://github.com/AlexMasterov/equip-twig/blob/master/src/Configuration/TwigResponderConfiguration.php) into the [application bootstrap](https://equipframework.readthedocs.org/en/latest/#bootstrap):
```php
Equip\Application::build()
->setConfiguration([
    // ...
    AlexMasterov\EquipTwig\Configuration\TwigConfiguration::class
])
// ...
```
### Setting up the Twig environment:
[Optional configuration](https://github.com/equip/framework/blob/master/docs/index.md#setting-the-env-file), via a `.env` file:
```shell
TWIG_TEMPLATES = "../Resources/templates"
TWIG_CACHE = "../var/cache/twig"
TWIG_DEBUG = false
TWIG_AUTO_RELOAD = true
TWIG_STRICT_VARIABLES = false
TWIG_FILE_EXTENSIONS = "html.twig,twig"

```
[Default configuration](https://github.com/equip/framework/blob/master/docs/index.md#dependency-injection-container), via dependency injector:
```php
// src/Configuration/TwigConfiguration.php
namespace Acme\Configuration;

use Auryn\Injector;
use Equip\Env;
use Equip\Configuration\ConfigurationInterface;
use AlexMasterov\EquipTwig\Configuration\TwigConfiguration;

class TwigEnvConfiguration implements ConfigurationInterface
{
    public function apply(Injector $injector)
    {
        $twigEnv = new Env([
                'TWIG_TEMPLATES'        => __DIR__.'/../Resources/templates',
                'TWIG_CACHE'            => __DIR__.'/../../var/cache/twig',
                'TWIG_DEBUG'            => false,
                'TWIG_AUTO_RELOAD'      => true,
                'TWIG_STRICT_VARIABLES' => false,
                'TWIG_FILE_EXTENSIONS'  => 'html.twig,twig'
            ]);

        $injector->define(TwigConfiguration::class, [
            ':env' => $twigEnv
        ]);
    }
}
```
```php
Equip\Application::build()
->setConfiguration([
    // ...
    Acme\Configuration\TwigEnvConfiguration::class,
    AlexMasterov\EquipTwig\Configuration\TwigConfiguration::class
])
// ...
```
### Adding extensions
The easiest way to add an extensions is by using the [`TwigExtensionSet`](https://github.com/AlexMasterov/equip-twig/blob/master/src/Configuration/TwigExtensionSet.php) as in the example below:
```php
// src/Configuration/ExtraTwigExtension.php
namespace Acme\Configuration;

use AlexMasterov\EquipTwig\Configuration\TwigExtensionSet;

class AppTwigExtension extends TwigExtensionSet
{
    public function __construct()
    {
        parent::__construct([
            AppExtension::class
        ]);
    }
}
```
```php
Equip\Application::build()
->setConfiguration([
    // ...
    AlexMasterov\EquipTwig\Configuration\TwigConfiguration::class,
    Acme\Configuration\AppTwigExtension::class
])
// ...
```
## Usage
Basic example:
```php
namespace Acme\Action;

use AlexMasterov\EquipTwig\TwigFormatter;
use Equip\Contract\ActionInterface;

class DoItAction implements ActionInterface
{
    private $formatter;

    public function __construct(TwigFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $response = $response->withHeader('Content-Type', $formatter->type());
        $payload = $this->formatter
            ->withTemplate('doit')
            ->format([
                'message' => 'Just do it!'
            ]);

        $body = $response->getBody();
        $body->write($payload);

        return $response;
    }
}
```
