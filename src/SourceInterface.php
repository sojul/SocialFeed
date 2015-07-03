<?php

namespace Lns\SocialFeed;

interface SourceInterface
{
    public function getProvider();
    public function getOptions();
}
