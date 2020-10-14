<?php echo $__env->make('macros.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('macros.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->startSection('controls'); ?>
    <?php if( Permissions::has('suppliers', 'edit') || Permissions::has('suppliers', 'delete')  ): ?>
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Actions <span class="m-l-5"><i class="fa fa-wrench"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="#add-address-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Address</a>
                </li>
                <li>
                    <a href="#add-contact-modal" data-animation="fadein" data-plugin="custommodal" data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> Add Contact</a>
                </li>
                <li>
                    <a href="#" title="Verify" class="confirm-button" data-title="Verify Supplier" data-message="Are you sure you want to verify this supplier? This action cannot be undone!" data-confirm="Supplier verified!" data-href="<?php echo e(route('suppliers.verify', ['id' => $supplier->id, '_token' => csrf_token()])); ?>"><i class="md md-check"></i> Verify Supplier</a>
                </li>
                <?php if( Permissions::has('suppliers', 'delete') ): ?>
                    <li class="divider"></li>
                    <li>
                        <a href="#" title="Delete" data-title="Delete Supplier" data-message="Are you sure you want to delete this supplier? This action cannot be undone!" data-confirm="Supplier deleted!" data-redirect="<?php echo e(route('suppliers.index')); ?>" data-href="<?php echo e(route('suppliers.delete', ['id' => $supplier->id, '_token' => csrf_token()])); ?>" class="btn-danger delete-button"><i class="md md-delete"></i> Delete Supplier</a>
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

    <div class="row">

        <div class="col-lg-3 col-lg-push-9">
            <div class="card-box">
                <div>
                    <?php if( is_object($supplier->media) ): ?>
                        <?php echo app("blade.helpers")->editable_image( 'suppliers', route('media.get', [$supplier->media_id, 200, 200]), ['suppliers.media.upload', $supplier->id]); ?>
                    <?php else: ?>
                        <?php echo app("blade.helpers")->editable_image( 'suppliers', '/img/generic-supplier.png', ['suppliers.media.upload', $supplier->id]); ?>
                    <?php endif; ?>
                </div>
            </div>

            <?php if( $supplier->contacts()->count() ): ?>
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Contacts</b>
                        <?php /* <a target="_blank" class="pull-right" href="<?php echo e(route('suppliers.contacts.download', $supplier->id)); ?>" title="Download contacts"><i class="fa fa-download"></i></a> */ ?>
                    </h4>
                    <div class="inbox-widget" style="overflow: hidden;" tabindex="5001">
                        <?php
app('blade.helpers')->get('loop')->newLoop( $supplier->contacts);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $contact ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                            <div class="inbox-item">
                                <div class="inbox-item-img"><img alt="" class="img-circle" style="border: solid 2px #<?php echo e(is_object($contact->contactType) ?: '#fff'); ?>" src="<?php echo e($contact->imageUrl()); ?>"></div>
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
                                <p class="inbox-item-date">
                                    <a href="<?php echo e(route('contacts.details', $contact->id)); ?>"><i class="fa fa-pencil"></i> Edit</a>
                                </p>
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
                    <?php echo $__env->make('fragments.timeline.index', ['object' => $supplier], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-9 col-lg-pull-3">
            <div class="card-box">
                <?php if( $supplier->verified ): ?>
                    <span class="pull-right label label-success"><i class="md md-check"></i> This supplier is verified</span>
                <?php else: ?>
                    <span class="pull-right label label-danger"><i class="md md-close"></i>This supplier is unverified</span>
                <?php endif; ?>
                <h4 class="m-t-0 m-b-30 header-title"><b>Details</b></h4>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo app("blade.helpers")->editable_text( 'suppliers', 'name', 'Name', $supplier->name, route('suppliers.update', $supplier->id)); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo app("blade.helpers")->editable_text( 'suppliers', 'website', 'Website', $supplier->website, route('suppliers.update', $supplier->id)); ?>
                    </div>
                </div>
                <?php echo app("blade.helpers")->editable_textarea( 'suppliers', 'description', 'Description', $supplier->description, route('suppliers.update', $supplier->id)); ?>
                <?php echo app("blade.helpers")->editable_multiselect( 'suppliers', 'projectTypes', $project_types, 'Project Types', $supplier->projectTypes, route('suppliers.update', $supplier->id)); ?>
            </div>


            <div class="card-box">
                <?php
app('blade.helpers')->get('loop')->newLoop( $supplier->addresses);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $address ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                    <h4 class="m-t-0 m-b-30 header-title"><b>Address(s)</b></h4>
                    <p><strong><?php echo e($address->name); ?></strong> - <?php echo e($address->asString()); ?></p>
                <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
            </div>

            <?php if( Permissions::has('projects', 'view') && $supplier->projects()->count() ): ?>
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><b>Projects</b></h4>
                    <?php
app('blade.helpers')->get('loop')->newLoop( $supplier->projects);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $project ):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                        <p><a href="<?php echo route('projects.details', $project->id); ?>"><?php echo e($project->customer->name); ?> / <?php echo e($project->name); ?></a></p>
                    <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                </div>
            <?php endif; ?>

        </div>

        <?php app('blade.helpers')->get('embed')->start('fragments.page.modal', ['id' => 'add-address-modal', 'route' => ['suppliers.address.store', $supplier->id], 'files' => false, 'title' => 'Add Address', 'button' => trans('global.save')]); ?>


        <?php app('blade.helpers')->get('embed')->current()->setData($__data)->setContent(<<<'EOT_embedf4e6224d73918e4c936243aba2c38d215e0f01ffe983a'

            <?php $__env->startSection('content'); ?>

                <?php echo app("blade.helpers")->text_title( 'name', 'Address name', true); ?>
                <?php echo app("blade.helpers")->text_title( 'address1', 'Address line 1', true); ?>
                <?php echo app("blade.helpers")->text_title( 'address2', 'Address line 2'); ?>
                <?php echo app("blade.helpers")->text_title( 'town', 'Town'); ?>
                <?php echo app("blade.helpers")->text_title( 'county', 'County'); ?>
                <?php echo app("blade.helpers")->text_title( 'postcode', 'Postcode'); ?>
                <?php echo app("blade.helpers")->text_title( 'country', 'Country', true); ?>

            <?php $__env->stopSection(); ?>

        
EOT_embedf4e6224d73918e4c936243aba2c38d215e0f01ffe983a
); ?>


        <?php app('blade.helpers')->get('embed')->end(); ?>

        <?php app('blade.helpers')->get('embed')->start('fragments.page.modal', ['id' => 'add-contact-modal', 'route' => ['suppliers.contact.store', $supplier->id], 'files' => true, 'title' => 'Add Contact', 'button' => trans('global.save')]); ?>

        <?php app('blade.helpers')->get('embed')->current()->setData($__data)->setContent(<<<'EOT_embedf4e6224d73918e4c936243aba2c38d215e0f01ffe983a'

            <?php $__env->startSection('content'); ?>

                <div class="col-sm-6">
                    <?php echo app("blade.helpers")->text_title( 'first_name', 'First name', true); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo app("blade.helpers")->text_title( 'last_name', 'Last name', true); ?>
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

        
EOT_embedf4e6224d73918e4c936243aba2c38d215e0f01ffe983a
); ?>

        <?php app('blade.helpers')->get('embed')->end(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>