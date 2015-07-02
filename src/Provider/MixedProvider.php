<?php

namespace Lns\SocialFeed\Provider;

use Lns\SocialFeed\Model\Feed;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MixedProvider extends AbstractProvider
{
    protected $providers = array();

    /**
     * addProvider
     *
     * @param string $providerId
     * @param ProviderInterface $provider
     */
    public function addProvider($providerId, ProviderInterface $provider)
    {
        $this->providers[$providerId] = $provider;
        return $this;
    }

    public function getFeed(array $options = array()) {
        $feed = new Feed();

        $this->options = $this->resolveOptions($options);

        foreach($this->providers as $providerId => $provider) {
            $feed->merge($provider->getFeed($options[$providerId]));
        }

        return $feed->sort();
    }

    protected function configureOptionResolver(OptionsResolver &$resolver) {
        foreach($this->providers as $providerId => $provider) {
            $resolver->setRequired($providerId);
        }
    }
}
