<?php

namespace Vyuldashev\LaravelOpenApi\Builders\Paths\Operation;

use Vyuldashev\LaravelOpenApi\RouteInformation;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;
use Vyuldashev\LaravelOpenApi\Annotations\SecurityScheme as SecuritySchemeAnnotation;

class SecuritySchemeBuilder
{
    public function build(RouteInformation $route): ?SecurityScheme
    {
        /** @var SecuritySchemeAnnotation|null $securityScheme */
        $securityScheme = collect($route->actionAnnotations)->first(static function ($annotation) {
            return $annotation instanceof SecuritySchemeAnnotation;
        });

        if ($securityScheme) {
            /** @var SecuritySchemeFactory $securitySchemeFactory */
            $securitySchemeFactory = app($securityScheme->factory);

            $securityScheme = $securitySchemeFactory->build();

            if ($securitySchemeFactory instanceof Reusable) {
                return SecurityScheme::ref('#/components/securitySchemes/'.$securityScheme->objectId);
            }
        }

        return $securityScheme;
    }
}
