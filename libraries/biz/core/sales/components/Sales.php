<?php

namespace biz\core\sales\components;

use Yii;
use biz\core\sales\models\Sales as MSales;
use yii\web\ServerErrorHttpException;

/**
 * Description of Sales
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class Sales extends \biz\core\base\Api
{
    /**
     *
     * @var string 
     */
    public $modelClass = 'biz\core\sales\models\Sales';

    /**
     *
     * @var string 
     */
    public $prefixEventName = 'e_sales';

    /**
     *
     * @param  array $data
     * @param  \biz\core\sales\models\Sales $model
     * @return \biz\core\sales\models\Sales
     * @throws \Exception
     */
    public function create($data, $model = null)
    {
        /* @var $model MSales */
        $model = $model ? : $this->createNewModel();
        $success = false;
        $model->load($data, '');

        if (!empty($data['details'])) {
            $this->fire('_create', [$model]);
            $model->salesDtls = $data['details'];
            $success = $model->save();
            if ($success) {
                $this->fire('_created', [$model]);
            }
        } else {
            $model->validate();
            $model->addError('purchaseDtls', 'Details cannot be blank');
        }

        return $this->processOutput($success, $model);
    }

    /**
     *
     * @param  string $id
     * @param  array $data
     * @param  \biz\core\sales\models\Sales $model
     * @return \biz\core\sales\models\Sales
     * @throws \Exception
     */
    public function update($id, $data, $model = null)
    {
        $model = $model ? : $this->findModel($id);
        if ($model->status != MSales::STATUS_DRAFT) {
            throw new ServerErrorHttpException('Document can not be update');
        }
        $success = false;
        $model->load($data, '');
        if (!isset($data['details']) || $data['details'] !== []) {
            $this->fire('_update', [$model]);
            if (!empty($data['details'])) {
                $model->salesDtls = $data['details'];
            }
            $success = $model->save();
            if ($success) {
                $this->fire('_updated', [$model]);
            }
        } else {
            $model->validate();
            $model->addError('salesDtls', 'Details cannot be blank');
        }

        return $this->processOutput($success, $model);
    }

    /**
     * Delete sales
     * @param integer|string $id
     * @param MSales $model
     * @throws ServerErrorHttpException
     */
    public function delete($id, $model = null)
    {
        $model = $model ? : $this->findModel($id);
        if ($model->status != MSales::STATUS_DRAFT) {
            throw new ServerErrorHttpException('Document can not be update');
        }
        parent::delete($id, $model);
    }
}