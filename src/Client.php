<?php

namespace CircleCloud\WorkWeChatSDK;

class Client
{
    protected $config;
    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    public function __construct($config)
    {
        $this->config = $config;
        $this->initialize();
    }

    public function __sleep()
    {
        return ['config'];
    }

    public function __wakeup()
    {
        $this->initialize();
    }

    public function initialize()
    {
        $this->httpClient = new \GuzzleHttp\Client([
            'base_uri' => 'https://qyapi.weixin.qq.com/cgi-bin/',
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getToken()
    {
        //请求地址： https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=ID&corpsecret=SECRET
        $config = $this->getConfig();
        $cache = Cache::getToken($config['clientid']);
        if (!$cache) {
            $result = $this->get('gettoken?'.\http_build_query([
                'corpid' => $config['appid'],
                'corpsecret' => $config['secret'],
            ]));
            Cache::setToken($config['clientid'], $cache = $result->access_token, $result->expires_in - 300);
        }

        return $cache;
    }

    public function get($path)
    {
        return $this->request('GET', $path);
    }

    public function post($path, $options = [])
    {
        return $this->request('POST', $path, [
            'body' => json_encode($options, JSON_UNESCAPED_UNICODE),
        ]);
    }

    public function form($path, $options = [])
    {
        $httpClient = new \GuzzleHttp\Client([
            'base_uri' => 'https://qyapi.weixin.qq.com/cgi-bin/',
        ]);
        $result = $httpClient
            ->request(
                'post',
                $path,
                \array_merge([
                    'http_errors' => false,
                ], [
                    'multipart' => [$options],
                ])
            )
        ;
        $status = $result->getStatusCode();
        if ($status > 399) {
            return \forbidden('请求微信接口异常 状态码: '.$status, $result->getBody()->getContents());
        }

        return \json_decode($result->getBody()->getContents());
    }

    public function request($method, $path, $options = [])
    {
        $result = $this->httpClient
            ->request(
                $method,
                $path,
                \array_merge([
                    'http_errors' => false,
                ], $options)
            )
        ;
        $status = $result->getStatusCode();
        if ($status > 399) {
            return \forbidden('请求微信接口异常 状态码: '.$status, $result->getBody()->getContents());
        }
        if (204 == $status) {
            return $status;
        }

        $result = json_decode($result->getBody()->getContents());
        if (isset($result->errcode) && 0 != $result->errcode) {
            return forbidden($result->errmsg, [$result, $options]);
        }

        return $result;
    }
}
