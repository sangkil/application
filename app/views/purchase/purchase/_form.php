<?php

use yii\helpers\Html;
use mdm\widgets\TabularInput;

/* @var $this yii\web\View */
?>
<div class="purchase-hdr-form">
    <?= Html::beginForm('', 'post', []) ?>
    <div class="col-lg-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Purchase Header
            </div>
            <div class="panel-body">
                <div class="form-group field-purchase-purchase_num">
                    <label for="purchase_num" class="control-label">Purchase Num</label>
                    <input type="text" maxlength="16" readonly="" class="form-control" id="purchase_num">
                    <div class="help-block"></div>
                </div>                    
                <div class="form-group field-purchase-nmsupplier">
                    <label for="nmsupplier" class="control-label">Nama Supplier</label>
                    <input type="text" name="nm_supplier" class="form-control" id="nmsupplier">
                    <div class="help-block"></div>
                </div>
                <div class="form-group field-purchase-purchasedate">
                    <label for="purchase_date" class="control-label">Purchase Date</label>
                    <input type="text" style="width:50%" name="purchase_date" class="form-control" id="purchase_date">
                    <div class="help-block"></div>
                </div>
            </div>
            <div style="text-align: right;" class="panel-footer">
                <button class="btn btn-success" type="submit">Create</button>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="panel panel-info">
            <div class="panel-heading">
                Product :
                <input type="text" name="product" id="product">            
                <div class="pull-right">
                    Item Discount:
                    <input type="text" style="width:60px;" name="discount" id="discount">
                </div>
            </div>
            <div style="text-align: right;" class="panel-body">
                <input type="hidden" name="purchase_value" id="purchase-value">            
                <h4 style="display: none;" id="bfore">Rp 
                    <span id="purchase-val">0</span>-<span id="disc-val">0</span>
                </h4>
                <h2>Rp <span id="total-price"></span></h2>
            </div>
            <table class="table table-striped">
                <thead>
                </thead>
                <?=
                TabularInput::widget([
                    'id' => 'detail-grid',
                    'allModels' => $details,
                    'options' => ['tag' => 'tbody'],
                    'itemOptions' => ['tag' => 'tr'],
                    'itemView' => '_item_detail',
                    'clientOptions' => [
                    ]
                ])
                ?>
            </table>
        </div>
    </div>
    <?= Html::endForm() ?>
</div>