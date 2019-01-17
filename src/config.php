<?php

return [

    'aliyunvod' => [

        'default' => [
            // region
            'region_id' => 'cn-shanghai',

            // Access Key ID
            'access_key' => env('ALIYUN_VOD_ACCESS_KEY', ''),

            // Access Key Secret
            'access_secret' => env('ALIYUN_VOD_ACCESS_SECRET', ''),

            // URL鉴权秘钥
            'url_auth_key' => env('ALIYUN_VOD_URL_AUTH_KEY', ''),

            // 上传视频分类ID，为空时阿里云后台设置的默认分类生效
            'upload_cate_id' => '',

            // 上传视频转码模板组ID，为空时阿里云后台设置的默认模板生效
            'upload_template_group_id' => '',

            // 播放凭证过期时间。取值范围：100~3000。为空时取阿里云默认值（100秒）
            'play_auth_info_timeout' => env('VOD_PLAY_AUTH_INFO_TIMEOUT', 1800),

            // 视频标签
            'video_tags' => '',
            ]
    ]
];