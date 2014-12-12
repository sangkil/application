<?php

namespace biz\core\purchase\components;

use Yii;
use biz\core\purchase\models\Purchase as MPurchase;
use yii\web\ServerErrorHttpException;

/**
 * Description of Purchase
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class Purchase extends \biz\core\base\Api
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'biz\core\purchase\models\Purchase';

    /**
     * @inheritdoc
     */
    public $prefixEventName = 'e_purchase';

    /**
     * Use to create purchase.
     * @param array $data values use to create purchase model. It must contain
     *
     * @param \biz\core\purchase\models\Purchase $model
     *
     * @return \biz\core\purchase\models\Purchase
     * @throws \Exception
     */
    public function create($data, $model = null)
    {
        /* @var $model MPurchase */
        $model = $model ? : $this->createNewModel();
        $success = false;
        $model->load($data, '');

        if (!empty($data['details'])) {
            $this->fire('_create', [$model]);
            $model->purchaseDtls = $data['details'];
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
     * Use to update existing purchase.
     * @param array $data values use to create purchase model. It must contain
     *
     * @param \biz\core\purchase\models\Purchase $model
     *
     * @return \biz\core\purchase\models\Purchase
     * @throws \Exception
     */
    public function update($id, $data, $model = null)
    {
        $model = $model ? : $this->findModel($id);
        if ($model->status != MPurchase::STATUS_DRAFT) {
            throw new ServerErrorHttpException('Document can not be update');
        }
        $success = false;
        $model->load($data, '');
        if (!isset($data['details']) || $data['details'] !== []) {
            $this->fire('_update', [$model]);
            if (!empty($data['details'])) {
                $model->purchaseDtls = $data['details'];
            }
            $success = $model->save();
            if ($success) {
                $this->fire('_updated', [$model]);
            }
        } else {
            $model->validate();
            $model->addError('purchaseDtls', 'Details cannot be blank');
        }

        return $this->processOutput($success, $model);
    }
    
    /**
     * Delete purchase
     * @param integer|string $id
     * @param \biz\core\purchase\models\Purchase $model
     * @throws ServerErrorHttpException
     */
    public function delete($id, $model = null)
    {
        /* @var $model MPurchase */
        $model = $model ? : $this->findModel($id);
        if ($model->status != MPurchase::STATUS_DRAFT) {
            throw new ServerErrorHttpException('Document can not be delete');
        }        
        parent::delete($id, $model);
    }
}