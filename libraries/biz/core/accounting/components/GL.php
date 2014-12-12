<?php

namespace biz\core\accounting\components;

use biz\core\accounting\models\GlHeader;
use biz\core\accounting\models\EntriSheet;
use yii\base\UserException;
use yii\base\NotSupportedException;

/**
 * Description of GL
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  * @since 3.0
 */
class GL extends \biz\core\base\Api
{
    /**
     *
     * @var string 
     */
    public $modelClass = 'biz\core\accounting\models\GlHeader';

    /**
     *
     * @var string 
     */
    public $prefixEventName = 'e_gl';

    /**
     *
     * @param  array                            $data
     * @param  \biz\core\accounting\models\GlHeader $model
     * @return \biz\core\accounting\models\GlHeader
     */
    public function create($data, $model = null)
    {
        /* @var $model GlHeader */
        $model = $model ? : $this->createNewModel();
        $success = false;
        $model->scenario = GlHeader::SCENARIO_DEFAULT;
        $model->load($data, '');
        if (!empty($data['details'])) {
            $amount = 0;
            foreach ($data['details'] as $dataDetail) {
                $amount += $dataDetail['amount'];
            }
            if ($amount == 0) {
                $this->fire('_create', [$model]);
                $success = $model->save();
                $success = $model->saveRelated('glDetails', $data, $success, 'details');
                if ($success) {
                    $this->fire('_created', [$model]);
                } else {
                    if ($model->hasRelatedErrors('glDetails')) {
                        $model->addError('details', 'Details validation error');
                    }
                }
            } else {
                $model->validate();
                $model->addError('details', 'Not balance');
            }
        } else {
            $model->validate();
            $model->addError('details', 'Details cannot be blank');
        }

        return $this->processOutput($success, $model);
    }

    /**
     *
     * @param  array                            $data
     * @param  \biz\core\accounting\models\GlHeader $model
     * @return \biz\core\accounting\models\GlHeader
     * @throws UserException
     */
    public function createFromEntrysheet($data, $model = null)
    {
        $es = $data['entry_sheet'];
        if (!$es instanceof EntriSheet) {
            $es = EntriSheet::findOne($es);
        }
        $values = $data['values'];
        unset($data['entry_sheet'], $data['values']);
        $details = [];
        foreach ($es->entriSheetDtls as $esDetail) {
            $nm = $esDetail->cd_esheet_dtl;
            if (isset($values[$nm])) {
                $details[] = [
                    'id_coa' => $esDetail->id_coa,
                    'amount' => $values[$nm]
                ];
            }
        }
        $data['details'] = $details;

        return $this->create($data, $model);
    }

    public function update($id, $data, $model = null)
    {
        throw new NotSupportedException();
    }

    public function delete($id, $model = null)
    {
        throw new NotSupportedException();
    }
}