<?php

namespace biz\core\base\rest;

/**
 * Description of Serializer
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  * @since 3.0
 */
class Serializer extends \yii\rest\Serializer
{

    /**
     * @inheritdoc
     */
    protected function serializeModelErrors($model)
    {
        $this->response->setStatusCode(422, 'Data Validation Failed.');
        $result = [];
        $this->serializeRecursive($model, $result);
        return $result;
    }

    protected function serializeRecursive($model, &$result, $prefix = '')
    {
        if (!$model instanceof \yii\base\Model) {
            return;
        }
        foreach ($model->getFirstErrors() as $name => $message) {
            $result[] = [
                'field' => $prefix == '' ? $name : $prefix . "[{$name}]",
                'message' => $message,
            ];
        }
        if ($model instanceof \yii\db\BaseActiveRecord) {
            foreach ($model->relatedRecords as $name => $value) {
                $_prefix = $prefix == '' ? $name : $prefix . "[{$name}]";
                if (is_array($value)) {
                    foreach ($value as $index => $child) {
                        $this->serializeRecursive($child, $result, $_prefix . "[{$index}]");
                    }
                } else {
                    $this->serializeRecursive($value, $result, $_prefix);
                }
            }
        }
    }
}