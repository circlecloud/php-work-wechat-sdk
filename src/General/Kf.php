<?php

namespace CircleCloud\WorkWeChatSDK\General;

use CircleCloud\WorkWeChatSDK\Client;

class Kf
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function sendMsg($touser, $open_kfid, $msgtype, $body)
    {
        return $this->client->post('kf/send_msg?access_token='.$this->client->getToken(), [
            'touser' => $touser,
            'open_kfid' => $open_kfid,
            $msgtype => $body,
        ]);
    }

    public function sendMsgText($touser, $open_kfid, $content)
    {
        return $this->sendMsg($touser, $open_kfid, 'text', ['content' => $content]);
    }

    public function sendMsgImage($touser, $open_kfid, $media_id)
    {
        return $this->sendMsg($touser, $open_kfid, 'image', ['media_id' => $media_id]);
    }

    public function sendMsgVoice($touser, $open_kfid, $media_id)
    {
        return $this->sendMsg($touser, $open_kfid, 'voice', ['media_id' => $media_id]);
    }

    public function sendMsgVideo($touser, $open_kfid, $media_id)
    {
        return $this->sendMsg($touser, $open_kfid, 'video', ['media_id' => $media_id]);
    }

    public function sendMsgFile($touser, $open_kfid, $media_id)
    {
        return $this->sendMsg($touser, $open_kfid, 'file', ['media_id' => $media_id]);
    }

    public function sendMsgLink($touser, $open_kfid, $title, $desc, $url, $thumb_media_id)
    {
        return $this->sendMsg($touser, $open_kfid, 'link', [
            'title' => $title,
            'desc' => $desc,
            'url' => $url,
            'thumb_media_id' => $thumb_media_id,
        ]);
    }

    public function sendMsgMiniprogram($touser, $open_kfid, $appid, $title, $pagepath, $thumb_media_id)
    {
        return $this->sendMsg($touser, $open_kfid, 'miniprogram', [
            'appid' => $appid,
            'title' => $title,
            'pagepath' => $pagepath,
            'thumb_media_id' => $thumb_media_id,
        ]);
    }

    /**
     * 发送菜单消息.
     *
     * <pre>
     *   [
     *     'type' => 'click|view|miniprogram'
     *     'click' =>       [ 'id' => '100', 'content' => '满意' ]
     *     'view' =>        [ 'url' => 'https://oauth.yumc.pw',  'content' => '自助查询' ]
     *     'miniprogram' => [ 'appid' => 'xxxx', 'pagepath' => 'xxxx', 'content' => '小程' ]
     *   ]
     * </pre>.
     *
     * @param mixed $touser
     * @param mixed $openKfid
     * @param mixed $head_content
     * @param mixed $list
     * @param mixed $tail_content
     * @param mixed $open_kfid
     */
    public function sendMsgMsgmenu($touser, $open_kfid, $head_content, $list, $tail_content)
    {
        return $this->sendMsg($touser, $open_kfid, 'msgmenu', [
            'head_content' => $appid,
            'list' => $list,
            'tail_content' => $tail_content,
        ]);
    }

    public function sendLocation($touser, $open_kfid, $name, $address, $latitude, $langitude)
    {
        return $this->sendMsg($touser, $open_kfid, 'location', [
            'name' => $name,
            'address' => $address,
            'latitude' => $latitude,
            'langitude' => $langitude,
        ]);
    }

    public function account(): Account
    {
        return new Account($this->client);
    }

    public function addContactWay($open_kfid, $scene)
    {
        return $this->client->post('kf/add_contact_way?access_token='.$this->client->getToken(), [
            'open_kfid' => $open_kfid,
            'scene' => $scene,
        ]);
    }
}
class Account
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list()
    {
        return $this->client->get('kf/account/list?access_token='.$this->client->getToken());
    }

    public function add($name, $media_id)
    {
        return $this->client->post('kf/account/add?access_token='.$this->client->getToken(), [
            'name' => $name,
            'media_id' => $media_id,
        ]);
    }

    public function update($open_kfid, $name, $media_id)
    {
        return $this->client->post('kf/account/update?access_token='.$this->client->getToken(), [
            'open_kfid' => $open_kfid,
            'name' => $name,
            'media_id' => $media_id,
        ]);
    }

    public function del($open_kfid)
    {
        return $this->client->post('kf/account/del?access_token='.$this->client->getToken(), [
            'open_kfid' => $open_kfid,
        ]);
    }
}
