<?php

namespace spec\Lns\SocialFeed\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Facebook\GraphObject;

class PostFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Factory\PostFactory');
    }

    function it_should_create_facebook_post_from_graph_object(GraphObject $graphObject, GraphObject $author) {
        $author->getProperty('id')->willReturn('user_1_id');
        $author->getProperty('name')->willReturn('John doe');

        $graphObject->getProperty('id')->willReturn('post_1');
        $graphObject->getProperty('message')->willReturn('Lorem ipsum');
        $graphObject->getProperty('from')->willReturn($author);
        $graphObject->getProperty('created_time')->willReturn('2015-06-27T10:05:11+0000');

        $this->createFromGraphObject($graphObject)->shouldImplement('Lns\SocialFeed\Model\PostInterface');
    }

    function it_should_create_twitter_tweet_from_twitter_api_data() {
        $this->createFromTwitterApiData($this->getSampleTweetData())->shouldImplement('Lns\SocialFeed\Model\PostInterface');
    }

    function it_should_create_a_post_from_instagram_api_date() {
        $this->createFromInstagramApiData($this->getSampleInstagramPostData())->shouldImplement('Lns\SocialFeed\Model\PostInterface');
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
                'created_time' => '1435594208',
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

    private function getSampleTweetData() {
        return array (
            'metadata' => 
            array (
                'iso_language_code' => 'ja',
                'result_type' => 'recent',
            ),
            'created_at' => 'Mon Jun 29 10:03:26 +0000 2015',
            'id' => 615460559203405824,
            'id_str' => '615460559203405824',
            'text' => '「3DMark」の新テスト「API Overhead feature test」を動かし，DX12への期待を高めてみた   http://t.co/hc9WPYKhqW',
            'source' => '<a href="http://twittbot.net/" rel="nofollow">twittbot.net</a>',
            'truncated' => false,
            'in_reply_to_status_id' => NULL,
            'in_reply_to_status_id_str' => NULL,
            'in_reply_to_user_id' => NULL,
            'in_reply_to_user_id_str' => NULL,
            'in_reply_to_screen_name' => NULL,
            'user' => 
            array (
                'id' => 2978312293,
                'id_str' => '2978312293',
                'name' => '井出 みき',
                'screen_name' => 'uhwocfrm',
                'location' => '',
                'description' => '',
                'url' => NULL,
                'entities' => 
                array (
                    'description' => 
                    array (
                        'urls' => 
                        array (
                        ),
                    ),
                ),
                'protected' => false,
                'followers_count' => 508,
                'friends_count' => 499,
                'listed_count' => 5,
                'created_at' => 'Tue Jan 13 02:57:54 +0000 2015',
                'favourites_count' => 0,
                'utc_offset' => NULL,
                'time_zone' => NULL,
                'geo_enabled' => false,
                'verified' => false,
                'statuses_count' => 100,
                'lang' => 'ja',
                'contributors_enabled' => false,
                'is_translator' => false,
                'is_translation_enabled' => false,
                'profile_background_color' => 'C0DEED',
                'profile_background_image_url' => 'http://abs.twimg.com/images/themes/theme1/bg.png',
                'profile_background_image_url_https' => 'https://abs.twimg.com/images/themes/theme1/bg.png',
                'profile_background_tile' => false,
                'profile_image_url' => 'http://pbs.twimg.com/profile_images/554834960608030720/0LAnvBsq_normal.jpeg',
                'profile_image_url_https' => 'https://pbs.twimg.com/profile_images/554834960608030720/0LAnvBsq_normal.jpeg',
                'profile_link_color' => '0084B4',
                'profile_sidebar_border_color' => 'C0DEED',
                'profile_sidebar_fill_color' => 'DDEEF6',
                'profile_text_color' => '333333',
                'profile_use_background_image' => true,
                'has_extended_profile' => false,
                'default_profile' => true,
                'default_profile_image' => false,
                'following' => NULL,
                'follow_request_sent' => NULL,
                'notifications' => NULL,
            ),
            'geo' => NULL,
            'coordinates' => NULL,
            'place' => NULL,
            'contributors' => NULL,
            'is_quote_status' => false,
            'retweet_count' => 0,
            'favorite_count' => 0,
            'entities' => 
            array (
                'hashtags' => 
                array (
                ),
                'symbols' => 
                array (
                ),
                'user_mentions' => 
                array (
                ),
                'urls' => 
                array (
                    0 => 
                    array (
                        'url' => 'http://t.co/hc9WPYKhqW',
                        'expanded_url' => 'http://roy.pink/soR',
                        'display_url' => 'roy.pink/soR',
                        'indices' => 
                        array (
                            0 => 62,
                            1 => 84,
                        ),
                    ),
                ),
            ),
            'favorited' => false,
            'retweeted' => false,
            'possibly_sensitive' => false,
            'lang' => 'ja',
        );
    }
}
