<?= $header; ?>
<div class='row'>
    <div id="setsini" class='col-md-9'>
        <div class='panel panel-default' >
            <div class='panel-heading text-uppercase' style='font-size: 12.5px;'>
                <div class='row'>
                    <div class='col-xs-2'>Discipline </div>
                    <div class='col-xs-10'>: <strong><?= $main_discipline; ?></strong></div>
                    <div class='col-xs-2'>Sub Discipline </div>
                    <div class='col-xs-10'>: <strong><?= $sub_discipline; ?></strong></div>
                    <div class='col-xs-2'>Document Title </div>
                    <div class='col-xs-10'>: <strong><?= $document_title; ?></strong></div>
                </div></div>
            
            <form class='form-horizontal'>
            <?php foreach ($json_elements as $key => $section): ?>
                <?php if($section->section_code=='0'):?>
                    <div class='panel-body' data-section='<?= $key; ?>' style="padding-top: 8px;" >
                    <?php echo ColumnRender($section->elements, $section->layout,$document_title, $document_id, $section->layout);?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            </form>
        </div>
        
        <form id='notesForm' class='form-horizontal'>
            <div class='panel panel-default'> 
                <?php foreach ($json_elements as $key => $section): ?>
                <?php if($section->section_code!='0'):?>
                <div class='panel-heading' style="background-color: #0088cc; color: white; " data-section='<?= $key; ?>'><b><?= $section->section_desc; ?></b></div>
                <div class='panel-body' data-section='<?= $key; ?>'>
                <!--display element-->
                <?php echo ColumnRender($section->elements, $section->layout,$document_title, $document_id, $section->layout);?>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </form>
    </div>

     <div class='col-md-1' style="position: fixed; z-index: 7; right: 0; margin-right:-15px;">
         <a href='#' class='btn btn-primary updatelayout' style="padding: 5px 10px;">Update</a>  
    </div>
    
   <br><br> 
    <div class='col-md-1-right' style="position: fixed; z-index: 7; right: 0;">
        <div class='panel-heading'>
            <div class="panel-body">
                <button class="btn btn-default expandComponent" data-current='expand'><i class="glyphicon glyphicon-chevron-up"></i></button>
            </div>
        </div>
    </div>   
    <div class="col-md-3 " id="sidebar" style="position: fixed; z-index: 6; right: 0; margin-left: 15px;">
        <div class='panel panel-default' id='notecomponent'>
            <div class='panel-heading'><b>Notes Component</b></div>
            <div class='panel-body'>
                <ul class='list-unstyled' style=" font-size: 12.5px;">
                    <?php foreach ($json_elements as $key => $section): ?>
                        <?php if($section->section_code!='0'):?>
                        <li><input type='checkbox' class='selectedsection' name='<?= $key; ?>' value='<?= $key; ?>' checked /> <?= $section->section_desc; ?></li>
                        <?php endif;?>
                    <?php endforeach; ?>
                </ul>

                <div class='text-right'>
                    <div class='btn-group btn-group-sm'>
                        <a href='<?= SITE_ROOT; ?>/formview/edit-form/<?= $template_id; ?>' class='btn btn-default'>Edit Form</a>
                        <a href='<?= SITE_ROOT; ?>/formview/json-format/<?= $document_id; ?>' target="_blank" class='btn btn-default'>View JSON</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<div id="Modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Change Layout</h4>
            </div>
            <div class="modal-body">
            </div>
        </div>

    </div>
</div>
<script src='<?= SITE_ROOT; ?>/assets/library/datepicker/js/bootstrap-datepicker.js'></script>
<!--<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>-->
<script src='http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js'></script>
<script src="<?php echo SITE_ROOT; ?>/assets/library/summernote/summernote.js"></script>
<script src="<?php echo SITE_ROOT; ?>/assets/js/dropdown.js"></script>
<script>
                                function HideAndShowOtherSpecify(object) {
                                    var $selected = $(object).val();
                                    if ($selected.toLowerCase() === 'others, specify') {
                                        var $name = 'other_specify_' + $(object).attr('name');
                                        $("[name='" + $name + "']").show();
                                        if ($(object).is(':checked')) {
                                            $("[name='" + $name + "']").removeClass('hidden');
                                        } else {
                                            $("[name='" + $name + "']").addClass('hidden');
                                        }
                                    }
                                }
                                
</script>
<script>
    $(function () {
        $('.summernote').summernote({
            height: 100
        });
        $('.selectedsection').change(function () {
            var section = $(this).val();
            $('#notesForm').find("[data-section='" + section + "']").fadeToggle("fast", "linear");
        });

        $('.datepicker').datepicker({
            'format': 'dd/mm/yyyy'
        });
        $("input[name^=other_specify_]").hide();

        $('input[type="checkbox"]').change(function () {
            HideAndShowOtherSpecify(this);
            var $parentcode = $(this).data('parentcode');
            console.log($parentcode);
            if ($(this).is(':checked')) {
                $('.multicheckbox_' + $parentcode).removeClass('hidden');
                $('textarea[data-parentcode="'+$parentcode+'"]').removeAttr('disabled');
            } else {
                $('.multicheckbox_' + $parentcode).addClass('hidden');
                $('textarea[data-parentcode="'+$parentcode+'"]').attr('disabled','disabled');
            }
        });

        $('.updatelayout').click(function () {
     
            var documentId = '<?= $document_id;?>';
            $.ajax({
                url: '<?= SITE_ROOT; ?>/formview/update-layout/',
                data: {documentId : documentId},
                success: function (data) {
                    console.log(data);
                    $("#contoh").text(data);
                    var obj = $.parseJSON(data);
                    $('.modal-dialog').removeClass('modal-lg');
                    $('.modal-title').text(obj.component);
                    $('.modal-body').html(obj.html);
                }
            });
            $('#Modal').modal('show');
            return false;
        });
        
        $('input[id^=rdio_]').hide();
        $('input[type=radio]').on('change',function(){
           $('input[id^=rdio_]').hide();
           var $parentcode = $(this).data('parentcodes');
            console.log($parentcode);
             $('#rdio_'+$parentcode).show();
            if ($(this).is(':checked')) {
                $('#rdio_'+$parentcode).show();
        }
        });
    });
    

       $('.expandComponent').click(function () {
            var a = $('#sidebar').toggleClass('hidden');
            var current = $(this).data('current');
            console.log(current);
            if(current==='expand'){
                $(this).data('current','hide');
                $(this).html('<i class="glyphicon glyphicon-chevron-down"></i>');
                document.getElementById("setsini").className = "col-md-12";
            } else {
                $(this).data('current','expand');
                $(this).html('<i class="glyphicon glyphicon-chevron-up"></i>');
                document.getElementById("setsini").className = "col-md-9";
            }
        });   
</script>

<?= $footer; ?>