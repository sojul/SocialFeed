<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lns\SocialFeed\Provider;

use Lns\SocialFeed\Exception as SocialFeedException;
use Symfony\Component\OptionsResolver\Exception as OptionsResolverException;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractProvider implements ProviderInterface
{
    protected function resolveOptions($options)
    {
        $resolver = new OptionsResolver();

        $this->configureOptionResolver($resolver);

        try {
            return $resolver->resolve($options);
        } catch (OptionsResolverException\MissingOptionsException $e) {
            throw new SocialFeedException\MissingOptionsException($e->getMessage(), $e->getCode(), $e);
        }
    }

    protected function configureOptionResolver(OptionsResolver &$resolver)
    {
    }

    protected function extractUrlParameters($url)
    {
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $params);

        return $params;
    }
}
