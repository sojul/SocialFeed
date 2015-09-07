<?php

namespace spec\Lns\SocialFeed\Provider;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Lns\SocialFeed\Client\ClientInterface;
use Lns\SocialFeed\Factory\PostFactoryInterface;
use Lns\SocialFeed\Model\PostInterface;

class TwitterSearchApiProviderSpec extends ObjectBehavior
{
    protected $client;
    protected $factory;

    /**
     * let
     *
     * @param Lns\SocialFeed\Client\ClientInterface $client
     * @param Lns\SocialFeed\Factory\PostFactoryInterface $factory
     */
    function let($client, $factory) {
        $this->client = $client;
        $this->factory = $factory;
        $this->beConstructedWith($client, $factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Provider\TwitterSearchApiProvider');
        $this->shouldImplement('Lns\SocialFeed\Provider\ProviderInterface');
    }

    function it_should_return_an_exection_if_query_option_is_not_set() {
        $this->shouldThrow('Lns\SocialFeed\Exception\MissingOptionsException')->duringGet();
    }

    /**
     * it_should_return_feed
     *
     * @param Lns\SocialFeed\Model\PostInterface $post1
     * @param Lns\SocialFeed\Model\PostInterface $post2
     */
    function it_should_return_feed($post1, $post2) {

        $postData1 = ['foo' => 'bar'];
        $postData2 = ['foo' => 'baz'];

        $this->client->get('/search/tweets.json', array(
            'query' => array(
                'q' => 'foo',
                'max_id' => ''
            )
        ))->willReturn([
            'statuses' => array(
                0 => $postData1,
                1 => $postData2
            ),
            'search_metadata' => array(
                'completed_in' => 0.05,
                'max_id'       => 6220260591523456190,
                'max_id_str'   => '6220260591523456190',
                'next_results' => '?max_id=6220260591523456190&q=foo&include_entities=1',
                'query'        => 'test',
                'refresh_url'  => '?since_id=6220260591523456190&q=foo&include_entities=1',
                'count'        => 15,
                'since_id'     => 0,
                'since_id_str' => '0'
            )
        ]);

        $this->factory->create($postData1)->willReturn($post1);
        $this->factory->create($postData2)->willReturn($post2);

        $this->get(array(
            'query' => 'foo'
        ))->shouldHaveType('Lns\SocialFeed\Model\ResultSet');
    }


    private function getTwitterApiSampleData()
    {
        return array (
            'statuses' => 
            array (
                0 => 
                array (
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
                ),
                1 => 
                array (
                    'metadata' => 
                    array (
                        'iso_language_code' => 'en',
                        'result_type' => 'recent',
                    ),
                    'created_at' => 'Mon Jun 29 10:03:26 +0000 2015',
                    'id' => 615460556716277760,
                    'id_str' => '615460556716277760',
                    'text' => 'I have one yardstick by which I test every major problem - &amp; that yardstick is: Is it good for America?  -Eisenhower',
                    'provider' => '<a href="https://www.socialoomph.com" rel="nofollow">SocialOomph</a>',
                    'truncated' => false,
                    'in_reply_to_status_id' => NULL,
                    'in_reply_to_status_id_str' => NULL,
                    'in_reply_to_user_id' => NULL,
                    'in_reply_to_user_id_str' => NULL,
                    'in_reply_to_screen_name' => NULL,
                    'user' => 
                    array (
                        'id' => 1367970260,
                        'id_str' => '1367970260',
                        'name' => 'Lacy Hunt',
                        'screen_name' => 'Atlanta_Newz',
                        'location' => 'Atlanta, Georgia',
                        'description' => 'Books, Movies, Camp, Fish, Hike and Hunt, with a little travel thrown in.',
                        'url' => 'http://t.co/TsaJYV3IcL',
                        'entities' => 
                        array (
                            'url' => 
                            array (
                                'urls' => 
                                array (
                                    0 => 
                                    array (
                                        'url' => 'http://t.co/TsaJYV3IcL',
                                        'expanded_url' => 'http://newsingreateratlanta.com',
                                        'display_url' => 'newsingreateratlanta.com',
                                        'indices' => 
                                        array (
                                            0 => 0,
                                            1 => 22,
                                        ),
                                    ),
                                ),
                            ),
                            'description' => 
                            array (
                                'urls' => 
                                array (
                                ),
                            ),
                        ),
                        'protected' => false,
                        'followers_count' => 4127,
                        'friends_count' => 2656,
                        'listed_count' => 24,
                        'created_at' => 'Sat Apr 20 20:44:35 +0000 2013',
                        'favourites_count' => 0,
                        'utc_offset' => NULL,
                        'time_zone' => NULL,
                        'geo_enabled' => false,
                        'verified' => false,
                        'statuses_count' => 64154,
                        'lang' => 'en',
                        'contributors_enabled' => false,
                        'is_translator' => false,
                        'is_translation_enabled' => false,
                        'profile_background_color' => 'C0DEED',
                        'profile_background_image_url' => 'http://pbs.twimg.com/profile_background_images/848213114/4f55d431c9d38704ba57613f58a93b9d.jpeg',
                        'profile_background_image_url_https' => 'https://pbs.twimg.com/profile_background_images/848213114/4f55d431c9d38704ba57613f58a93b9d.jpeg',
                        'profile_background_tile' => true,
                        'profile_image_url' => 'http://pbs.twimg.com/profile_images/3550428964/f19c80ce8c950f2587a743f3b1b4ce99_normal.jpeg',
                        'profile_image_url_https' => 'https://pbs.twimg.com/profile_images/3550428964/f19c80ce8c950f2587a743f3b1b4ce99_normal.jpeg',
                        'profile_banner_url' => 'https://pbs.twimg.com/profile_banners/1367970260/1366490766',
                        'profile_link_color' => '0084B4',
                        'profile_sidebar_border_color' => 'FFFFFF',
                        'profile_sidebar_fill_color' => 'DDEEF6',
                        'profile_text_color' => '333333',
                        'profile_use_background_image' => true,
                        'has_extended_profile' => false,
                        'default_profile' => false,
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
                        ),
                    ),
                    'favorited' => false,
                    'retweeted' => false,
                    'lang' => 'en',
                ),
                2 => 
                array (
                    'metadata' => 
                    array (
                        'iso_language_code' => 'en',
                        'result_type' => 'recent',
                    ),
                    'created_at' => 'Mon Jun 29 10:03:26 +0000 2015',
                    'id' => 615460556611301376,
                    'id_str' => '615460556611301376',
                    'text' => 'How about a quick grammar test? http://t.co/0Cr4fZItV5 #Grammar #Exercise',
                    'provider' => '<a href="http://twitterfeed.com" rel="nofollow">twitterfeed</a>',
                    'truncated' => false,
                    'in_reply_to_status_id' => NULL,
                    'in_reply_to_status_id_str' => NULL,
                    'in_reply_to_user_id' => NULL,
                    'in_reply_to_user_id_str' => NULL,
                    'in_reply_to_screen_name' => NULL,
                    'user' => 
                    array (
                        'id' => 2463038281,
                        'id_str' => '2463038281',
                        'name' => 'English Grammar Pass',
                        'screen_name' => 'EngGrammarPass',
                        'location' => 'Worldwide',
                        'description' => 'English Grammar Practice Website. Learn English. Start here: http://t.co/5YjgBp99hN 1,000+ exercises. #English #Grammar #Exercises #Practice  #TESOL #ESL #TOEIC',
                        'url' => 'http://t.co/FM6UjCszkP',
                        'entities' => 
                        array (
                            'url' => 
                            array (
                                'urls' => 
                                array (
                                    0 => 
                                    array (
                                        'url' => 'http://t.co/FM6UjCszkP',
                                        'expanded_url' => 'http://bit.ly/1fstUaU',
                                        'display_url' => 'bit.ly/1fstUaU',
                                        'indices' => 
                                        array (
                                            0 => 0,
                                            1 => 22,
                                        ),
                                    ),
                                ),
                            ),
                            'description' => 
                            array (
                                'urls' => 
                                array (
                                    0 => 
                                    array (
                                        'url' => 'http://t.co/5YjgBp99hN',
                                        'expanded_url' => 'http://goo.gl/w9qqjR',
                                        'display_url' => 'goo.gl/w9qqjR',
                                        'indices' => 
                                        array (
                                            0 => 61,
                                            1 => 83,
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'protected' => false,
                        'followers_count' => 6186,
                        'friends_count' => 20,
                        'listed_count' => 48,
                        'created_at' => 'Fri Apr 25 10:38:16 +0000 2014',
                        'favourites_count' => 21,
                        'utc_offset' => NULL,
                        'time_zone' => NULL,
                        'geo_enabled' => false,
                        'verified' => false,
                        'statuses_count' => 1626,
                        'lang' => 'en',
                        'contributors_enabled' => false,
                        'is_translator' => false,
                        'is_translation_enabled' => false,
                        'profile_background_color' => 'C0DEED',
                        'profile_background_image_url' => 'http://abs.twimg.com/images/themes/theme1/bg.png',
                        'profile_background_image_url_https' => 'https://abs.twimg.com/images/themes/theme1/bg.png',
                        'profile_background_tile' => false,
                        'profile_image_url' => 'http://pbs.twimg.com/profile_images/480668779089649666/AhLvaAnF_normal.jpeg',
                        'profile_image_url_https' => 'https://pbs.twimg.com/profile_images/480668779089649666/AhLvaAnF_normal.jpeg',
                        'profile_banner_url' => 'https://pbs.twimg.com/profile_banners/2463038281/1398839846',
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
                            0 => 
                            array (
                                'text' => 'Grammar',
                                'indices' => 
                                array (
                                    0 => 55,
                                    1 => 63,
                                ),
                            ),
                            1 => 
                            array (
                                'text' => 'Exercise',
                                'indices' => 
                                array (
                                    0 => 64,
                                    1 => 73,
                                ),
                            ),
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
                                'url' => 'http://t.co/0Cr4fZItV5',
                                'expanded_url' => 'http://bit.ly/1rvqEQf',
                                'display_url' => 'bit.ly/1rvqEQf',
                                'indices' => 
                                array (
                                    0 => 32,
                                    1 => 54,
                                ),
                            ),
                        ),
                    ),
                    'favorited' => false,
                    'retweeted' => false,
                    'possibly_sensitive' => false,
                    'lang' => 'en',
                ),
                3 => 
                array (
                    'metadata' => 
                    array (
                        'iso_language_code' => 'ja',
                        'result_type' => 'recent',
                    ),
                    'created_at' => 'Mon Jun 29 10:03:25 +0000 2015',
                    'id' => 615460555231330304,
                    'id_str' => '615460555231330304',
                    'text' => '#北川景子 #川口春奈 #陣内孝則 

                    ネプリーグ★1
                    http://t.co/5P53dwZLrH

                    #ネプリーグ #2ch #ネプチューン #林修 #fujitv',
                    'provider' => '<a href="http://twitter.com/#!/download/ipad" rel="nofollow">Twitter for iPad</a>',
                    'truncated' => false,
                    'in_reply_to_status_id' => NULL,
                    'in_reply_to_status_id_str' => NULL,
                    'in_reply_to_user_id' => NULL,
                    'in_reply_to_user_id_str' => NULL,
                    'in_reply_to_screen_name' => NULL,
                    'user' => 
                    array (
                        'id' => 120149228,
                        'id_str' => '120149228',
                        'name' => '（^ｰ^*bﾘうんこんこん',
                        'screen_name' => 'unconcon',
                        'location' => '東京都',
                        'description' => '狼固定うんこんこんなのよろしくなのー。2ch狼アイドルAKB48メディアTVフジお笑いニコ生政治社会時事ハロプロタモリドラマももクロ経済音楽漫画情報を日常的に発信。これ以上は情報過多。出身：名古屋 。 RT肯定度合多様、否定RT無 http://t.co/p28yzQe2iY',
                        'url' => 'http://t.co/MX1rmcrAZl',
                        'entities' => 
                        array (
                            'url' => 
                            array (
                                'urls' => 
                                array (
                                    0 => 
                                    array (
                                        'url' => 'http://t.co/MX1rmcrAZl',
                                        'expanded_url' => 'http://rensai.jp/a/12175',
                                        'display_url' => 'rensai.jp/a/12175',
                                        'indices' => 
                                        array (
                                            0 => 0,
                                            1 => 22,
                                        ),
                                    ),
                                ),
                            ),
                            'description' => 
                            array (
                                'urls' => 
                                array (
                                    0 => 
                                    array (
                                        'url' => 'http://t.co/p28yzQe2iY',
                                        'expanded_url' => 'http://urx.nu/bmQY',
                                        'display_url' => 'urx.nu/bmQY',
                                        'indices' => 
                                        array (
                                            0 => 116,
                                            1 => 138,
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'protected' => false,
                        'followers_count' => 965,
                        'friends_count' => 1120,
                        'listed_count' => 28,
                        'created_at' => 'Fri Mar 05 16:20:48 +0000 2010',
                        'favourites_count' => 228,
                        'utc_offset' => 32400,
                        'time_zone' => 'Tokyo',
                        'geo_enabled' => false,
                        'verified' => false,
                        'statuses_count' => 54835,
                        'lang' => 'ja',
                        'contributors_enabled' => false,
                        'is_translator' => false,
                        'is_translation_enabled' => false,
                        'profile_background_color' => 'FFF04D',
                        'profile_background_image_url' => 'http://pbs.twimg.com/profile_background_images/780980822/184ace6d1c28a46b6716785b19820b6a.jpeg',
                        'profile_background_image_url_https' => 'https://pbs.twimg.com/profile_background_images/780980822/184ace6d1c28a46b6716785b19820b6a.jpeg',
                        'profile_background_tile' => true,
                        'profile_image_url' => 'http://pbs.twimg.com/profile_images/747694933/____normal.png',
                        'profile_image_url_https' => 'https://pbs.twimg.com/profile_images/747694933/____normal.png',
                        'profile_banner_url' => 'https://pbs.twimg.com/profile_banners/120149228/1352375630',
                        'profile_link_color' => '0099CC',
                        'profile_sidebar_border_color' => 'FFFFFF',
                        'profile_sidebar_fill_color' => 'F6FFD1',
                        'profile_text_color' => '333333',
                        'profile_use_background_image' => true,
                        'has_extended_profile' => false,
                        'default_profile' => false,
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
                            0 => 
                            array (
                                'text' => '北川景子',
                                'indices' => 
                                array (
                                    0 => 0,
                                    1 => 5,
                                ),
                            ),
                            1 => 
                            array (
                                'text' => '川口春奈',
                                'indices' => 
                                array (
                                    0 => 6,
                                    1 => 11,
                                ),
                            ),
                            2 => 
                            array (
                                'text' => '陣内孝則',
                                'indices' => 
                                array (
                                    0 => 12,
                                    1 => 17,
                                ),
                            ),
                            3 => 
                            array (
                                'text' => 'ネプリーグ',
                                'indices' => 
                                array (
                                    0 => 52,
                                    1 => 58,
                                ),
                            ),
                            4 => 
                            array (
                                'text' => '2ch',
                                'indices' => 
                                array (
                                    0 => 59,
                                    1 => 63,
                                ),
                            ),
                            5 => 
                            array (
                                'text' => 'ネプチューン',
                                'indices' => 
                                array (
                                    0 => 64,
                                    1 => 71,
                                ),
                            ),
                            6 => 
                            array (
                                'text' => '林修',
                                'indices' => 
                                array (
                                    0 => 72,
                                    1 => 75,
                                ),
                            ),
                            7 => 
                            array (
                                'text' => 'fujitv',
                                'indices' => 
                                array (
                                    0 => 76,
                                    1 => 83,
                                ),
                            ),
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
                                'url' => 'http://t.co/5P53dwZLrH',
                                'expanded_url' => 'http://hayabusa7.2ch.net/test/read.cgi/livecx/1435557784/',
                                'display_url' => 'hayabusa7.2ch.net/test/read.cgi/…',
                                'indices' => 
                                array (
                                    0 => 28,
                                    1 => 50,
                                ),
                            ),
                        ),
                    ),
                    'favorited' => false,
                    'retweeted' => false,
                    'possibly_sensitive' => false,
                    'lang' => 'ja',
                ),
                4 => 
                array (
                    'metadata' => 
                    array (
                        'iso_language_code' => 'fr',
                        'result_type' => 'recent',
                    ),
                    'created_at' => 'Mon Jun 29 10:03:25 +0000 2015',
                    'id' => 615460554497327104,
                    'id_str' => '615460554497327104',
                    'text' => 'Dub Acid Test Ptn.04 #tt303 #strymon #elektron #analogrytm http://t.co/rCqyJpA5BA',
                    'provider' => '<a href="http://www.apple.com" rel="nofollow">iOS</a>',
                    'truncated' => false,
                    'in_reply_to_status_id' => NULL,
                    'in_reply_to_status_id_str' => NULL,
                    'in_reply_to_user_id' => NULL,
                    'in_reply_to_user_id_str' => NULL,
                    'in_reply_to_screen_name' => NULL,
                    'user' => 
                    array (
                        'id' => 115573906,
                        'id_str' => '115573906',
                        'name' => 'SERi',
                        'screen_name' => 'SERi_AcidWorx',
                        'location' => 'Shizuoka,Japan',
                        'description' => 'シンセと猫を愛でる日々。アシッドハウス専門レーベル”AcidWorxのA&R https://t.co/3gOnRLOhZc https://t.co/rxt4pRQUQn http://t.co/rRNTKgPaqc',
                        'url' => 'https://t.co/0vkoFr7YgF',
                        'entities' => 
                        array (
                            'url' => 
                            array (
                                'urls' => 
                                array (
                                    0 => 
                                    array (
                                        'url' => 'https://t.co/0vkoFr7YgF',
                                        'expanded_url' => 'https://www.facebook.com/SERi414',
                                        'display_url' => 'facebook.com/SERi414',
                                        'indices' => 
                                        array (
                                            0 => 0,
                                            1 => 23,
                                        ),
                                    ),
                                ),
                            ),
                            'description' => 
                            array (
                                'urls' => 
                                array (
                                    0 => 
                                    array (
                                        'url' => 'https://t.co/3gOnRLOhZc',
                                        'expanded_url' => 'https://itun.es/jp/-cN65',
                                        'display_url' => 'itun.es/jp/-cN65',
                                        'indices' => 
                                        array (
                                            0 => 39,
                                            1 => 62,
                                        ),
                                    ),
                                    1 => 
                                    array (
                                        'url' => 'https://t.co/rxt4pRQUQn',
                                        'expanded_url' => 'https://itun.es/jp/saN65',
                                        'display_url' => 'itun.es/jp/saN65',
                                        'indices' => 
                                        array (
                                            0 => 63,
                                            1 => 86,
                                        ),
                                    ),
                                    2 => 
                                    array (
                                        'url' => 'http://t.co/rRNTKgPaqc',
                                        'expanded_url' => 'http://www.beatport.com/label/acidworx/36049',
                                        'display_url' => 'beatport.com/label/acidworx…',
                                        'indices' => 
                                        array (
                                            0 => 87,
                                            1 => 109,
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'protected' => false,
                        'followers_count' => 1094,
                        'friends_count' => 984,
                        'listed_count' => 60,
                        'created_at' => 'Fri Feb 19 04:05:14 +0000 2010',
                        'favourites_count' => 3038,
                        'utc_offset' => 32400,
                        'time_zone' => 'Tokyo',
                        'geo_enabled' => true,
                        'verified' => false,
                        'statuses_count' => 33417,
                        'lang' => 'ja',
                        'contributors_enabled' => false,
                        'is_translator' => false,
                        'is_translation_enabled' => false,
                        'profile_background_color' => '000000',
                        'profile_background_image_url' => 'http://abs.twimg.com/images/themes/theme9/bg.gif',
                        'profile_background_image_url_https' => 'https://abs.twimg.com/images/themes/theme9/bg.gif',
                        'profile_background_tile' => false,
                        'profile_image_url' => 'http://pbs.twimg.com/profile_images/591480896600952832/QF13es8S_normal.jpg',
                        'profile_image_url_https' => 'https://pbs.twimg.com/profile_images/591480896600952832/QF13es8S_normal.jpg',
                        'profile_banner_url' => 'https://pbs.twimg.com/profile_banners/115573906/1433762589',
                        'profile_link_color' => 'ABB8C2',
                        'profile_sidebar_border_color' => '000000',
                        'profile_sidebar_fill_color' => '000000',
                        'profile_text_color' => '000000',
                        'profile_use_background_image' => false,
                        'has_extended_profile' => false,
                        'default_profile' => false,
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
                            0 => 
                            array (
                                'text' => 'tt303',
                                'indices' => 
                                array (
                                    0 => 21,
                                    1 => 27,
                                ),
                            ),
                            1 => 
                            array (
                                'text' => 'strymon',
                                'indices' => 
                                array (
                                    0 => 28,
                                    1 => 36,
                                ),
                            ),
                            2 => 
                            array (
                                'text' => 'elektron',
                                'indices' => 
                                array (
                                    0 => 37,
                                    1 => 46,
                                ),
                            ),
                            3 => 
                            array (
                                'text' => 'analogrytm',
                                'indices' => 
                                array (
                                    0 => 47,
                                    1 => 58,
                                ),
                            ),
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
                                'url' => 'http://t.co/rCqyJpA5BA',
                                'expanded_url' => 'http://youtu.be/mao-7gGqhdQ',
                                'display_url' => 'youtu.be/mao-7gGqhdQ',
                                'indices' => 
                                array (
                                    0 => 59,
                                    1 => 81,
                                ),
                            ),
                        ),
                    ),
                    'favorited' => false,
                    'retweeted' => false,
                    'possibly_sensitive' => false,
                    'lang' => 'fr',
                ),
                5 => 
                array (
                    'metadata' => 
                    array (
                        'iso_language_code' => 'en',
                        'result_type' => 'recent',
                    ),
                    'created_at' => 'Mon Jun 29 10:03:25 +0000 2015',
                    'id' => 615460553897541632,
                    'id_str' => '615460553897541632',
                    'text' => 'Really thinking about just staying up and studying for my options test tomorrow',
                    'provider' => '<a href="http://twitter.com/download/iphone" rel="nofollow">Twitter for iPhone</a>',
                    'truncated' => false,
                    'in_reply_to_status_id' => NULL,
                    'in_reply_to_status_id_str' => NULL,
                    'in_reply_to_user_id' => NULL,
                    'in_reply_to_user_id_str' => NULL,
                    'in_reply_to_screen_name' => NULL,
                    'user' => 
                    array (
                        'id' => 556417285,
                        'id_str' => '556417285',
                        'name' => '천국',
                        'screen_name' => 'YeowangSun',
                        'location' => '',
                        'description' => 'wear something . . . black',
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
                        'followers_count' => 1009,
                        'friends_count' => 710,
                        'listed_count' => 0,
                        'created_at' => 'Wed Apr 18 00:32:31 +0000 2012',
                        'favourites_count' => 3348,
                        'utc_offset' => -25200,
                        'time_zone' => 'Arizona',
                        'geo_enabled' => true,
                        'verified' => false,
                        'statuses_count' => 10322,
                        'lang' => 'en',
                        'contributors_enabled' => false,
                        'is_translator' => false,
                        'is_translation_enabled' => false,
                        'profile_background_color' => 'B80053',
                        'profile_background_image_url' => 'http://pbs.twimg.com/profile_background_images/489625716900630528/vvY3vyD-.jpeg',
                        'profile_background_image_url_https' => 'https://pbs.twimg.com/profile_background_images/489625716900630528/vvY3vyD-.jpeg',
                        'profile_background_tile' => true,
                        'profile_image_url' => 'http://pbs.twimg.com/profile_images/608099666366857216/TGG85K_w_normal.jpg',
                        'profile_image_url_https' => 'https://pbs.twimg.com/profile_images/608099666366857216/TGG85K_w_normal.jpg',
                        'profile_banner_url' => 'https://pbs.twimg.com/profile_banners/556417285/1435472742',
                        'profile_link_color' => 'B800B8',
                        'profile_sidebar_border_color' => 'FFFFFF',
                        'profile_sidebar_fill_color' => 'DDEEF6',
                        'profile_text_color' => '333333',
                        'profile_use_background_image' => true,
                        'has_extended_profile' => false,
                        'default_profile' => false,
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
                        ),
                    ),
                    'favorited' => false,
                    'retweeted' => false,
                    'lang' => 'en',
                ),
                6 => 
                array (
                    'metadata' => 
                    array (
                        'iso_language_code' => 'it',
                        'result_type' => 'recent',
                    ),
                    'created_at' => 'Mon Jun 29 10:03:24 +0000 2015',
                    'id' => 615460551586631680,
                    'id_str' => '615460551586631680',
                    'text' => 'Test Sismic http://t.co/fJNmS24SJd #TestSismic Questa � una prova.. http://t.co/CAZ6ir3Wmz',
                    'provider' => '<a href="http://www.sismic.it/tweet/home.php" rel="nofollow">SismicTest</a>',
                    'truncated' => false,
                    'in_reply_to_status_id' => NULL,
                    'in_reply_to_status_id_str' => NULL,
                    'in_reply_to_user_id' => NULL,
                    'in_reply_to_user_id_str' => NULL,
                    'in_reply_to_screen_name' => NULL,
                    'user' => 
                    array (
                        'id' => 3317254043,
                        'id_str' => '3317254043',
                        'name' => 'Sismic Sistemi S.R.L',
                        'screen_name' => 'sismicfi',
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
                        'followers_count' => 8,
                        'friends_count' => 0,
                        'listed_count' => 0,
                        'created_at' => 'Wed Jun 10 12:26:54 +0000 2015',
                        'favourites_count' => 0,
                        'utc_offset' => NULL,
                        'time_zone' => NULL,
                        'geo_enabled' => false,
                        'verified' => false,
                        'statuses_count' => 22,
                        'lang' => 'it',
                        'contributors_enabled' => false,
                        'is_translator' => false,
                        'is_translation_enabled' => false,
                        'profile_background_color' => 'C0DEED',
                        'profile_background_image_url' => 'http://abs.twimg.com/images/themes/theme1/bg.png',
                        'profile_background_image_url_https' => 'https://abs.twimg.com/images/themes/theme1/bg.png',
                        'profile_background_tile' => false,
                        'profile_image_url' => 'http://abs.twimg.com/sticky/default_profile_images/default_profile_5_normal.png',
                        'profile_image_url_https' => 'https://abs.twimg.com/sticky/default_profile_images/default_profile_5_normal.png',
                        'profile_link_color' => '0084B4',
                        'profile_sidebar_border_color' => 'C0DEED',
                        'profile_sidebar_fill_color' => 'DDEEF6',
                        'profile_text_color' => '333333',
                        'profile_use_background_image' => true,
                        'has_extended_profile' => false,
                        'default_profile' => true,
                        'default_profile_image' => true,
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
                            0 => 
                            array (
                                'text' => 'TestSismic',
                                'indices' => 
                                array (
                                    0 => 35,
                                    1 => 46,
                                ),
                            ),
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
                                'url' => 'http://t.co/fJNmS24SJd',
                                'expanded_url' => 'http://www.sismic.it',
                                'display_url' => 'sismic.it',
                                'indices' => 
                                array (
                                    0 => 12,
                                    1 => 34,
                                ),
                            ),
                        ),
                        'media' => 
                        array (
                            0 => 
                            array (
                                'id' => 615460551540502528,
                                'id_str' => '615460551540502528',
                                'indices' => 
                                array (
                                    0 => 68,
                                    1 => 90,
                                ),
                                'media_url' => 'http://pbs.twimg.com/media/CIqOHFvWcAAYkdg.jpg',
                                'media_url_https' => 'https://pbs.twimg.com/media/CIqOHFvWcAAYkdg.jpg',
                                'url' => 'http://t.co/CAZ6ir3Wmz',
                                'display_url' => 'pic.twitter.com/CAZ6ir3Wmz',
                                'expanded_url' => 'http://twitter.com/sismicfi/status/615460551586631680/photo/1',
                                'type' => 'photo',
                                'sizes' => 
                                array (
                                    'large' => 
                                    array (
                                        'w' => 128,
                                        'h' => 128,
                                        'resize' => 'fit',
                                    ),
                                    'medium' => 
                                    array (
                                        'w' => 128,
                                        'h' => 128,
                                        'resize' => 'fit',
                                    ),
                                    'thumb' => 
                                    array (
                                        'w' => 128,
                                        'h' => 128,
                                        'resize' => 'crop',
                                    ),
                                    'small' => 
                                    array (
                                        'w' => 128,
                                        'h' => 128,
                                        'resize' => 'fit',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'favorited' => false,
                    'retweeted' => false,
                    'possibly_sensitive' => false,
                    'lang' => 'it',
                ),
                7 => 
                array (
                    'metadata' => 
                    array (
                        'iso_language_code' => 'en',
                        'result_type' => 'recent',
                    ),
                    'created_at' => 'Mon Jun 29 10:03:24 +0000 2015',
                    'id' => 615460549476790272,
                    'id_str' => '615460549476790272',
                    'text' => 'RT @TheComedyHumor: I study. 

                    I take the test. 

                    I pass. 

                    I forget what I learned.

                    Whats the point?',
                    'provider' => '<a href="http://twitter.com/download/android" rel="nofollow">Twitter for Android</a>',
                    'truncated' => false,
                    'in_reply_to_status_id' => NULL,
                    'in_reply_to_status_id_str' => NULL,
                    'in_reply_to_user_id' => NULL,
                    'in_reply_to_user_id_str' => NULL,
                    'in_reply_to_screen_name' => NULL,
                    'user' => 
                    array (
                        'id' => 1404857928,
                        'id_str' => '1404857928',
                        'name' => 'Capt.Paras ✈',
                        'screen_name' => 'MaicaShienead',
                        'location' => '',
                        'description' => 'Hangga\'t wala kang nasasaktan at natatapakan, tuloy lang!!  IG:@maicashienead',
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
                        'followers_count' => 590,
                        'friends_count' => 543,
                        'listed_count' => 1,
                        'created_at' => 'Sun May 05 11:51:30 +0000 2013',
                        'favourites_count' => 725,
                        'utc_offset' => 28800,
                        'time_zone' => 'Beijing',
                        'geo_enabled' => true,
                        'verified' => false,
                        'statuses_count' => 8282,
                        'lang' => 'en',
                        'contributors_enabled' => false,
                        'is_translator' => false,
                        'is_translation_enabled' => false,
                        'profile_background_color' => 'C0DEED',
                        'profile_background_image_url' => 'http://pbs.twimg.com/profile_background_images/378800000051982616/4bff1f5275638b6b4357a7542a76b910.jpeg',
                        'profile_background_image_url_https' => 'https://pbs.twimg.com/profile_background_images/378800000051982616/4bff1f5275638b6b4357a7542a76b910.jpeg',
                        'profile_background_tile' => true,
                        'profile_image_url' => 'http://pbs.twimg.com/profile_images/587607305287376896/HpdrDOXY_normal.jpg',
                        'profile_image_url_https' => 'https://pbs.twimg.com/profile_images/587607305287376896/HpdrDOXY_normal.jpg',
                        'profile_banner_url' => 'https://pbs.twimg.com/profile_banners/1404857928/1428931516',
                        'profile_link_color' => '0084B4',
                        'profile_sidebar_border_color' => 'FFFFFF',
                        'profile_sidebar_fill_color' => 'DDEEF6',
                        'profile_text_color' => '333333',
                        'profile_use_background_image' => true,
                        'has_extended_profile' => false,
                        'default_profile' => false,
                        'default_profile_image' => false,
                        'following' => NULL,
                        'follow_request_sent' => NULL,
                        'notifications' => NULL,
                    ),
                    'geo' => NULL,
                    'coordinates' => NULL,
                    'place' => NULL,
                    'contributors' => NULL,
                    'retweeted_status' => 
                    array (
                        'metadata' => 
                        array (
                            'iso_language_code' => 'en',
                            'result_type' => 'recent',
                        ),
                        'created_at' => 'Sun May 17 21:22:33 +0000 2015',
                        'id' => 600048784664559616,
                        'id_str' => '600048784664559616',
                        'text' => 'I study. 

                        I take the test. 

                        I pass. 

                        I forget what I learned.

                        Whats the point?',
                        'provider' => '<a href="https://about.twitter.com/products/tweetdeck" rel="nofollow">TweetDeck</a>',
                        'truncated' => false,
                        'in_reply_to_status_id' => NULL,
                        'in_reply_to_status_id_str' => NULL,
                        'in_reply_to_user_id' => NULL,
                        'in_reply_to_user_id_str' => NULL,
                        'in_reply_to_screen_name' => NULL,
                        'user' => 
                        array (
                            'id' => 32688098,
                            'id_str' => '32688098',
                            'name' => 'Funny Tweets',
                            'screen_name' => 'TheComedyHumor',
                            'location' => '',
                            'description' => 'Here to make you laugh. #Business comedyhumortweets@gmail.com',
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
                            'followers_count' => 1884162,
                            'friends_count' => 164,
                            'listed_count' => 4529,
                            'created_at' => 'Sat Apr 18 00:40:04 +0000 2009',
                            'favourites_count' => 797,
                            'utc_offset' => -18000,
                            'time_zone' => 'Central Time (US & Canada)',
                            'geo_enabled' => false,
                            'verified' => false,
                            'statuses_count' => 18553,
                            'lang' => 'en',
                            'contributors_enabled' => false,
                            'is_translator' => false,
                            'is_translation_enabled' => false,
                            'profile_background_color' => '3B94D9',
                            'profile_background_image_url' => 'http://pbs.twimg.com/profile_background_images/378800000071582755/22ec09f2f197729440b3ec1f216f1112.jpeg',
                            'profile_background_image_url_https' => 'https://pbs.twimg.com/profile_background_images/378800000071582755/22ec09f2f197729440b3ec1f216f1112.jpeg',
                            'profile_background_tile' => true,
                            'profile_image_url' => 'http://pbs.twimg.com/profile_images/553485891394887680/7eyOFaz4_normal.jpeg',
                            'profile_image_url_https' => 'https://pbs.twimg.com/profile_images/553485891394887680/7eyOFaz4_normal.jpeg',
                            'profile_banner_url' => 'https://pbs.twimg.com/profile_banners/32688098/1420796296',
                            'profile_link_color' => '3B94D9',
                            'profile_sidebar_border_color' => 'FFFFFF',
                            'profile_sidebar_fill_color' => 'EFEFEF',
                            'profile_text_color' => '333333',
                            'profile_use_background_image' => true,
                            'has_extended_profile' => false,
                            'default_profile' => false,
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
                        'retweet_count' => 7223,
                        'favorite_count' => 5488,
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
                            ),
                        ),
                        'favorited' => false,
                        'retweeted' => false,
                        'lang' => 'en',
                    ),
                    'is_quote_status' => false,
                    'retweet_count' => 7223,
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
                            0 => 
                            array (
                                'screen_name' => 'TheComedyHumor',
                                'name' => 'Funny Tweets',
                                'id' => 32688098,
                                'id_str' => '32688098',
                                'indices' => 
                                array (
                                    0 => 3,
                                    1 => 18,
                                ),
                            ),
                        ),
                        'urls' => 
                        array (
                        ),
                    ),
                    'favorited' => false,
                    'retweeted' => false,
                    'lang' => 'en',
                ),
                8 => 
                array (
                    'metadata' => 
                    array (
                        'iso_language_code' => 'en',
                        'result_type' => 'recent',
                    ),
                    'created_at' => 'Mon Jun 29 10:03:24 +0000 2015',
                    'id' => 615460547996155904,
                    'id_str' => '615460547996155904',
                    'text' => 'RT @TheComedyHumor: I study. 

                    I take the test. 

                    I pass. 

                    I forget what I learned.

                    Whats the point?',
                    'provider' => '<a href="http://twitter.com" rel="nofollow">Twitter Web Client</a>',
                    'truncated' => false,
                    'in_reply_to_status_id' => NULL,
                    'in_reply_to_status_id_str' => NULL,
                    'in_reply_to_user_id' => NULL,
                    'in_reply_to_user_id_str' => NULL,
                    'in_reply_to_screen_name' => NULL,
                    'user' => 
                    array (
                        'id' => 1100425952,
                        'id_str' => '1100425952',
                        'name' => 'mika',
                        'screen_name' => 'donioMIKAla',
                        'location' => 'Earth ',
                        'description' => 'Takot sa tao (weird af)',
                        'url' => 'https://t.co/IwppuZb5lV',
                        'entities' => 
                        array (
                            'url' => 
                            array (
                                'urls' => 
                                array (
                                    0 => 
                                    array (
                                        'url' => 'https://t.co/IwppuZb5lV',
                                        'expanded_url' => 'https://www.facebook.com/mikabianca.donio',
                                        'display_url' => 'facebook.com/mikabianca.don…',
                                        'indices' => 
                                        array (
                                            0 => 0,
                                            1 => 23,
                                        ),
                                    ),
                                ),
                            ),
                            'description' => 
                            array (
                                'urls' => 
                                array (
                                ),
                            ),
                        ),
                        'protected' => false,
                        'followers_count' => 152,
                        'friends_count' => 647,
                        'listed_count' => 2,
                        'created_at' => 'Fri Jan 18 08:46:28 +0000 2013',
                        'favourites_count' => 2385,
                        'utc_offset' => 28800,
                        'time_zone' => 'Beijing',
                        'geo_enabled' => false,
                        'verified' => false,
                        'statuses_count' => 1789,
                        'lang' => 'en',
                        'contributors_enabled' => false,
                        'is_translator' => false,
                        'is_translation_enabled' => false,
                        'profile_background_color' => 'FA743E',
                        'profile_background_image_url' => 'http://pbs.twimg.com/profile_background_images/613662963883311105/MfUsvyYT.jpg',
                        'profile_background_image_url_https' => 'https://pbs.twimg.com/profile_background_images/613662963883311105/MfUsvyYT.jpg',
                        'profile_background_tile' => true,
                        'profile_image_url' => 'http://pbs.twimg.com/profile_images/608917113911164929/O6dIpRYP_normal.jpg',
                        'profile_image_url_https' => 'https://pbs.twimg.com/profile_images/608917113911164929/O6dIpRYP_normal.jpg',
                        'profile_banner_url' => 'https://pbs.twimg.com/profile_banners/1100425952/1435486904',
                        'profile_link_color' => '4A913C',
                        'profile_sidebar_border_color' => 'FFFFFF',
                        'profile_sidebar_fill_color' => 'DDEEF6',
                        'profile_text_color' => '333333',
                        'profile_use_background_image' => true,
                        'has_extended_profile' => false,
                        'default_profile' => false,
                        'default_profile_image' => false,
                        'following' => NULL,
                        'follow_request_sent' => NULL,
                        'notifications' => NULL,
                    ),
                    'geo' => NULL,
                    'coordinates' => NULL,
                    'place' => NULL,
                    'contributors' => NULL,
                    'retweeted_status' => 
                    array (
                        'metadata' => 
                        array (
                            'iso_language_code' => 'en',
                            'result_type' => 'recent',
                        ),
                        'created_at' => 'Sun May 17 21:22:33 +0000 2015',
                        'id' => 600048784664559616,
                        'id_str' => '600048784664559616',
                        'text' => 'I study. 

                        I take the test. 

                        I pass. 

                        I forget what I learned.

                        Whats the point?',
                        'provider' => '<a href="https://about.twitter.com/products/tweetdeck" rel="nofollow">TweetDeck</a>',
                        'truncated' => false,
                        'in_reply_to_status_id' => NULL,
                        'in_reply_to_status_id_str' => NULL,
                        'in_reply_to_user_id' => NULL,
                        'in_reply_to_user_id_str' => NULL,
                        'in_reply_to_screen_name' => NULL,
                        'user' => 
                        array (
                            'id' => 32688098,
                            'id_str' => '32688098',
                            'name' => 'Funny Tweets',
                            'screen_name' => 'TheComedyHumor',
                            'location' => '',
                            'description' => 'Here to make you laugh. #Business comedyhumortweets@gmail.com',
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
                            'followers_count' => 1884162,
                            'friends_count' => 164,
                            'listed_count' => 4529,
                            'created_at' => 'Sat Apr 18 00:40:04 +0000 2009',
                            'favourites_count' => 797,
                            'utc_offset' => -18000,
                            'time_zone' => 'Central Time (US & Canada)',
                            'geo_enabled' => false,
                            'verified' => false,
                            'statuses_count' => 18553,
                            'lang' => 'en',
                            'contributors_enabled' => false,
                            'is_translator' => false,
                            'is_translation_enabled' => false,
                            'profile_background_color' => '3B94D9',
                            'profile_background_image_url' => 'http://pbs.twimg.com/profile_background_images/378800000071582755/22ec09f2f197729440b3ec1f216f1112.jpeg',
                            'profile_background_image_url_https' => 'https://pbs.twimg.com/profile_background_images/378800000071582755/22ec09f2f197729440b3ec1f216f1112.jpeg',
                            'profile_background_tile' => true,
                            'profile_image_url' => 'http://pbs.twimg.com/profile_images/553485891394887680/7eyOFaz4_normal.jpeg',
                            'profile_image_url_https' => 'https://pbs.twimg.com/profile_images/553485891394887680/7eyOFaz4_normal.jpeg',
                            'profile_banner_url' => 'https://pbs.twimg.com/profile_banners/32688098/1420796296',
                            'profile_link_color' => '3B94D9',
                            'profile_sidebar_border_color' => 'FFFFFF',
                            'profile_sidebar_fill_color' => 'EFEFEF',
                            'profile_text_color' => '333333',
                            'profile_use_background_image' => true,
                            'has_extended_profile' => false,
                            'default_profile' => false,
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
                        'retweet_count' => 7223,
                        'favorite_count' => 5488,
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
                            ),
                        ),
                        'favorited' => false,
                        'retweeted' => false,
                        'lang' => 'en',
                    ),
                    'is_quote_status' => false,
                    'retweet_count' => 7223,
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
                            0 => 
                            array (
                                'screen_name' => 'TheComedyHumor',
                                'name' => 'Funny Tweets',
                                'id' => 32688098,
                                'id_str' => '32688098',
                                'indices' => 
                                array (
                                    0 => 3,
                                    1 => 18,
                                ),
                            ),
                        ),
                        'urls' => 
                        array (
                        ),
                    ),
                    'favorited' => false,
                    'retweeted' => false,
                    'lang' => 'en',
                ),
                9 => 
                array (
                    'metadata' => 
                    array (
                        'iso_language_code' => 'und',
                        'result_type' => 'recent',
                    ),
                    'created_at' => 'Mon Jun 29 10:03:23 +0000 2015',
                    'id' => 615460547941634049,
                    'id_str' => '615460547941634049',
                    'text' => 'http://t.co/hWs3fvn12y',
                    'provider' => '<a href="http://mobile.twitter.com" rel="nofollow">Mobile Web</a>',
                    'truncated' => false,
                    'in_reply_to_status_id' => NULL,
                    'in_reply_to_status_id_str' => NULL,
                    'in_reply_to_user_id' => NULL,
                    'in_reply_to_user_id_str' => NULL,
                    'in_reply_to_screen_name' => NULL,
                    'user' => 
                    array (
                        'id' => 293625583,
                        'id_str' => '293625583',
                        'name' => 'Bumble P.',
                        'screen_name' => 'fovidd',
                        'location' => '',
                        'description' => 'IG : PUIIBB Line : bumblepuiibb',
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
                        'followers_count' => 64,
                        'friends_count' => 132,
                        'listed_count' => 1,
                        'created_at' => 'Thu May 05 17:44:39 +0000 2011',
                        'favourites_count' => 2380,
                        'utc_offset' => 25200,
                        'time_zone' => 'Bangkok',
                        'geo_enabled' => true,
                        'verified' => false,
                        'statuses_count' => 5318,
                        'lang' => 'th',
                        'contributors_enabled' => false,
                        'is_translator' => false,
                        'is_translation_enabled' => false,
                        'profile_background_color' => '9266CC',
                        'profile_background_image_url' => 'http://pbs.twimg.com/profile_background_images/511684652268937216/SjdixRtr.jpeg',
                        'profile_background_image_url_https' => 'https://pbs.twimg.com/profile_background_images/511684652268937216/SjdixRtr.jpeg',
                        'profile_background_tile' => true,
                        'profile_image_url' => 'http://pbs.twimg.com/profile_images/597083120760819712/Py7eOZM4_normal.jpg',
                        'profile_image_url_https' => 'https://pbs.twimg.com/profile_images/597083120760819712/Py7eOZM4_normal.jpg',
                        'profile_banner_url' => 'https://pbs.twimg.com/profile_banners/293625583/1423152970',
                        'profile_link_color' => 'FFCC4D',
                        'profile_sidebar_border_color' => 'FFFFFF',
                        'profile_sidebar_fill_color' => '7AC3EE',
                        'profile_text_color' => '3D1957',
                        'profile_use_background_image' => true,
                        'has_extended_profile' => false,
                        'default_profile' => false,
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
                                'url' => 'http://t.co/hWs3fvn12y',
                                'expanded_url' => 'http://en.nametests.com/test/result/peangpim-2-you-will-have-2-children-1-you-will-get-married-at-39/595727438/',
                                'display_url' => 'en.nametests.com/test/result/pe…',
                                'indices' => 
                                array (
                                    0 => 0,
                                    1 => 22,
                                ),
                            ),
                        ),
                    ),
                    'favorited' => false,
                    'retweeted' => false,
                    'possibly_sensitive' => false,
                    'lang' => 'und',
                ),
                10 => 
                array (
                    'metadata' => 
                    array (
                        'iso_language_code' => 'en',
                        'result_type' => 'recent',
                    ),
                    'created_at' => 'Mon Jun 29 10:03:23 +0000 2015',
                    'id' => 615460546972749824,
                    'id_str' => '615460546972749824',
                    'text' => 'Did you pass this Alzheimer test? --This is Gold. http://t.co/IkkdVSKGQQ http://t.co/QGAYbuz1uT',
                    'provider' => '<a href="https://twitter.com" rel="nofollow">storkpinkie_new</a>',
                    'truncated' => false,
                    'in_reply_to_status_id' => NULL,
                    'in_reply_to_status_id_str' => NULL,
                    'in_reply_to_user_id' => NULL,
                    'in_reply_to_user_id_str' => NULL,
                    'in_reply_to_screen_name' => NULL,
                    'user' => 
                    array (
                        'id' => 317351086,
                        'id_str' => '317351086',
                        'name' => 'Ramona Reynolds',
                        'screen_name' => 'storkpinkie',
                        'location' => 'Kansas City',
                        'description' => 'Communicator. Freelance writer. General organizer. Bacon geek. Alcohol nerd. Web ninja. Incurable introvert. Musicaholic. Infuriatingly humble creator.',
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
                        'followers_count' => 3275,
                        'friends_count' => 3445,
                        'listed_count' => 9,
                        'created_at' => 'Tue Jun 14 20:13:56 +0000 2011',
                        'favourites_count' => 0,
                        'utc_offset' => -18000,
                        'time_zone' => 'Central Time (US & Canada)',
                        'geo_enabled' => false,
                        'verified' => false,
                        'statuses_count' => 4028,
                        'lang' => 'en',
                        'contributors_enabled' => false,
                        'is_translator' => false,
                        'is_translation_enabled' => false,
                        'profile_background_color' => '000000',
                        'profile_background_image_url' => 'http://abs.twimg.com/images/themes/theme2/bg.gif',
                        'profile_background_image_url_https' => 'https://abs.twimg.com/images/themes/theme2/bg.gif',
                        'profile_background_tile' => false,
                        'profile_image_url' => 'http://pbs.twimg.com/profile_images/551470164915417088/u-Tsv_Ub_normal.jpeg',
                        'profile_image_url_https' => 'https://pbs.twimg.com/profile_images/551470164915417088/u-Tsv_Ub_normal.jpeg',
                        'profile_banner_url' => 'https://pbs.twimg.com/profile_banners/317351086/1420315732',
                        'profile_link_color' => '89C9FA',
                        'profile_sidebar_border_color' => '000000',
                        'profile_sidebar_fill_color' => '000000',
                        'profile_text_color' => '000000',
                        'profile_use_background_image' => false,
                        'has_extended_profile' => false,
                        'default_profile' => false,
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
                                'url' => 'http://t.co/IkkdVSKGQQ',
                                'expanded_url' => 'http://bit.ly/1KylJrM',
                                'display_url' => 'bit.ly/1KylJrM',
                                'indices' => 
                                array (
                                    0 => 50,
                                    1 => 72,
                                ),
                            ),
                        ),
                        'media' => 
                        array (
                            0 => 
                            array (
                                'id' => 615460546842759168,
                                'id_str' => '615460546842759168',
                                'indices' => 
                                array (
                                    0 => 73,
                                    1 => 95,
                                ),
                                'media_url' => 'http://pbs.twimg.com/media/CIqOG0PUkAAPFHw.png',
                                'media_url_https' => 'https://pbs.twimg.com/media/CIqOG0PUkAAPFHw.png',
                                'url' => 'http://t.co/QGAYbuz1uT',
                                'display_url' => 'pic.twitter.com/QGAYbuz1uT',
                                'expanded_url' => 'http://twitter.com/storkpinkie/status/615460546972749824/photo/1',
                                'type' => 'photo',
                                'sizes' => 
                                array (
                                    'thumb' => 
                                    array (
                                        'w' => 150,
                                        'h' => 150,
                                        'resize' => 'crop',
                                    ),
                                    'large' => 
                                    array (
                                        'w' => 1024,
                                        'h' => 582,
                                        'resize' => 'fit',
                                    ),
                                    'medium' => 
                                    array (
                                        'w' => 600,
                                        'h' => 341,
                                        'resize' => 'fit',
                                    ),
                                    'small' => 
                                    array (
                                        'w' => 340,
                                        'h' => 193,
                                        'resize' => 'fit',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'favorited' => false,
                    'retweeted' => false,
                    'possibly_sensitive' => false,
                    'lang' => 'en',
                ),
                11 => 
                array (
                    'metadata' => 
                    array (
                        'result_type' => 'recent',
                        'iso_language_code' => 'ko',
                    ),
                    'created_at' => 'Mon Jun 29 10:03:23 +0000 2015',
                    'id' => 615460546523992066,
                    'id_str' => '615460546523992066',
                    'text' => '[당신의 몸값은?] 류엘님님님의 몸값은 [공짜] 입니다. http://t.co/cSb2zubQCD',
                    'provider' => '<a href="http://twitter.com" rel="nofollow">Twitter Web Client</a>',
                    'truncated' => false,
                    'in_reply_to_status_id' => NULL,
                    'in_reply_to_status_id_str' => NULL,
                    'in_reply_to_user_id' => NULL,
                    'in_reply_to_user_id_str' => NULL,
                    'in_reply_to_screen_name' => NULL,
                    'user' => 
                    array (
                        'id' => 817340436,
                        'id_str' => '817340436',
                        'name' => '류엘님님',
                        'screen_name' => 'U_Ruel',
                        'location' => '다무겨사이 @U_Ruel_No2',
                        'description' => '사퍼-다이무수 / 욕섹트폭트심함 / 문어발잡덕 / 기본 소비러 / 페이트-♥길가메쉬 수♥ / 엘소드-애드 수 / 카작나르 / 자덕질도 함 / 언팔말고 블락 / 멘션맞팔',
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
                        'followers_count' => 227,
                        'friends_count' => 268,
                        'listed_count' => 1,
                        'created_at' => 'Tue Sep 11 12:38:08 +0000 2012',
                        'favourites_count' => 4149,
                        'utc_offset' => -18000,
                        'time_zone' => 'Central Time (US & Canada)',
                        'geo_enabled' => false,
                        'verified' => false,
                        'statuses_count' => 75298,
                        'lang' => 'ko',
                        'contributors_enabled' => false,
                        'is_translator' => false,
                        'is_translation_enabled' => false,
                        'profile_background_color' => 'B2DFDA',
                        'profile_background_image_url' => 'http://abs.twimg.com/images/themes/theme13/bg.gif',
                        'profile_background_image_url_https' => 'https://abs.twimg.com/images/themes/theme13/bg.gif',
                        'profile_background_tile' => false,
                        'profile_image_url' => 'http://pbs.twimg.com/profile_images/607381385091780608/ztsJkevw_normal.png',
                        'profile_image_url_https' => 'https://pbs.twimg.com/profile_images/607381385091780608/ztsJkevw_normal.png',
                        'profile_link_color' => '93A644',
                        'profile_sidebar_border_color' => 'EEEEEE',
                        'profile_sidebar_fill_color' => 'FFFFFF',
                        'profile_text_color' => '333333',
                        'profile_use_background_image' => true,
                        'has_extended_profile' => false,
                        'default_profile' => false,
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
                                'url' => 'http://t.co/cSb2zubQCD',
                                'expanded_url' => 'http://ossue.com/?63',
                                'display_url' => 'ossue.com/?63',
                                'indices' => 
                                array (
                                    0 => 32,
                                    1 => 54,
                                ),
                            ),
                        ),
                    ),
                    'favorited' => false,
                    'retweeted' => false,
                    'possibly_sensitive' => false,
                    'lang' => 'ko',
                ),
                12 => 
                array (
                    'metadata' => 
                    array (
                        'iso_language_code' => 'tl',
                        'result_type' => 'recent',
                    ),
                    'created_at' => 'Mon Jun 29 10:03:22 +0000 2015',
                    'id' => 615460542589743104,
                    'id_str' => '615460542589743104',
                    'text' => 'Nay nag pa test po ako! #MMSParaKayAnton',
                    'provider' => '<a href="http://twitter.com/download/android" rel="nofollow">Twitter for Android</a>',
                    'truncated' => false,
                    'in_reply_to_status_id' => NULL,
                    'in_reply_to_status_id_str' => NULL,
                    'in_reply_to_user_id' => NULL,
                    'in_reply_to_user_id_str' => NULL,
                    'in_reply_to_screen_name' => NULL,
                    'user' => 
                    array (
                        'id' => 2614376996,
                        'id_str' => '2614376996',
                        'name' => 'Kim Rodriguez OFC',
                        'screen_name' => 'KIMnaticsOFC',
                        'location' => 'Nationwide',
                        'description' => 'The official twitter account of Kimrodriguez fansclub. My Mother\'s Secret Monday to Friday bago mag 24 oras! :)',
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
                        'followers_count' => 511,
                        'friends_count' => 54,
                        'listed_count' => 1,
                        'created_at' => 'Wed Jul 09 23:03:01 +0000 2014',
                        'favourites_count' => 220,
                        'utc_offset' => NULL,
                        'time_zone' => NULL,
                        'geo_enabled' => false,
                        'verified' => false,
                        'statuses_count' => 6149,
                        'lang' => 'en',
                        'contributors_enabled' => false,
                        'is_translator' => false,
                        'is_translation_enabled' => false,
                        'profile_background_color' => 'C0DEED',
                        'profile_background_image_url' => 'http://pbs.twimg.com/profile_background_images/613913224241491968/9iDFWG2t.jpg',
                        'profile_background_image_url_https' => 'https://pbs.twimg.com/profile_background_images/613913224241491968/9iDFWG2t.jpg',
                        'profile_background_tile' => true,
                        'profile_image_url' => 'http://pbs.twimg.com/profile_images/606733668862722048/Q2v_V-ia_normal.jpg',
                        'profile_image_url_https' => 'https://pbs.twimg.com/profile_images/606733668862722048/Q2v_V-ia_normal.jpg',
                        'profile_banner_url' => 'https://pbs.twimg.com/profile_banners/2614376996/1432449130',
                        'profile_link_color' => '0084B4',
                        'profile_sidebar_border_color' => '000000',
                        'profile_sidebar_fill_color' => '000000',
                        'profile_text_color' => '000000',
                        'profile_use_background_image' => true,
                        'has_extended_profile' => false,
                        'default_profile' => false,
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
                            0 => 
                            array (
                                'text' => 'MMSParaKayAnton',
                                'indices' => 
                                array (
                                    0 => 24,
                                    1 => 40,
                                ),
                            ),
                        ),
                        'symbols' => 
                        array (
                        ),
                        'user_mentions' => 
                        array (
                        ),
                        'urls' => 
                        array (
                        ),
                    ),
                    'favorited' => false,
                    'retweeted' => false,
                    'lang' => 'tl',
                ),
                13 => 
                array (
                    'metadata' => 
                    array (
                        'iso_language_code' => 'en',
                        'result_type' => 'recent',
                    ),
                    'created_at' => 'Mon Jun 29 10:03:22 +0000 2015',
                    'id' => 615460542006853632,
                    'id_str' => '615460542006853632',
                    'text' => 'TASC is hiring a #Test #Engineer, apply now! #SanAntonio #jobs http://t.co/45NEaTR9yQ',
                    'provider' => '<a href="http://neuvoo.ca" rel="nofollow">mi.primer.app.con.plaxy.t00</a>',
                    'truncated' => false,
                    'in_reply_to_status_id' => NULL,
                    'in_reply_to_status_id_str' => NULL,
                    'in_reply_to_user_id' => NULL,
                    'in_reply_to_user_id_str' => NULL,
                    'in_reply_to_screen_name' => NULL,
                    'user' => 
                    array (
                        'id' => 3180682484,
                        'id_str' => '3180682484',
                        'name' => 'Engineering SA',
                        'screen_name' => 'NeuvooEngSA',
                        'location' => 'San Antonio, TX',
                        'description' => 'Check out our Engineering jobs in San Antonio on our website http://t.co/G4bf5C1BJm',
                        'url' => 'http://t.co/aeohtJQrv7',
                        'entities' => 
                        array (
                            'url' => 
                            array (
                                'urls' => 
                                array (
                                    0 => 
                                    array (
                                        'url' => 'http://t.co/aeohtJQrv7',
                                        'expanded_url' => 'http://neuvoo.com/en',
                                        'display_url' => 'neuvoo.com/en',
                                        'indices' => 
                                        array (
                                            0 => 0,
                                            1 => 22,
                                        ),
                                    ),
                                ),
                            ),
                            'description' => 
                            array (
                                'urls' => 
                                array (
                                    0 => 
                                    array (
                                        'url' => 'http://t.co/G4bf5C1BJm',
                                        'expanded_url' => 'http://neuvoo.com/jobs/?k=engineering&l=San+Antonio%2C+TX%2C+United+States&f=&p=1&r=15',
                                        'display_url' => 'neuvoo.com/jobs/?k=engine…',
                                        'indices' => 
                                        array (
                                            0 => 61,
                                            1 => 83,
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'protected' => false,
                        'followers_count' => 317,
                        'friends_count' => 851,
                        'listed_count' => 30,
                        'created_at' => 'Thu Apr 30 14:24:52 +0000 2015',
                        'favourites_count' => 0,
                        'utc_offset' => NULL,
                        'time_zone' => NULL,
                        'geo_enabled' => false,
                        'verified' => false,
                        'statuses_count' => 4820,
                        'lang' => 'en',
                        'contributors_enabled' => false,
                        'is_translator' => false,
                        'is_translation_enabled' => false,
                        'profile_background_color' => 'C0DEED',
                        'profile_background_image_url' => 'http://abs.twimg.com/images/themes/theme1/bg.png',
                        'profile_background_image_url_https' => 'https://abs.twimg.com/images/themes/theme1/bg.png',
                        'profile_background_tile' => false,
                        'profile_image_url' => 'http://pbs.twimg.com/profile_images/593795286478114817/NbYpSZ2X_normal.png',
                        'profile_image_url_https' => 'https://pbs.twimg.com/profile_images/593795286478114817/NbYpSZ2X_normal.png',
                        'profile_banner_url' => 'https://pbs.twimg.com/profile_banners/3180682484/1430406795',
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
                            0 => 
                            array (
                                'text' => 'Test',
                                'indices' => 
                                array (
                                    0 => 17,
                                    1 => 22,
                                ),
                            ),
                            1 => 
                            array (
                                'text' => 'Engineer',
                                'indices' => 
                                array (
                                    0 => 23,
                                    1 => 32,
                                ),
                            ),
                            2 => 
                            array (
                                'text' => 'SanAntonio',
                                'indices' => 
                                array (
                                    0 => 45,
                                    1 => 56,
                                ),
                            ),
                            3 => 
                            array (
                                'text' => 'jobs',
                                'indices' => 
                                array (
                                    0 => 57,
                                    1 => 62,
                                ),
                            ),
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
                                'url' => 'http://t.co/45NEaTR9yQ',
                                'expanded_url' => 'http://neuvoo.com/job.php?id=0myjvewiv8&provider=twitter&lang=en&client_id=760&l=San+Antonio%2C+Texas%2C+US&k=Test+Engineer',
                                'display_url' => 'neuvoo.com/job.php?id=0my…',
                                'indices' => 
                                array (
                                    0 => 63,
                                    1 => 85,
                                ),
                            ),
                        ),
                    ),
                    'favorited' => false,
                    'retweeted' => false,
                    'possibly_sensitive' => false,
                    'lang' => 'en',
                ),
                14 => 
                array (
                    'metadata' => 
                    array (
                        'result_type' => 'recent',
                        'iso_language_code' => 'ko',
                    ),
                    'created_at' => 'Mon Jun 29 10:03:22 +0000 2015',
                    'id' => 615460541000126464,
                    'id_str' => '615460541000126464',
                    'text' => '[당신의 몸값은?] 엔알키노님의 몸값은 [머리카락 한가닥] 입니다. http://t.co/Uen3AftsoI',
                    'provider' => '<a href="http://mobile.twitter.com" rel="nofollow">Mobile Web</a>',
                    'truncated' => false,
                    'in_reply_to_status_id' => NULL,
                    'in_reply_to_status_id_str' => NULL,
                    'in_reply_to_user_id' => NULL,
                    'in_reply_to_user_id_str' => NULL,
                    'in_reply_to_screen_name' => NULL,
                    'user' => 
                    array (
                        'id' => 183939887,
                        'id_str' => '183939887',
                        'name' => '노말 엔알키노(계정 털림)',
                        'screen_name' => 'jshnimzz',
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
                        'followers_count' => 186,
                        'friends_count' => 245,
                        'listed_count' => 3,
                        'created_at' => 'Sat Aug 28 07:47:18 +0000 2010',
                        'favourites_count' => 3414,
                        'utc_offset' => 32400,
                        'time_zone' => 'Seoul',
                        'geo_enabled' => true,
                        'verified' => false,
                        'statuses_count' => 27920,
                        'lang' => 'ko',
                        'contributors_enabled' => false,
                        'is_translator' => false,
                        'is_translation_enabled' => false,
                        'profile_background_color' => '0099B9',
                        'profile_background_image_url' => 'http://abs.twimg.com/images/themes/theme4/bg.gif',
                        'profile_background_image_url_https' => 'https://abs.twimg.com/images/themes/theme4/bg.gif',
                        'profile_background_tile' => false,
                        'profile_image_url' => 'http://pbs.twimg.com/profile_images/601690629077278720/fXka2Gyz_normal.jpg',
                        'profile_image_url_https' => 'https://pbs.twimg.com/profile_images/601690629077278720/fXka2Gyz_normal.jpg',
                        'profile_banner_url' => 'https://pbs.twimg.com/profile_banners/183939887/1356172420',
                        'profile_link_color' => '0099B9',
                        'profile_sidebar_border_color' => '5ED4DC',
                        'profile_sidebar_fill_color' => '95E8EC',
                        'profile_text_color' => '3C3940',
                        'profile_use_background_image' => true,
                        'has_extended_profile' => false,
                        'default_profile' => false,
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
                                'url' => 'http://t.co/Uen3AftsoI',
                                'expanded_url' => 'http://ossue.com/?63',
                                'display_url' => 'ossue.com/?63',
                                'indices' => 
                                array (
                                    0 => 38,
                                    1 => 60,
                                ),
                            ),
                        ),
                    ),
                    'favorited' => false,
                    'retweeted' => false,
                    'possibly_sensitive' => false,
                    'lang' => 'ko',
                ),
            ),
            'search_metadata' => 
            array (
                'completed_in' => 0.035000000000000003,
                'max_id' => 615460559203405824,
                'max_id_str' => '615460559203405824',
                'next_results' => '?max_id=615460541000126463&q=test&include_entities=1',
                'query' => 'test',
                'refresh_url' => '?since_id=615460559203405824&q=test&include_entities=1',
                'count' => 15,
                'since_id' => 0,
                'since_id_str' => '0',
            ),
        );

    }
}
