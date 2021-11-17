<style type="text/css">
    
    .table .pull-right {text-align: initial; width: auto; float: right !important}
    .alert-warning{ overflow: hidden;text-overflow: ellipsis;}
</style>
<div class="content-wrapper" style="min-height: 946px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-gears"></i> <?php echo $this->lang->line('system_settings'); ?><small><?php echo $this->lang->line('setting1'); ?></small>        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-language"></i> <?php echo 'School List'; ?></h3>

                        <div class="box-tools pull-right">
                            <div class="box-tools pull-right">
                                <a href="<?php echo base_url(); ?>schsettings/addschool" class="btn btn-primary btn-sm" data-placement="left" data-toggle="tooltip" title="<?php echo "Add New School"  ?>" >
                                    <i class="fa fa-plus"></i> <?php echo "Add New School" ?>
                                </a>
                            </div>
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                       
                        <?php if ($this->session->flashdata('msg')) { ?>
                            <?php echo $this->session->flashdata('msg') ?>
                        <?php } ?>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo 'School name'; ?></th>
                                        <th><?php echo 'Email'; ?></th>
                                        <th><?php echo 'Address' ?></th>
                                         <!-- <th><?php echo 'status' ?></th> -->
                                         <th><?php echo 'Phone No' ?></th>
                                        <th class="text-right"><?php echo'action' ?></th>
                                    </tr>
                                    <tbody id="result_data">

                                    <?php  
                                foreach ($result->result() as $row)  
                                {  
                                    ?><tr>  
                                    <td><?php echo $row->id;?></td>  
                                    <td><?php echo $row->name;?></td>  
                                    <td><?php echo $row->email;?></td>  
                                    <td><?php echo $row->address;?></td> 
                                    <td><?php echo $row->phone;?></td> 
                                    <td>
                                    <a href="<?php echo site_url('schsettings/edit/'.$row->id); ?>">Edit</a> | 
                                    <a href="<?php echo site_url('schsettings/deleteschool/'.$row->id); ?>" onClick="return confirm('Are you sure you want to delete?')">Delete</a>
                                </td> 
                                    </tr>  
                                <?php }  
                                ?>  
                                </tbody>
                            </table><!-- /.table -->
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <div class="mailbox-controls">
                        </div>
                    </div>
                </div>
            </div>
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var onload=  $('#languageSwitcher').val();
      //load();
        $(document).on('click', '.chk', function () {
            var checked = $(this).is(':checked');
           
            var rowid = $(this).data('rowid');
            var role = $(this).data('role');
            var confirm_msg='<?php echo $this->lang->line('confirm_msg') ?>';
           
            if (checked) {

                if (!confirm(confirm_msg)) {
                    $(this).removeAttr('checked');

                } else {
                    var status = "yes";

                    if(role=='2'){
                        changeStatusselect(rowid);
                    }else{
                        changeStatusunselect(rowid);
                    }

                }

            } else if (!confirm(confirm_msg)) {

                $(this).prop("checked", true);
            } else {
                
                var status = "no";
                if(role=='2'){
                        changeStatusselect(rowid);
                    }else{
                        changeStatusunselect(rowid);
                    }

            }
        });
    });

    function changeStatusselect(rowid) {

        var base_url = '<?php echo base_url() ?>';

        $.ajax({
            type: "POST",
            url: base_url + "admin/language/select_language/"+rowid,
            data: {},
            
            success: function (data) {
                successMsg("Status Change Successfully");
              $('#languageSwitcher').html(data);
             
               window.location.reload('true');
            }

        });
    }

    function changeStatusunselect(rowid) {

 
        var base_url = '<?php echo base_url() ?>';
 
        $.ajax({
            type: "POST",
            url: base_url + "admin/language/unselect_language/"+rowid,
            data: {},
           
            success: function (data) {

               successMsg("Status Change Successfully");
               window.location.reload('true');
           }
        });
    }


function load(){
 $.ajax({
        type: "POST",
        url: '<?php echo base_url() ?>admin/language/onloadlanguage',
        data: {},
        //dataType: "json",
        success: function (data) {
           window.location.reload('true');
          
        }
        });
}

    function defoult(id){
        $.ajax({
        type: "POST",
        url: '<?php echo base_url() ?>admin/language/defoult_language/'+id,
        data: {},
        //dataType: "json",
        success: function (data) {
           window.location.reload('true');
          
        }
        });
    }

    function delete_language(id){
        alert(id);

    }

</script>