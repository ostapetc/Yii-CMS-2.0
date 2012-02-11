<li><?php echo CHtml::link('Cabinet', '#cabinet', array('data-toggle'=> "modal")); ?></li>
<li><?php echo CHtml::link('Logout', array('/users/user/logout'), array('data-toggle'=> "modal")); ?></li>
<div class="modal hide fade" id="cabinet">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>

        <h3><?php echo $title ?></h3>
    </div>
    <div class="modal-body">

    </div>
    <div class="modal-footer">
        <!--        <a href="#" class="btn btn-primary">Save changes</a>-->
        <!--        <a href="#" class="btn">Close</a>-->
    </div>
</div>