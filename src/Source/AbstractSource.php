<?php

namespace Lns\SocialFeed\Source;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Exception as OptionsResolverException;
use Lns\SocialFeed\Exception as SocialFeedException;

abstract class AbstractSource implements SourceInterface
{
    protected function resolveOptions($options) {
        $resolver = new OptionsResolver();

        $this->configureOptionResolver($resolver);

        try {

            return $resolver->resolve($options);

        } catch (OptionsResolverException\MissingOptionsException $e) {
            throw new SocialFeedException\MissingOptionsException($e->getMessage(), $e->getCode(), $e);
        }
    }

    protected function configureOptionResolver(OptionsResolver &$resolver) {
    }
}
