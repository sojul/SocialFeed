<?php

namespace spec\Lns\SocialFeed\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TweetFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Factory\TweetFactory');
    }

    function it_should_implement_post_factory_interface()
    {
        $this->shouldImplement('Lns\SocialFeed\Factory\PostFactoryInterface');
    }

    function it_should_create_twitter_tweet_from_twitter_api_data() {
        $this->create($this->getSampleTweetData())->shouldImplement('Lns\SocialFeed\Model\PostInterface');
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
            'provider' => '<a href="http://twittbot.net/" rel="nofollow">twittbot.net</a>',
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
