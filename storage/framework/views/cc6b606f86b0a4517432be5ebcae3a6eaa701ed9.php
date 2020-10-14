<div class="row">
    <div class="col-md-12">
        <div class="text-center">
            <ul class="list-inline chart-detail-list">
                <?php /* <li>
                    <h5><i class="fa fa-circle m-r-5" style="color: #36404a;"></i>Value</h5>
                </li> */ ?>
                <li>
                    <h5><i class="fa fa-circle m-r-5" style="color: #5d9cec;"></i>Cost</h5>
                </li>
                <li>
                    <h5><i class="fa fa-circle m-r-5" style="color: #bbbbbb;"></i>Profit</h5>
                </li>
            </ul>
        </div>
        <div id="morris-area-with-dotted" style="height: 300px;"></div>
    </div>
</div>
<script type="application/javascript">
<?php $__env->startSection('script'); ?>
    !function($) {
        "use strict";

        var Dashboard2 = function() {
            this.$realData = []
        };

        //creates area chart with dotted
        Dashboard2.prototype.createAreaChartDotted = function(element, pointSize, lineWidth, data, xkey, ykeys, labels, Pfillcolor, Pstockcolor, lineColors) {

            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            Morris.Area({
                element: element,
                pointSize: 0,
                lineWidth: 0,
                data: data,
                xkey: xkey,
                ykeys: ykeys,
                labels: labels,
                hideHover: 'auto',
                pointFillColors: Pfillcolor,
                pointStrokeColors: Pstockcolor,
                resize: true,
                preUnits: '\xa3',
                xLabels: "month",
                gridLineColor: '#eef0f2',
                lineColors: lineColors,
                xLabelFormat: function (x) { return months[x.getMonth()]; }
            });

        },
        Dashboard2.prototype.init = function() {

            var $areaDotData = [
                <?php
app('blade.helpers')->get('loop')->newLoop( $sales);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $sale ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                // { month: '<?php echo e($sale['date']->format('Y-m-d')); ?>', a: <?php echo e($sale['value']); ?>, b: <?php echo e($sale['cost']); ?>, c:<?php echo e($sale['profit']); ?> },
                { month: '<?php echo e($sale['date']->format('Y-m-d')); ?>', a: <?php echo e($sale['cost']); ?>, b:<?php echo e($sale['profit']); ?> },
                <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
            ];
            this.createAreaChartDotted('morris-area-with-dotted', 0, 0, $areaDotData, 'month', ['a', 'b'], ['Cost', 'Profit'],['#ffffff'],['#999999'], ['#36404a', '#5d9cec','#bbbbbb']);
            // this.createAreaChartDotted('morris-area-with-dotted', 0, 0, $areaDotData, 'month', ['a', 'b', 'c'], ['Value', 'Cost', 'Profit'],['#ffffff'],['#999999'], ['#36404a', '#5d9cec','#bbbbbb']);

        },
        //init
        $.Dashboard2 = new Dashboard2, $.Dashboard2.Constructor = Dashboard2
    }(window.jQuery),

    function($) {
        "use strict";
        $.Dashboard2.init();
    }(window.jQuery);
<?php $__env->stopSection(); ?>
</script>
