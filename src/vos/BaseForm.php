<?php


namespace cin\extLib\vos;


/**
 * Class BaseForm 基础表单模型
 * @package cin\extLib\vos
 *
 * @deprecated 在 v3.0.0 后删除
 */
class BaseForm extends BaseVo {

    /**
     * 根据轻轻参数初始化表单数据
     * @return static
     */
    public static function initByParams() {
        $form = new static();
        $form->loadByParams();
        return $form;
    }

    /**
     * 使用请求参数加载数据
     * @return BaseForm
     */
    public function loadByParams() {
        $params = $_REQUEST;
        $this->setAttrs($params);
        return $this;
    }
}