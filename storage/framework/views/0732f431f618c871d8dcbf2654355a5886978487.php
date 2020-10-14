<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('macros.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('controls'); ?>
    <?php if( Permissions::has('customers', 'edit') || Permissions::has('contacts', 'create') || Permissions::has('customers', 'delete') ): ?>
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <?php if( Permissions::has('customers', 'edit') ): ?>
                <li>
                    <a href="#add-address-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Address</a>
                </li>
                <?php endif; ?>
                <?php if( Permissions::has('contacts', 'create') ): ?>
                <li>
                    <a href="#add-contact-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Contact</a>
                </li>
                <?php endif; ?>
                <?php if( Permissions::has('customers', 'delete') ): ?>
                    <li class="divider"></li>
                    <li>
                        <a href="#" title="Delete" data-title="Delete Customer" data-message="Are you sure you want to delete this customer? This action cannot be undone!" data-confirm="Customer deleted!" data-redirect="<?php echo e(route('customers.index')); ?>" data-href="<?php echo e(route('customers.delete', ['id' => $customer->id, '_token' => csrf_token()])); ?>" class="btn-danger delete-button"><i class="md md-delete"></i> Delete Customer</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('fragments.page.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo app("blade.helpers")->errors(); ?>
    <?php echo app("blade.helpers")->messages(); ?>

    <div class="row filedrop" data-attach-url="<?php echo e(route('customers.attachments.attach', $customer->id)); ?>" data-detach-url="<?php echo e(route('customers.attachments.detach', $customer->id)); ?>" data-token="<?php echo e(csrf_token()); ?>">

        <div class="col-lg-3 col-lg-push-9">
            <div class="card-box">
                <div>
                    <?php if( is_object($customer->media) ): ?>
                        <?php echo app("blade.helpers")->editable_image( 'customers', route('media.get', [$customer->media_id, 200, 200]), ['customers.media.upload', $customer->id]); ?>
                    <?php else: ?>
                        <?php echo app("blade.helpers")->editable_image( 'customers', '/img/generic-customer.png', ['customers.media.upload', $customer->id]); ?>
                    <?php endif; ?>
                </div>
            </div>

            <?php if( Permissions::has('contacts', 'view') && $customer->contacts()->count() ): ?>
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Contacts</b>
                        <?php /* <a target="_blank" class="pull-right" href="<?php echo e(route('customers.contacts.download', $customer->id)); ?>" title="Download contacts"><i class="fa fa-download"></i></a> */ ?>
                    </h4>
                    <div class="inbox-widget" style="overflow: hidden;" tabindex="5001">
                        <?php
app('blade.helpers')->get('loop')->newLoop( $customer->contacts);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $contact ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                            <div class="inbox-item">
                                <div class="inbox-item-img"><img alt="" class="img-circle" style="border: solid 2px #<?php echo e($contact->contactType->colour); ?>" src="<?php echo e($contact->imageUrl()); ?>"></div>
                                <p class="inbox-item-author"><?php echo e($contact->first_name); ?> <?php echo e($contact->last_name); ?></p>
                                <p class="inbox-item-text">
                                    <?php if( is_object($contact->contactType) ): ?>
                                        <?php echo e($contact->contactType->name); ?><br/>
                                    <?php endif; ?>
                                    <?php if( strlen($contact->telephone) ): ?>
                                        <i class="fa fa-mobile-phone"></i> <?php echo e($contact->telephone); ?><br/>
                                    <?php endif; ?>
                                    <?php if( strlen($contact->mobile) ): ?>
                                        <i class="fa fa-mobile-telephone"></i> <?php echo e($contact->mobile); ?><br/>
                                    <?php endif; ?>
                                    <?php if( strlen($contact->email) ): ?>
                                        <a href="mailto:<?php echo e($contact->email); ?>"><i class="fa fa-envelope"></i> <?php echo e($contact->email); ?></a><br/>
                                    <?php endif; ?>
                                </p>
                                <?php if( Permissions::has('contacts', 'edit') ): ?>
                                    <p class="inbox-item-date">
                                        <a href="<?php echo e(route('contacts.details', $contact->id)); ?>"><i class="fa fa-pencil"></i> Edit</a>
                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if( Permissions::has('timeline', 'view') ): ?>
                <div class="card-box">
                    <?php echo $__env->make('fragments.timeline.index', ['object' => $customer], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-9 col-lg-pull-3">
            <div class="card-box">
                <h4 class="m-t-0 m-b-30 header-title"><b>Details</b></h4>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo app("blade.helpers")->editable_select( 'customers', 'category_id', $customer_types, 'Type', $customer->category, route('customers.update', $customer->id)); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo app("blade.helpers")->editable_text( 'customers', 'website', 'Website', $customer->website, route('customers.update', $customer->id)); ?>
                    </div>
                </div>
                <?php echo app("blade.helpers")->editable_text( 'customers', 'name', 'Name', $customer->name, route('customers.update', $customer->id)); ?>
                <?php echo app("blade.helpers")->editable_textarea( 'customers', 'description', 'Description', $customer->description, route('customers.update', $customer->id)); ?>
            </div>

            <?php
app('blade.helpers')->get('loop')->newLoop( $customer->addresses);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $address ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>

                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b><?php echo e($address->name); ?></b></h4>
                    <p><?php echo e($address->asString()); ?></p>
                </div>

            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>

            <?php if( Permissions::has('projects', 'view') && $customer->projects()->count() ): ?>
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Projects</b></h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th class="hidden-xs">Type(s)</th>
                                <?php if( Permissions::has('finance', 'view') ): ?>
                                    <th class="hidden-xs text-right">Value</th>
                                <?php endif; ?>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
app('blade.helpers')->get('loop')->newLoop( $customer->projects);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $project ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                <tr>
                                    <td>
                                        <a href="<?php echo route('projects.details', $project->id); ?>"><?php echo e($project->name); ?>

                                            <?php if( $project->children()->count() ): ?>
                                                <span class="badge badge-default"><?php echo e($project->children()->count()); ?></span>
                                            <?php endif; ?>
                                        </a>
                                    </td>
                                    <td class="hidden-xs">
                                        <?php if( $project->status == 'prospect' || $project->status == 'lost' ): ?>
                                            <?php if( is_object($project->prospectStatus) ): ?>
                                                <span class="label" style="background-color:#<?php echo e($project->prospectStatus->colour); ?>"><?php echo e($project->prospectStatus->name); ?></span>
                                            <?php else: ?>
                                                <span class="label label-danger">None</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if( is_object($project->projectStatus) ): ?>
                                                <span class="label" style="background-color:#<?php echo e($project->projectStatus->colour); ?>"><?php echo e($project->projectStatus->name); ?></span>
                                            <?php else: ?>
                                                <span class="label label-danger">None</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="hidden-xs">
                                        <?php
app('blade.helpers')->get('loop')->newLoop( $project->types);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $project_type ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                            <span class="label label-default"><?php echo e($project_type->name); ?></span>
                                        <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                                    </td>
                                    <?php if( Permissions::has('finance', 'view') ): ?>
                                        <td class="hidden-xs text-right">
                                            <?php echo e(FieldRenderer::formatCurrency($project->costs()->sum('value'))); ?>

                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <?php if( Permissions::has('leads', 'view') && $customer->prospects()->count() ): ?>
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Prospects</b></h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th class="hidden-xs">Type(s)</th>
                                <?php if( Permissions::has('finance', 'view') ): ?>
                                    <th class="hidden-xs text-right">Value</th>
                                <?php endif; ?>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
app('blade.helpers')->get('loop')->newLoop( $customer->prospects);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $project ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                <tr>
                                    <td>
                                        <a href="<?php echo route('projects.details', $project->id); ?>"><?php echo e($project->name); ?>

                                            <?php if( $project->children()->count() ): ?>
                                                <span class="badge badge-default"><?php echo e($project->children()->count()); ?></span>
                                            <?php endif; ?>
                                        </a>
                                    </td>
                                    <td class="hidden-xs">
                                        <?php if( $project->status == 'prospect' || $project->status == 'lost' ): ?>
                                            <?php if( is_object($project->prospectStatus) ): ?>
                                                <span class="label" style="background-color:#<?php echo e($project->prospectStatus->colour); ?>"><?php echo e($project->prospectStatus->name); ?></span>
                                            <?php else: ?>
                                                <span class="label label-danger">None</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if( is_object($project->projectStatus) ): ?>
                                                <span class="label" style="background-color:#<?php echo e($project->projectStatus->colour); ?>"><?php echo e($project->projectStatus->name); ?></span>
                                            <?php else: ?>
                                                <span class="label label-danger">None</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="hidden-xs">
                                        <?php
app('blade.helpers')->get('loop')->newLoop( $project->types);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $project_type ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                            <span class="label label-default"><?php echo e($project_type->name); ?></span>
                                        <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                                    </td>
                                    <?php if( Permissions::has('finance', 'view') ): ?>
                                        <td class="hidden-xs text-right">
                                            <?php echo e(FieldRenderer::formatCurrency($project->costs()->sum('value'))); ?>

                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <?php if( Permissions::has('tasks', 'view') && $tasks->count() ): ?>
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Tasks</b></h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th class="hidden-xs">Project</th>
                                <th class="hidden-xs">Assignee(s)</th>
                                <th class="hidden-xs">Type</th>
                                <th>Priority</th>
                                <th>Status</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
app('blade.helpers')->get('loop')->newLoop( $tasks);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $task ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                                <tr>
                                    <td>
                                        <a href="<?php echo route('tasks.details', $task->id); ?>"><?php echo e($task->title); ?>

                                            <?php if( $task->children()->count() ): ?>
                                                <span class="badge badge-default"><?php echo e($task->children()->count()); ?></span>
                                            <?php endif; ?>
                                        </a>
                                    </td>
                                    <td class="hidden-xs">
                                        <?php if( is_object($task->project) ): ?>
                                            <a href="<?php echo e(route('projects.details', $task->project->id)); ?>"><?php echo e($task->project->name); ?></a>
                                        <?php else: ?>
                                            None
                                        <?php endif; ?>
                                    </td>
                                    <td class="hidden-xs">
                                        <?php echo FieldRenderer::users($task->assignees); ?>

                                    </td>
                                    <td class="hidden-xs">
                                        <?php if( is_object($task->taskType) ): ?>
                                            <span class="label label-default" style="background-color: #<?php echo e($task->taskType->colour); ?>"><?php echo e($task->taskType->name); ?></span>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo e(array_get(App\Models\Task::$priorities, $task->priority, 'Default')); ?>

                                    </td>
                                    <td>
                                        <?php if( is_object($task->taskStatus) ): ?>
                                            <span class="label label-default" style="background-color: #<?php echo e($task->taskStatus->colour); ?>"><?php echo e($task->taskStatus->name); ?></span>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
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
                </div>
            <?php endif; ?>

            <?php echo $__env->make('fragments.media.attachments', ['object' => $customer], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <?php echo $__env->make('fragments.notes.notes', ['route' => ['customers.notes.add', $customer->id], 'search_route' => ['customers.notes.search', $customer->id]], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <?php if( Permissions::has('customers', 'edit') ): ?>
        <?php app('blade.helpers')->get('embed')->start('fragments.page.modal', ['id' => 'add-address-modal', 'route' => ['customers.address.store', $customer->id], 'files' => false, 'title' => 'Add Address', 'button' => trans('global.save')]); ?>

        <?php app('blade.helpers')->get('embed')->current()->setData($__data)->setContent(<<<'EOT_embed7a46b23d850fdd572595ed55439c44dc5b8800411e4f2'

            <?php $__env->startSection('content'); ?>

                <?php echo app("blade.helpers")->text_title( 'name', 'Address name', true); ?>
                <?php echo app("blade.helpers")->text_title( 'address1', 'Address line 1', true); ?>
                <?php echo app("blade.helpers")->text_title( 'address2', 'Address line 2'); ?>
                <?php echo app("blade.helpers")->text_title( 'town', 'Town', true); ?>
                <?php echo app("blade.helpers")->text_title( 'county', 'County', true); ?>
                <?php echo app("blade.helpers")->text_title( 'postcode', 'Postcode', true); ?>
                <?php echo app("blade.helpers")->text_title( 'country', 'Country', true); ?>

            <?php $__env->stopSection(); ?>

        
EOT_embed7a46b23d850fdd572595ed55439c44dc5b8800411e4f2
); ?>

        <?php app('blade.helpers')->get('embed')->end(); ?>
    <?php endif; ?>

    <?php if( Permissions::has('contacts', 'create') ): ?>
        <?php app('blade.helpers')->get('embed')->start('fragments.page.modal', ['id' => 'add-contact-modal', 'route' => ['customers.contact.store', $customer->id], 'files' => true, 'title' => 'Add Contact', 'button' => trans('global.save')]); ?>

        <?php app('blade.helpers')->get('embed')->current()->setData($__data)->setContent(<<<'EOT_embed7a46b23d850fdd572595ed55439c44dc5b8800411e4f2'

            <?php $__env->startSection('content'); ?>

                <div class="col-sm-6">
                    <?php echo app("blade.helpers")->text_title( 'first_name', 'First name', true); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo app("blade.helpers")->text_title( 'last_name', 'Last name', false); ?>
                </div>

                <div class="col-sm-6">
                    <?php echo app("blade.helpers")->select_title( 'type_id', $contact_types, 'Contact type', true); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo app("blade.helpers")->image_title( 'media', 'Image'); ?>
                </div>

                <div class="col-sm-6">
                    <?php echo app("blade.helpers")->text_title( 'telephone', 'Telephone'); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo app("blade.helpers")->text_title( 'mobile', 'Mobile'); ?>
                </div>
                <div class="col-sm-12">
                    <?php echo app("blade.helpers")->text_title( 'email', 'Email address'); ?>
                </div>
                <div class="col-sm-12">
                    <?php echo app("blade.helpers")->textarea_title( 'description', 'Description'); ?>
                </div>

            <?php $__env->stopSection(); ?>

        
EOT_embed7a46b23d850fdd572595ed55439c44dc5b8800411e4f2
); ?>

        <?php app('blade.helpers')->get('embed')->end(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>