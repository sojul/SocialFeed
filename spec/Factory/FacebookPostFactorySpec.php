<?php

namespace spec\Lns\SocialFeed\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FacebookPostFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Lns\SocialFeed\Factory\FacebookPostFactory');
    }

    function it_should_implement_post_factory_interface()
    {
        $this->shouldImplement('Lns\SocialFeed\Factory\PostFactoryInterface');
    }

    function it_should_create_facebook_post_from_facebook_api_data() {
        $this->create($this->getSampleData())->shouldImplement('Lns\SocialFeed\Model\PostInterface');
    }

    private function getSampleData() {
        return array(
            'id' => '31176228436_10152090423658437',
            'from' =>
            array (
                'name' => 'vmix.fm',
                'link' => 'https://www.facebook.com/vmix.fm',
                'category' => 'Radio Station',
                'id' => '31176228436',
                'picture' => array(
                    'data' => array(
                        'is_silhouette' => false,
                        'url' => 'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfa1/v/t1.0-1/p50x50/190613_10150118491598437_6747387_n.jpg?oh=4cdb4b131b580befd80d725539cf2be4&oe=56264EDA&__gda__=1446287155_b6c8912fa8b92b62eb76fdd0dbaff8bf'
                    )
                )
            ),
            'message' => 'Record Store Day! Music is love, keep on searchin!',
            "message_tags" => [
                "18" => [
                    [
                        "id"     => "394602367362049",
                        "name"   => "Syrian Media Incubator I  حاضنة الإعلام السوري",
                        "type"   => "page",
                        "offset" => 18,
                        "length" => 45
                    ]
                ]
            ],
            'picture' => 'https://fbexternal-a.akamaihd.net/safe_image.php?d=AQCXuaVPm8KlMl-2&w=130&h=130&url=http%3A%2F%2Fi1.ytimg.com%2Fvi%2F9hkszD-5y70%2Fhqdefault.jpg&cfs=1',
            'link' => 'https://www.youtube.com/watch?v=9hkszD-5y70',
            'name' => 'Underground Sound of Argentina - Untitled 1',
            'caption' => 'youtube.com',
            'description' => 'Aquarius - 2001 - by http://vmix.fm - http://www.facebook.com/vmix.fm',
            'icon' => 'https://www.facebook.com/images/icons/post.gif',
            'actions' =>
            array (
                0 =>
                array (
                    'name' => 'Share',
                    'link' => 'https://www.facebook.com/31176228436/posts/10152090423658437',
                ),
            ),
            'privacy' =>
            array (
                'value' => '',
                'description' => '',
                'friends' => '',
                'allow' => '',
                'deny' => '',
            ),
            'type' => 'link',
            'status_type' => 'shared_story',
            'created_time' => '2014-04-19T10:28:33+0000',
            'updated_time' => '2014-06-03T02:42:59+0000',
            'shares' =>
            array (
                'count' => 4,
            ),
            'is_hidden' => false,
            'is_expired' => false,
            'likes' =>
            array (
                'data' =>
                array (
                    0 =>
                    array (
                        'id' => '10153501690413854',
                        'name' => 'Omar Galván',
                    ),
                    1 =>
                    array (
                        'id' => '10206961689943003',
                        'name' => 'Anki Pettersson',
                    ),
                    2 =>
                    array (
                        'id' => '10206740164244386',
                        'name' => 'John X-Man',
                    ),
                    3 =>
                    array (
                        'id' => '643493279114810',
                        'name' => 'Yukiya Nakao',
                    ),
                    4 =>
                    array (
                        'id' => '1079674945394885',
                        'name' => 'Timothy Disselhorst',
                    ),
                    5 =>
                    array (
                        'id' => '10203906978508065',
                        'name' => 'Ulysse Maurin',
                    ),
                ),
                'paging' =>
                array (
                    'cursors' =>
                    array (
                        'after' => 'MTAyMDM5MDY5Nzg1MDgwNjU=',
                        'before' => 'MTAxNTM1MDE2OTA0MTM4NTQ=',
                    ),
                ),
            ),
            'comments' =>
            array (
                'data' =>
                array (
                    0 =>
                    array (
                        'id' => '10152090423658437_10152179157748437',
                        'from' =>
                        array (
                            'id' => '943580542328628',
                            'name' => 'Wrobert Angell',
                        ),
                        'message' => 'excellent !!',
                        'can_remove' => false,
                        'created_time' => '2014-06-03T02:42:59+0000',
                        'like_count' => 0,
                        'user_likes' => false,
                    ),
                ),
                'paging' =>
                array (
                    'cursors' =>
                    array (
                        'after' => 'MQ==',
                        'before' => 'MQ==',
                    ),
                ),
            ),
        );
    }
}
