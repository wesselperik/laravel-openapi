<?php

namespace Vyuldashev\LaravelOpenApi\Annotations;

use Doctrine\Common\Annotations\Annotation\Required;
use InvalidArgumentException;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

/**
 * @Annotation
 *
 * @Target({"METHOD"})
 */
class SecurityScheme
{
    /**
     * @Required()
     */
    public $factory;

    public function __construct($values)
    {
        $this->factory = class_exists($values['factory']) ? $values['factory'] : app()->getNamespace().'OpenApi\\SecuritySchemes\\'.$values['factory'];

        if (! is_a($this->factory, SecuritySchemeFactory::class, true)) {
            throw new InvalidArgumentException('Factory class must be instance of SecuritySchemeFactory');
        }
    }
}
