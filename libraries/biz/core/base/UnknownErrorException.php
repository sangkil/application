<?php

namespace biz\core\base;

/**
 * Description of UnknownErrorException
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class UnknownErrorException extends \yii\base\Exception
{

    public function getName()
    {
        return 'Unknown Error';
    }
}
