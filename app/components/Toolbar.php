<?php

namespace app\components;

/*
 * Create By Mujib Masyhudi <mujib.masyhudi@gmail.com>
 * Create at {date('now')}
 */

/**
 * Description of toolbar
 *
 * @author samsung-pc
 * echo Toolbar::widget([
  'items' => [
  // Important: you need to specify url as 'controller/action',
  // not just as 'controller' even if default action is used.
  ['label' => 'Home', 'url' => ['site/index']],
  // 'Products' menu item will be selected as long as the route is 'product/index'
  ['label' => 'Products', 'url' => ['product/index'], 'items' => [
  ['label' => 'New Arrivals', 'url' => ['product/index', 'tag' => 'new']],
  ['label' => 'Most Popular', 'url' => ['product/index', 'tag' => 'popular']],
  ]],
  ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
  ],
  ]);
 */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use Yii;

class Toolbar extends \yii\base\Widget {

    public $items = [];

    public function init() {
        parent::init();
        $result = Html::beginTag('div', ['class'=>'btn-group']);
        foreach ($this->items as $item) {
            $result .= $this->renderItem($item);
        }
        $result .= Html::endTag('div');
        echo $result;
    }

    protected function renderItem($item) {
        $label = Html::encode($item['label']);
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
        $icon = ArrayHelper::getValue($item, 'icon');
        $badge = ArrayHelper::getValue($item, 'badge');

//        if (isset($item['active'])) {
//            $active = ArrayHelper::remove($item, 'active', false);
//        } else {
//            $active = $this->isItemActive($item);
//        }
        $linkContent = '';
        if ($icon) {
            $linkContent .= Html::tag('i', '', ['class' => $icon]);
        }
        
        if ($badge !== null) {
            $badge = (array) $badge;
            $bagdeCss = 'badge pull-right';
            if (isset($badge[1])) {
                $bagdeCss .= ' bg-' . $badge[1];
            }
            $linkContent .= Html::tag('small', $badge[0], ['class' => $bagdeCss]);
        }
        
//        if ($this->activateItems && $active) {
//            Html::addCssClass($options, 'active');
//        }

        //return Html::tag('li', Html::a($linkContent, $url, $linkOptions) . $items, $options);
        return Html::a($linkContent, $url, $linkOptions) . $items;
    }

}
