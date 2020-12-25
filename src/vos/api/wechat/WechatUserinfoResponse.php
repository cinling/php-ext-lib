<?php


namespace cin\extLib\vos\api\wechat;

/**
 * Class WechatUserinfoResponse
 * @package cin\extLib\vos\api\wechat
 */
class WechatUserinfoResponse extends BaseWechatResponse {
    /**
     * @var string 用户的唯一标识
     */
    public $openid;
    /**
     * @var string 用户昵称
     */
    public $nickname;
    /**
     * @var int 用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
     */
    public $sex;
    /**
     * @var string 用户个人资料填写的省份
     */
    public $province;
    /**
     * @var string 普通用户个人资料填写的城市
     */
    public $city;
    /**
     * @var string 国家，如中国为CN
     */
    public $country;
    /**
     * @var string 用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），用户没有头像时该项为空。若用户更换头像，原有头像URL将失效。
     */
    public $headimgurl;
    /**
     * @var string[] 用户特权信息，json 数组，如微信沃卡用户为（chinaunicom）
     */
    public $privilege;
    /**
     * @var string 只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段。
     */
    public $unionid;
}