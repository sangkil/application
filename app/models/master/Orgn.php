<?php

namespace app\models\master;

/**
 * Orgn
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Orgn extends \biz\core\master\models\Orgn {

    public function rules() {
        $dRule = parent::rules();
        $dRule[] = [['code'], 'unique'];
        return $dRule;
    }

}
