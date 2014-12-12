<?php

namespace biz\core\inventory\components;

use Yii;
use biz\core\inventory\models\Transfer as MTransfer;
use yii\web\ServerErrorHttpException;

/**
 * Description of InventoryTransfer
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class Transfer extends \biz\core\base\Api
{
    /**
     *
     * @var string 
     */
    public $modelClass = 'biz\core\inventory\models\Transfer';

    /**
     *
     * @var string 
     */
    public $prefixEventName = 'e_transfer';

    /**
     * 
     * @param type $data
     * @param \biz\core\inventory\models\Transfer $model
     * @return type
     */
    public function create($data, $model = null)
    {
        /* @var $model MTransfer */
        $model = $model ? : $this->createNewModel();
        $success = false;
        $model->load($data, '');

        if (!empty($data['details'])) {
            $this->fire('_create', [$model]);
            $model->transferDtls = $data['details'];
            $success = $model->save();
            if ($success) {
                $this->fire('_created', [$model]);
            }
        } else {
            $model->validate();
            $model->addError('transferDtls', 'Details cannot be blank');
        }

        return $this->processOutput($success, $model);
    }

    public function update($id, $data, $model = null)
    {
        /* @var $model MTransfer */
        $model = $model ? : $this->findModel($id);
        if ($model->status != MTransfer::STATUS_DRAFT) {
            throw new ServerErrorHttpException('Document can not be update');
        }
        $success = false;
        $model->load($data, '');
        if (!isset($data['details']) || $data['details'] !== []) {
            $this->fire('_update', [$model]);
            if (!empty($data['details'])) {
                $model->transferDtls = $data['details'];
            }
            $success = $model->save();
            if ($success) {
                $this->fire('_updated', [$model]);
            }
        } else {
            $model->validate();
            $model->addError('transferDtls', 'Details cannot be blank');
        }

        return $this->processOutput($success, $model);
    }
    
    /**
     * 
     * @param type $id
     * @param \biz\core\inventory\models\Transfer $model
     * @throws ServerErrorHttpException
     */
    public function delete($id, $model = null)
    {
        /* @var $model MTransfer */
        $model = $model ? : $this->findModel($id);
        if ($model->status != MTransfer::STATUS_DRAFT) {
            throw new ServerErrorHttpException('Document can not be delete');
        }        
        parent::delete($id, $model);
    }
}