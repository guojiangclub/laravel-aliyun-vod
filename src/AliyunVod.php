<?php

namespace iBrand\Aliyun\Vod;

use AlibabaCloud\Client\AlibabaCloud;

class AliyunVod
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;

        AlibabaCloud::accessKeyClient($config['access_key'], $config['access_secret'])
            ->regionId($config['region_id'])
            ->name('vod');
    }


    /**
     * 获取视频信息列表
     * @param string $status
     * @param string $startTime
     * @param string $endTime
     * @param int $cateId
     * @param string $storageLocation
     * @param int $pageNo
     * @param int $pageSize
     * @param string $sortBy
     * @return \AlibabaCloud\Client\Result\Result|array
     * https://help.aliyun.com/document_detail/52838.html?spm=a2c4g.11186623.6.711.abc27cdeczT0Mk
     */
    public function getVideoList($status = ''
        , $startTime = ''
        , $endTime = ''
        , $cateId = 0
        , $storageLocation = ''
        , $pageNo = 1
        , $pageSize = 10
        , $sortBy = 'Desc')
    {
        try {
            $request = AlibabaCloud::vod()->v20170321()->getVideoList();

            if (!empty($status)) {
                $request->withStatus($status);
            }
            if (!empty($startTime)) {
                $request->withStartTime($startTime);
            }
            if (!empty($endTime)) {
                $request->withEndTime($endTime);
            }
            if (!empty($cateId)) {
                $request->withCateId($cateId);
            }
            if (!empty($storageLocation)) {
                $request->withStorageLocation($storageLocation);
            }
            $request->withPageNo($pageNo);

            $request->withPageSize($pageSize);

            return $request->client('vod')->request();

        } catch (\Exception $e) {
            return ['errorMessage' => $e->getMessage()];
        }


    }


    /**
     * 获取视频上传地址和凭证
     * @param $title
     * @param $filename
     * @param string $description
     * @param string $cover
     * @param array $userData
     * @return \AlibabaCloud\Client\Result\Result
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     * https://help.aliyun.com/document_detail/55407.html?spm=a2c4g.11186623.6.695.2de65e92fnREjz
     */

    public function createUploadVideo($title, $filename, $description = '', $cover = '', $userData = [])
    {

        try {

            $request = AlibabaCloud::vod()->v20170321()->createUploadVideo();

            $request->withTitle($title);
            $request->withFileName($filename);
            $request->withDescription($description ?: $title);
            $request->withCoverURL($cover);

            if ($tags = array_get($this->config, 'video_tags')) {
                $request->withTags($tags);
            }

            if (!empty($userData)) {
                $request->withUserData(json_encode($userData));
            }

            if ($cateId = array_get($this->config, 'upload_cate_id')) {
                $request->withCateId($cateId);
            }

            if ($templateGroupId = array_get($this->config, 'upload_template_group_id')) {
                $request->withCateId($templateGroupId);
            }

            return $request->client('vod')->request();


        } catch (\Exception $e) {

            return ['errorMessage' => $e->getMessage()];
        }


    }

    /**
     * 删除视频
     * @param array $VideoIds
     * @return \AlibabaCloud\Client\Result\Result|array
     * https://help.aliyun.com/document_detail/52837.html?spm=a2c4g.11186623.6.712.59a1361aPraAgv
     */
    public function deleteVideo(array $VideoIds){

        try {

            $request = AlibabaCloud::vod()->v20170321()->deleteVideo();

            $request->withVideoIds(implode(',',$VideoIds));

            return $request->client('vod')->request();

        } catch (\Exception $e) {

            return ['errorMessage' => $e->getMessage()];
        }
    }

    /**
     * URL批量拉取上传
     * @param $uploadURLs
     * @param array $uploadMetadatas
     * @return \AlibabaCloud\Client\Result\Result
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     * https://help.aliyun.com/document_detail/86311.html?spm=a2c4g.11186623.6.698.174260d2F9WURR
     */
    public function uploadMediaByURL($uploadURLs, $uploadMetadatas = [])
    {
        try {

            $request = AlibabaCloud::vod()->v20170321()->uploadMediaByURL();
            $request->withUploadURLs($uploadURLs);
            $request->withUploadMetadatas(json_encode($uploadMetadatas));
            return $request->client('vod')->request();

        } catch (\Exception $e) {

            return ['errorMessage' => $e->getMessage()];
        }

    }

    /**
     * 刷新视频上传凭证
     * @param $videoId
     * @return \AlibabaCloud\Client\Result\Result|array
     * https://help.aliyun.com/document_detail/55408.html?spm=a2c4g.11186623.2.24.1c1b257esjkcvV
     */
    public function refreshUploadVideo($videoId)
    {

        try {

            $request = AlibabaCloud::vod()->v20170321()->refreshUploadVideo();

            $request->withVideoId($videoId);

            return $request->client('vod')->request();

        } catch (\Exception $e) {

            return ['errorMessage' => $e->getMessage()];
        }


    }


    /**
     * 获取视频信息
     * @param $videoId
     * @return \AlibabaCloud\Client\Result\Result
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     * https://help.aliyun.com/document_detail/52835.html?spm=a2c4g.11186623.6.707.4af757ba9UUIF3
     */
    public function getVideoInfo($videoId)
    {

        try {

            $request = AlibabaCloud::vod()->v20170321()->getVideoInfo();
            $request->withVideoId($videoId);
            return $request->client('vod')->request();

        } catch (\Exception $e) {
            return ['errorMessage' => $e->getMessage()];
        }
    }

    /**
     * 修改视频信息
     * @param $videoId
     * @param string $title
     * @param string $description
     * @param string $cover
     * @param int $cateId
     * @param string $tags
     * @return \AlibabaCloud\Client\Result\Result|array
     * https://help.aliyun.com/document_detail/52836.html?spm=a2c4g.11186623.6.709.34a67344DYw8Ir
     */
    public function updateVideoInfo($videoId, $title = '', $description = '', $cover = '', $cateId = 0, $tags = '')
    {

        try {

            $request = AlibabaCloud::vod()->v20170321()->UpdateVideoInfo();

            $request->withVideoId($videoId);

            if (!empty($title)) {
                $request->withTitle($title);
            }

            if (!empty($description)) {
                $request->withDescription($description);
            }

            if (!empty($cover)) {
                $request->withCoverURL($cover);
            }

            if (!empty($cateId)) {
                $request->withCateId($cateId);
            }

            if (!empty($tags)) {
                $request->withTags($tags);
            }

            return $request->client('vod')->request();

        } catch (\Exception $e) {

            return ['errorMessage' => $e->getMessage()];
        }

    }


    /**
     * 获取视频播放地址
     * @param $videoId
     * @param int $timeout
     * @param string $formats
     * @param string $definition
     * @return \AlibabaCloud\Client\Result\Result
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     * https://help.aliyun.com/document_detail/56124.html?spm=a2c4g.11186623.6.703.27753610lEMi8k
     */
    public function getPlayInfo($videoId, $timeout = 1800, $formats = 'm3u8', $definition = '')
    {


        try {

            $request = AlibabaCloud::vod()->v20170321()->getPlayInfo();

            $request->withVideoId($videoId);

            $request->withAuthTimeout($timeout);

            $request->withFormats($formats);

            if (!empty($definition)) {
                $request->withDefinition($definition);
            }

            return $request->client('vod')->request();

        } catch (\Exception $e) {

            return ['errorMessage' => $e->getMessage()];
        }



    }

    /**
     *获取视频播放凭证
     * @param $videoId
     * @param int $timeout
     * @return \AlibabaCloud\Client\Result\Result
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function getVideoPlayAuth($videoId, $timeout = 1800)
    {

        try {

            $request = AlibabaCloud::vod()->v20170321()->getVideoPlayAuth();

            $request->withVideoId($videoId);

            $request->withAuthInfoTimeout($timeout);

            return $request->client('vod')->request();


        } catch (\Exception $e) {

            return ['errorMessage' => $e->getMessage()];
        }
    }

    /**
     * 获取源文件地址
     * @param $videoId
     * @param int $timeout
     * @return \AlibabaCloud\Client\Result\Result
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     * https://help.aliyun.com/document_detail/59624.html?spm=a2c4g.11186623.6.714.1ea3480faKYgm9
     */
    public function getMezzanineInfo($videoId, $timeout = 3600)
    {

        try {

            $request = AlibabaCloud::vod()->v20170321()->getMezzanineInfo();

            $request->withVideoId($videoId);

            $request->withAuthInfoTimeout($timeout);

            return $request->client('vod')->request();


        } catch (\Exception $e) {

            return ['errorMessage' => $e->getMessage()];
        }
    }



}