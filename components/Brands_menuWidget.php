<?php

/**
 * Created by PhpStorm.
 * User: AdminRus
 * Date: 05.04.2017
 * Time: 22:02
 */
namespace app\components;
use yii\base\Widget;
use app\models\Brands;
use Yii;
class Brands_menuWidget extends Widget
{
    public $tpl;
    public $menuHtml;
    public $data;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        if($this->tpl===null){
            $this->tpl='brand_menu';
        }
        $this->tpl.='.php';
    }

    public function  run()
    {
        $menuss=Yii::$app->cache->get('brand_menu');
        if ($menuss) return $menuss;

        $this->data=Brands::find()->indexBy('id')->asArray()->all();
        $this->menuHtml=$this->getMenuHtml($this->data);

        Yii::$app->cache->set('brand_menu',$this->menuHtml, 600);
        return $this->menuHtml;
    }

    protected function getMenuHtml($mas_data){
        $str='';
        $str.=$this->catToTemplate($mas_data);
        return $str;
    }

    protected function catToTemplate($mas_li){
        ob_start();
        include __DIR__.'/menu_tpl/'.$this->tpl;
        return ob_get_clean();
    }
}