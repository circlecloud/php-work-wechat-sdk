<?php

namespace CircleCloud\WorkWeChatSDK;

class Cache
{
    public static function getToken($appid)
    {
        return cache('Weixin:access_token:'.$appid);
    }

    public static function setToken($appid, $token, $expires_in = 43000)
    {
        cache('Weixin:access_token:'.$appid, $token, $expires_in);
    }

    public static function getAuthorizationInfo($appid)
    {
        return cache('Weixin.Component:authorization_info:'.$appid);
    }

    public static function setAuthorizationInfo($appid, $info)
    {
        cache('Weixin.Component:authorization_info:'.$appid, $info);
    }

    public static function getAuthorizerToken($appid)
    {
        return cache('Weixin.Component:authorizer_access_token:'.$appid);
    }

    public static function setAuthorizerToken($appid, $token, $expires_in)
    {
        cache('Weixin.Component:authorizer_access_token:'.$appid, $token, $expires_in);
    }

    public static function getTicket()
    {
        return cache('Weixin.Component:component_verify_ticket');
    }

    public static function setTicket($ticket, $expires_in = 43000)
    {
        cache('Weixin.Component:component_verify_ticket', $ticket, $expires_in);
    }

    public static function getComponentToken()
    {
        return cache('Weixin.Component:component_access_token');
    }

    public static function setComponentToken($token, $expires_in = 7000)
    {
        cache('Weixin.Component:component_access_token', $token, $expires_in);
    }
}
