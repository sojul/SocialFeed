<?php

namespace Lns\SocialFeed\Source;

use Lns\SocialFeed\Model\Feed;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MixedSource extends AbstractSource
{
    protected $sources = array();

    /**
     * addSource
     *
     * @param string $sourceId
     * @param SourceInterface $source
     */
    public function addSource($sourceId, SourceInterface $source)
    {
        $this->sources[$sourceId] = $source;
        return $this;
    }

    public function getFeed(array $options = array()) {
        $feed = new Feed();

        $this->options = $this->resolveOptions($options);

        foreach($this->sources as $sourceId => $source) {
            $feed->merge($source->getFeed($options[$sourceId]));
        }

        return $feed->sort();
    }

    protected function configureOptionResolver(OptionsResolver &$resolver) {
        foreach($this->sources as $sourceId => $source) {
            $resolver->setRequired($sourceId);
        }
    }
}
