<?php

namespace Lns\SocialFeed\Model;

use CommerceGuys\Enum\AbstractEnum;

class ReferenceType extends AbstractEnum
{
    const URL         = 'url';
    const USER        = 'user';
    const PAGE        = 'page';
    const GROUP       = 'group';
    const HASHTAG     = 'hashtag';
    const VIDEO       = 'video';
    const MEDIA       = 'media';
    const APPLICATION = 'application';
}
