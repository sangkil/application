<?php

namespace app\components;

/*
 * Create By Mujib Masyhudi <mujib.masyhudi@gmail.com>
 * Create at {date('now')}
 */

/**
 * Example
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

class ActionToolbar extends \yii\base\Widget {

    public $items = [];

    public function init() {
        parent::init();
        $result = Html::beginTag('div', ['class' => 'btn-group']);
        //$result .= Html::tag('button', 'Action', ['class' => 'btn btn-default btn-sm', 'type' => 'button']);
        
        $result .= Html::beginTag('button', ['class' => 'btn btn-default btn-sm', 'type' => 'button']);
        $result .= Html::tag('i', '&nbsp;Action', ['class' => 'fa fa-check']);
        $result .= Html::endTag('button');
        
        $result .= Html::beginTag('button', ['class' => 'btn btn-success btn-sm dropdown-toggle', 'data-toggle' => 'dropdown', 'type' => 'button']);
        $result .= Html::tag('span', '', ['class' => 'caret']);
        $result .= Html::tag('span', 'Toggle Dropdown', ['class' => 'sr-only']);
        $result .= Html::endTag('button');
        
        $result .= Html::beginTag('ul', ['class' => 'dropdown-menu']);
        foreach ($this->items as $item) {
            $result .= Html::beginTag('li');
            $result .= $this->renderItem($item);
            $result .= Html::endTag('li');
        }
        $result .= Html::endTag('ul');
        $result .= Html::endTag('div');
        echo $result;
    }

    protected function renderItem($item) {
        $label = isset($item['label']) ? Html::encode($item['label']) : null;
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
        $icon = ArrayHelper::getValue($item, 'icon');
        $badge = ArrayHelper::getValue($item, 'badge');

        $linkContent = '';
        if ($icon) {
            $linkContent .= Html::tag('i', '', ['class' => $icon]);
        }
        $linkContent .= '&nbsp;';
        $linkContent .= ($label !== null) ? $label : '';

        return Html::a($linkContent, $url, $linkOptions);
    }

}
