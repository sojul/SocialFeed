<?php

namespace spec\Lns\SocialFeed\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InstagramPostFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Factory\InstagramPostFactory');
    }

    function it_should_implement_post_factory_interface()
    {
        $this->shouldImplement('Lns\SocialFeed\Factory\PostFactoryInterface');
    }

    function it_should_create_a_post_from_instagram_api_date() {
        $this->create($this->getSampleInstagramPostData())->shouldImplement('Lns\SocialFeed\Model\PostInterface');
    }

    private function getSampleInstagramPostData() {
        return array (
            'attribution' => NULL,
            'tags' => 
            array (
                0 => 'beautiful',
                1 => 'cute',
                2 => 'eyes',
                3 => 'fashion',
                4 => 'love',
                5 => 'shoes',
                6 => 'beauty',
                7 => 'nails',
                8 => 'purse',
                9 => 'swag',
                10 => 'outfit',
                11 => 'hair',
                12 => 'me',
                13 => 'design',
                14 => 'glam',
                15 => 'heels',
                16 => 'shopping',
                17 => 'girl',
                18 => 'dress',
                19 => 'pink',
                20 => 'style',
                21 => 'jewelry',
                22 => 'girls',
                23 => 'instagood',
                24 => 'tagsforlikes',
                25 => 'pretty',
                26 => 'styles',
                27 => 'stylish',
                28 => 'model',
                29 => 'photooftheday',
            ),
            'location' => NULL,
            'comments' => 
            array (
                'count' => 0,
                'data' => 
                array (
                ),
            ),
            'filter' => 'Juno',
            'created_time' => '1435594208',
            'link' => 'https://instagram.com/p/4hO45BDk6j/',
            'likes' => 
            array (
                'count' => 0,
                'data' => 
                array (
                ),
            ),
            'images' => 
            array (
                'low_resolution' => 
                array (
                    'url' => 'https://scontent.cdninstagram.com/hphotos-xfa1/t51.2885-15/s320x320/e15/11249129_467904793368491_506172554_n.jpg',
                    'width' => 320,
                    'height' => 320,
                ),
                'thumbnail' => 
                array (
                    'url' => 'https://scontent.cdninstagram.com/hphotos-xfa1/t51.2885-15/s150x150/e15/11249129_467904793368491_506172554_n.jpg',
                    'width' => 150,
                    'height' => 150,
                ),
                'standard_resolution' => 
                array (
                    'url' => 'https://scontent.cdninstagram.com/hphotos-xfa1/t51.2885-15/e15/11249129_467904793368491_506172554_n.jpg',
                    'width' => 640,
                    'height' => 640,
                ),
            ),
            'users_in_photo' => 
            array (
            ),
            'caption' => 
            array (
                'created_time' => '1435614461',
                'text' => '#fashion #style #stylish #love #TagsForLikes.com #me #cute #photooftheday #nails #hair #beauty #beautiful #instagood #pretty #swag #pink #girl #girls #eyes #design #model #dress #shoes #heels #styles #outfit #purse #jewelry #shopping #glam',
                'from' => 
                array (
                    'username' => 'josefineshop',
                    'profile_picture' => 'https://igcdn-photos-a-a.akamaihd.net/hphotos-ak-xpa1/t51.2885-19/10852760_355385254645952_1040477790_a.jpg',
                    'id' => '1624545914',
                    'full_name' => 'josefine',
                ),
                'id' => '1018160474502352751',
            ),
            'type' => 'image',
            'id' => '1018160472925294243_1624545914',
            'user' => 
            array (
                'username' => 'josefineshop',
                'profile_picture' => 'https://igcdn-photos-a-a.akamaihd.net/hphotos-ak-xpa1/t51.2885-19/10852760_355385254645952_1040477790_a.jpg',
                'id' => '1624545914',
                'full_name' => 'josefine',
            ),
        );
    }
}
