<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <h4 class="m-t-0 m-b-30 header-title"><b>Bills</b></h4>
            <?php if( $bills->count() ): ?>
                <div class="table-responsive">
                    <table class="table table-hover m-0 table table-actions-bar">
                        <thead>
                        <tr>
                            <th>Project</th>
                            <th>Supplier</th>
                            <th>Due Date</th>
                            <th>Paid</th>
                            <th class="text-right">Amount</th>
                            <th style="width: 34px"></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th colspan="4">Total</th>
                            <th class="text-right">&pound;<?php echo e(number_format($total_bills, 2)); ?></th>
                        </tr>
                        </tfoot>

                        <tbody>
                        <?php
app('blade.helpers')->get('loop')->newLoop( $bills);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $bill ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                            <tr>
                                <td><?php echo e($bill->project->name); ?></td>
                                <td>
                                    <?php if( is_object($bill->supplier) ): ?>
                                        <a href="<?php echo route('suppliers.details', $bill->supplier->id); ?>"><?php echo e($bill->supplier->name); ?></a>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo FieldRenderer::dueDate($bill->due_date); ?>

                                </td>
                                <td>
                                    <?php echo e(is_null($bill->paid_date) ? 'Unpaid' : $bill->paid_date->format('d/m/Y')); ?>

                                </td>
                                <td class="text-right">&pound;<?php echo e(number_format($bill->amount, 2)); ?></td>
                                <td style="width: 34px">
                                    <a href="<?php echo e(route('projects.bills.edit', [$bill->project->id, $bill->id])); ?>" class="btn btn-sm btn-default" title="Edit" data-animation="fadein" data-plugin="ajaxmodal" data-target="#modal-container"
                                       data-overlaySpeed="200" data-overlayColor="#36404a"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                        <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p><em>Nothing to show</em></p>
            <?php endif; ?>
        </div>
    </div>
</div>