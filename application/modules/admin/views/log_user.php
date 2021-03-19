<?php require APPPATH . 'views/inc/_global/config.php'; ?>
<?php require APPPATH . 'views/inc/admin/config.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/head_start.php'; ?>
<?php $one->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $one->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>
<?php $one->get_css('js/plugins/select2/css/select2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/head_end.php'; ?>
<?php $one->get_css('js/plugins/sweetalert2/sweetalert2.min.css'); ?>
<?php require APPPATH . 'views/inc/_global/views/page_start.php'; ?>

<!-- Page Content -->
<div class="content">
    <div class="row">
        <div class="col-md-12 col-12">
            <!-- Message List -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">

                    </h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="tooltip" data-placement="left"
                            title="Previous 15 Messages">
                            <i class="si si-arrow-left"></i>
                        </button>
                        <button type="button" class="btn-block-option" data-toggle="tooltip" data-placement="left"
                            title="Next 15 Messages">
                            <i class="si si-arrow-right"></i>
                        </button>
                        <button type="button" class="btn-block-option" data-toggle="block-option"
                            data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                        <button type="button" class="btn-block-option" data-toggle="block-option"
                            data-action="fullscreen_toggle"></button>
                    </div>
                </div>
                <div class="block-content">
                    <!-- Messages Options -->
                    <div class="d-flex justify-content-between push">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-light" type="button">
                                <i class="fa fa-archive text-primary"></i>
                                <span class="d-none d-sm-inline ml-1">Archive</span>
                            </button>
                            <button class="btn btn-sm btn-light" type="button">
                                <i class="fa fa-star text-warning"></i>
                                <span class="d-none d-sm-inline ml-1">Star</span>
                            </button>
                        </div>
                        <button class="btn btn-sm btn-light" type="button">
                            <i class="fa fa-times text-danger"></i>
                            <span class="d-none d-sm-inline ml-1">Delete</span>
                        </button>
                    </div>
                    <!-- END Messages Options -->

                    <!-- Messages and Checkable Table (.js-table-checkable class is initialized in Helpers.tableToolsCheckable()) -->
                    <div class="pull-x">
                        <table class="js-table-checkable table table-hover table-vcenter font-size-sm">
                            <tbody>
                                <tr>
                                    <td class="text-center" style="width: 60px;">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="inbox-msg15"
                                                name="inbox-msg15">
                                            <label class="custom-control-label font-w400" for="inbox-msg15"></label>
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell font-w600" style="width: 140px;">
                                        <?php $one->get_name(); ?></td>
                                    <td>
                                        <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message"
                                            href="#">Welcome to our service</a>
                                        <div class="text-muted mt-1">It's a pleasure to have you on our service..</div>
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted" style="width: 80px;">
                                        <i class="fa fa-paperclip mr-1"></i> (3)
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted" style="width: 120px;">
                                        <em>2 min ago</em>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="inbox-msg14"
                                                name="inbox-msg14">
                                            <label class="custom-control-label font-w400" for="inbox-msg14"></label>
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell font-w600"><?php $one->get_name(); ?></td>
                                    <td>
                                        <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message"
                                            href="#">Your subscription was updated</a>
                                        <div class="text-muted mt-1">We are glad you decided to go with a vip..</div>
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <i class="fa fa-paperclip mr-1"></i> (2)
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <em>10 min ago</em>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="inbox-msg13"
                                                name="inbox-msg13">
                                            <label class="custom-control-label font-w400" for="inbox-msg13"></label>
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell font-w600"><?php $one->get_name(); ?></td>
                                    <td>
                                        <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message"
                                            href="#">Update is available</a>
                                        <div class="text-muted mt-1">An update is under way for your app..</div>
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted"></td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <em>25 min ago</em>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="inbox-msg12"
                                                name="inbox-msg12">
                                            <label class="custom-control-label font-w400" for="inbox-msg12"></label>
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell font-w600"><?php $one->get_name(); ?></td>
                                    <td>
                                        <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message"
                                            href="#">New Sale!</a>
                                        <div class="text-muted mt-1">You had a new sale and earned..</div>
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <i class="fa fa-paperclip mr-1"></i> (1)
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <em>30 min ago</em>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="inbox-msg11"
                                                name="inbox-msg11">
                                            <label class="custom-control-label font-w400" for="inbox-msg11"></label>
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell font-w600"><?php $one->get_name(); ?></td>
                                    <td>
                                        <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message"
                                            href="#">Action Required for your account!</a>
                                        <div class="text-muted mt-1">Your account is inactive for a long time and..
                                        </div>
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted"></td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <em>1 hour ago</em>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="inbox-msg10"
                                                name="inbox-msg10">
                                            <label class="custom-control-label font-w400" for="inbox-msg10"></label>
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell font-w600"><?php $one->get_name(); ?></td>
                                    <td>
                                        <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message"
                                            href="#">New Photo Pack!</a>
                                        <div class="text-muted mt-1">Our new photo pack is available now! You..</div>
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted"></td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <em>2 hrs ago</em>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="inbox-msg9"
                                                name="inbox-msg9">
                                            <label class="custom-control-label font-w400" for="inbox-msg9"></label>
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell font-w600"><?php $one->get_name(); ?></td>
                                    <td>
                                        <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message"
                                            href="#">Product is released!</a>
                                        <div class="text-muted mt-1">This is a notification about our new product..
                                        </div>
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <i class="fa fa-paperclip mr-1"></i> (1)
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <em>1 day ago</em>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="inbox-msg8"
                                                name="inbox-msg8">
                                            <label class="custom-control-label font-w400" for="inbox-msg8"></label>
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell font-w600"><?php $one->get_name(); ?></td>
                                    <td>
                                        <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message"
                                            href="#">Now on Sale!</a>
                                        <div class="text-muted mt-1">Our Book is out! You can buy a copy and..</div>
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <i class="fa fa-paperclip mr-1"></i> (9)
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <em>1 day ago</em>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="inbox-msg7"
                                                name="inbox-msg7">
                                            <label class="custom-control-label font-w400" for="inbox-msg7"></label>
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell font-w600"><?php $one->get_name(); ?></td>
                                    <td>
                                        <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message"
                                            href="#">Monthly Report</a>
                                        <div class="text-muted mt-1">The monthly report you requested for..</div>
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <i class="fa fa-paperclip mr-1"></i> (6)
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <em>3 days ago</em>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="inbox-msg6"
                                                name="inbox-msg6">
                                            <label class="custom-control-label font-w400" for="inbox-msg6"></label>
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell font-w600"><?php $one->get_name(); ?></td>
                                    <td>
                                        <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message"
                                            href="#">Trial Started!</a>
                                        <div class="text-muted mt-1">You 30-day trial has now started and..</div>
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted"></td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <em>3 days ago</em>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="inbox-msg5"
                                                name="inbox-msg5">
                                            <label class="custom-control-label font-w400" for="inbox-msg5"></label>
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell font-w600"><?php $one->get_name(); ?></td>
                                    <td>
                                        <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message"
                                            href="#">Invoice #INV001645</a>
                                        <div class="text-muted mt-1">This is the invoice for the project we..</div>
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted"></td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <em>5 days ago</em>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="inbox-msg4"
                                                name="inbox-msg4">
                                            <label class="custom-control-label font-w400" for="inbox-msg4"></label>
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell font-w600"><?php $one->get_name(); ?></td>
                                    <td>
                                        <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message"
                                            href="#">Friend Request!</a>
                                        <div class="text-muted mt-1">You have a new friend request. Click the..</div>
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <i class="fa fa-paperclip mr-1"></i> (5)
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <em>1 week ago</em>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="inbox-msg3"
                                                name="inbox-msg3">
                                            <label class="custom-control-label font-w400" for="inbox-msg3"></label>
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell font-w600"><?php $one->get_name(); ?></td>
                                    <td>
                                        <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message"
                                            href="#">Enjoy life!</a>
                                        <div class="text-muted mt-1">Thank you for helping us with our cause...</div>
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <i class="fa fa-paperclip mr-1"></i> (3)
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <em>1 week ago</em>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="inbox-msg2"
                                                name="inbox-msg2">
                                            <label class="custom-control-label font-w400" for="inbox-msg2"></label>
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell font-w600"><?php $one->get_name(); ?></td>
                                    <td>
                                        <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message"
                                            href="#">New Twitter follower!</a>
                                        <div class="text-muted mt-1">You have a new follower, congratulations..</div>
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <i class="fa fa-paperclip mr-1"></i> (1)
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <em>2 weeks ago</em>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="inbox-msg1"
                                                name="inbox-msg1">
                                            <label class="custom-control-label font-w400" for="inbox-msg1"></label>
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell font-w600"><?php $one->get_name(); ?></td>
                                    <td>
                                        <a class="font-w600" data-toggle="modal" data-target="#one-inbox-message"
                                            href="#">Huge Discount available!</a>
                                        <div class="text-muted mt-1">Due to the fact that you are a great..</div>
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted"></td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        <em>3 weeks ago</em>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- END Messages and Checkable Table -->
                </div>
            </div>
            <!-- END Message List -->
        </div>
    </div>
</div>
<!-- END Page Content -->


<?php require APPPATH . 'views/inc/_global/views/page_end.php'; ?>
<?php require APPPATH . 'views/inc/_global/views/footer_start.php'; ?>
<?php $one->get_js('js/plugins/sweetalert2/sweetalert2.js'); ?>
<?php $one->get_js('toastr/script.js'); ?>
<?php require APPPATH . 'views/inc/_global/views/footer_end.php'; ?>