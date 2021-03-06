<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div>
<?php echo $interface->tabs($tabs)?>
</div>

<?php foreach ($drivers as $type => $driver) {
    ?>

    <div class="ccm-tab-content" id="ccm-tab-content-<?php echo $type?>">
        <ul class="item-select-list" id="ccm-stack-list">
            <?php foreach ($driver->getItems($set->getForm()->getEntity()) as $item) {
    ?>

                <li>
                    <a href="#"
                       data-select="control-item"
                       data-item-type="<?php echo $type?>"
                       data-item-id="<?php echo $item->getItemIdentifier()?>">
                        <?php echo $item->getIcon()?> <?php echo $item->getDisplayName()?>
                    </a>

                </li>

            <?php 
}
    ?>
        </ul>
    </div>

<?php 
} ?>

<script type="text/javascript">
$(function() {
   $('a[data-select=control-item]').on('click', function() {
       var type = $(this).attr('data-item-type'),
           id = $(this).attr('data-item-id');
       var formData = [{
           'name': 'type',
           'value': type
       },{
           'name': 'id',
           'value': id
       },{
           'name': 'ccm_token',
           'value': '<?php echo $token->generate('add_control')?>'
       }];
       jQuery.fn.dialog.showLoader();
       $.ajax({
           type: 'post',
           data: formData,
           url: '<?php echo $view->action('add_control', $set->getId())?>',
           success: function(html) {
                jQuery.fn.dialog.hideLoader();
                jQuery.fn.dialog.closeTop();
                $('div[data-field-set=<?php echo $set->getID()?>] tbody').append(html);
                $('a.dialog-launch').dialog();

               // pop open the latest control so we can edit its options immediately
               $('div[data-field-set=<?php echo $set->getID()?>] tr[data-field-set-control]:last-child a[data-command=edit-control]∫').trigger('click');

           }
       });
   });

});
</script>