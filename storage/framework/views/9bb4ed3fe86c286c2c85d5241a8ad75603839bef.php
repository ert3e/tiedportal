

<?php /* <table class="table financial-table">
    <form class="" action="" method="post">
    <tr>
        <th colspan="2" rowspan="2" class="text-right no-border">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="start_date" value="<?php echo e($start_date->format('Y-m')); ?>" />
            <input type="hidden" name="end_date" value="<?php echo e($end_date->format('Y-m')); ?>" />
            <button class="btn btn-default">Recalculate <i class="fa fa-calculator"></i></button>
        </th>
        <td colspan="2" class="no-border" style="padding-left: 0">
            <div class="input-group n">
                <span class="input-group-addon" id="basic-addon2">From</span>
                <?php echo Form::select('start_date', $date_options, $start_date->format('Y-m'), ['class' => 'form-control']); ?>

            </div>
        </td>
        <td class="no-border" colspan="2" style="padding-right: 0">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon2">To</span>
                <?php echo Form::select('end_date', $date_options, $end_date->format('Y-m'), ['class' => 'form-control']); ?>

            </div>
        </td>
    </tr>
    <tr>
        <td class="prospect-col">
            <input type="hidden" name="check_prospects" value="0" />
            <input type="checkbox" <?php if(old('check_prospects', isset($check_prospects) && $check_prospects)): ?> checked="checked" <?php endif; ?>  name="check_prospects" value="1" title="Select to include prospects on chart and calculations below" />
        </td>
        <td class="active-col">
            <input type="hidden" name="check_active" value="0" />
            <input type="checkbox" <?php if(old('check_prospects', isset($check_active) && $check_active)): ?> checked="checked" <?php endif; ?>  name="check_active" value="1" title="Select to include active on chart and calculations below" />
        </td>
        <td class="lost-col">
            <input type="hidden" name="check_lost" value="0" />
            <input type="checkbox" <?php if(old('check_lost', isset($check_lost) && $check_lost)): ?> checked="checked" <?php endif; ?>  name="check_lost" value="1" title="Select to include lost on chart and calculations below" />
        </td>
        <td class="complete-col">
            <input type="hidden" name="check_complete" value="0" />
            <input type="checkbox" <?php if(old('check_complete', isset($check_complete) && $check_complete)): ?> checked="checked" <?php endif; ?>  name="check_complete" value="1" title="Select to include complete on chart and calculations below" />
        </td>
    </tr>
    </form>
</table> */ ?>



<table class="table financial-table">
    <colgroup>
        <col />
        <col />
        <col  class="prospect-col"/>
        <col  class="active-col"/>
        <col  class="lost-col"/>
        <col  class="complete-col"/>
    </colgroup>
    <tr>
        <th class="no-border">
        </th>
        <th>
        </th>
        <th>
            Prospects
        </th>
        <th>
            Active
        </th>
        <th>
            Lost
        </th>
        <th>
            Complete
        </th>
    </tr>
    <tr>
        <th class="no-border big-th" rowspan="4">
            Sum
        </th>
        <th class="text-right">
            No
        </th>
        <td>
            <strong><?php echo e($prospectsSum['no']); ?></strong>
        </td>
        <td>
            <strong><?php echo e($activeSum['no']); ?></strong>
        </td>
        <td>
            <strong><?php echo e($lostSum['no']); ?></strong>
        </td>
        <td>
            <strong><?php echo e($completedSum['no']); ?></strong>
        </td>
    </tr>
    <tr>

        <th class="text-right">
            Revenue
        </th>
        <td>
            <strong>&pound;<?php echo e($prospectsSum['revenue']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($activeSum['revenue']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($lostSum['revenue']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($completedSum['revenue']); ?></strong>
        </td>
    </tr>
    <tr>

        <th class="text-right">
            Profit
        </th>
        <td>
            <strong>&pound;<?php echo e($prospectsSum['profit']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($activeSum['profit']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($lostSum['profit']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($completedSum['profit']); ?></strong>
        </td>
    </tr>
    <tr>
        <th class="text-right">
            Costs
        </th>
        <td>
            <strong>&pound;<?php echo e($prospectsSum['cost']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($activeSum['cost']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($lostSum['cost']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($completedSum['cost']); ?></strong>
        </td>
    </tr>

    <tr>
        <td colspan="6" class="no-border">

        </td>
    </tr>
    <tr>
        <th class="no-border big-th" rowspan="3">
            Avg
        </th>

        <th class="text-right">
            Revenue
        </th>
        <td>
            <strong>&pound;<?php echo e($prospectsSum['revenue_avg']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($activeSum['revenue_avg']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($lostSum['revenue_avg']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($completedSum['revenue_avg']); ?></strong>
        </td>
    </tr>

    <tr>

        <th class="text-right">
            Profit
        </th>
        <td>
            <strong>&pound;<?php echo e($prospectsSum['profit_avg']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($activeSum['profit_avg']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($lostSum['profit_avg']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($completedSum['profit_avg']); ?></strong>
        </td>
    </tr>
    <tr>
        <th class="text-right">
            Costs
        </th>
        <td>
            <strong>&pound;<?php echo e($prospectsSum['cost_avg']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($activeSum['cost_avg']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($lostSum['cost_avg']); ?></strong>
        </td>
        <td>
            <strong>&pound;<?php echo e($completedSum['cost_avg']); ?></strong>
        </td>
    </tr>
</table>
