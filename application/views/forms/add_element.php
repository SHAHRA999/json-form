<form id='addNewElement' class='form-horizontal'>

    <div class='panel panel-default'>
        <br>    
             <input type='hidden' name="doc_id" value="<?= $doc_id; ?>" />
            <input type='hidden' name="section_code" value='<?= $section_id; ?>' />
            <input type="hidden" name="section_sorting" value="<?= $section_sorting->section_sorting; ?>" />           
            
            <div class="form-group form-group-sm">
                <label class='control-label col-sm-2'>Element Description</label>
                <div class="col-sm-8">
                    <select name="element_desc" class="form-control" >
                        <?php foreach ($elements as $element): ?>
                            <option value='<?php echo $element['element_code']; ?>'><?php echo $element['element_desc']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2">Element Group</label>
                <div class="col-sm-8">
                    <select name="element_group" class="form-control" >
                        <?php foreach ($elements as $element): ?>
                            <option value='<?php echo $element['element_code']; ?>'><?php echo $element['element_desc']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class='form-group form-group-sm'>
                <label class='control-label col-sm-2'>Element Level</label>
                <div class='col-sm-8'>
                    <input type='number' name='element_level' class='form-control' style="width:8%" autocomplete="off" required/>
                </div>
            </div>


            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2">Position</label>
                <div class="col-sm-8">
                    <label class="radio-inline">
                        <input name="position" type="radio" value="L" checked> Left
                    </label>
                    <label class="radio-inline">
                        <input name="position" type="radio" value="R"> Right
                    </label>
                </div>
            </div>

            <div class='form-group form-group-sm'>
                <label class='control-label col-sm-2'>Element Properties</label>
                <div class='col-sm-8'>
                    <label class='radio-inline'>
                        <input type='radio' name='element_properties' value='DECORATION_NEW'/> Decoration
                    </label>
                    <label class='radio-inline'>
                        <input type='radio' name='element_properties' value='BASIC' checked="checked"/> Basic
                    </label>
                    <label class='radio-inline'>
                        <input type='radio' name='element_properties' value='SUBSECTION_NEW'/> Subsection
                    </label>
                </div>
                <div id='formelement'></div>
            </div>    
            
            <div class='form-group form-group-sm'>
        <label class='control-label col-sm-3'></label>
        <div class='col-sm-12 text-right' style="margin-left: -80px">
            <button type='submit' class='btn btn-sm btn-primary'>Update</button>
        </div>
    </div>      
       
    </div>
</form>

<script>
    //DISPLAY PROPERTY'S DETAIL   
    $(function () {
        var formType = $('input[name=element_properties]:checked').val();
        ElementBuilder(formType);
        $('[name=form_element').val(formType);
        $('[name=element_properties]').on('change', function () {
            var selector = $(this).val();
          //  console.log("selector",selector);
            $('#' + selector).show();
            $('[name=form_element').val(selector);
            ElementBuilder(selector);
        });
    });

    //BAWA KE PAGE->BASIC
    function ElementBuilder(formType) {
        var formValue = $('#editElement').serializeArray();

        $.ajax({
            url: '<?php echo SITE_ROOT; ?>/formbuilder/formelement/',
            data: {value: formType, params: formValue},
            success: function (data) {
                $('#formelement').html(data);
            }
        });
    };

    //UPDATE_ELEMENT
    $(function () {
        $('#addNewElement').submit(function (e) {
            e.preventDefault();
            var test = $(this).serializeArray();
            var new_desc = $('#element_desc').val();
            var elemDesc = $('#elemList [value="' + new_desc + '"]').data('id');
            test.push({name: 'new_element', value: '' + elemDesc + ''});

            var datas = JSON.stringify(test);
            var method = JSON.stringify($('#basicMethod').serializeArray());
            var multAns = JSON.stringify($('#basicMultAns').serializeArray());
            var subSec = JSON.stringify($('#basicSubSec').serializeArray());
           // console.log("datas", datas);

            $.ajax({
                url: '<?= SITE_ROOT; ?>/formview/add-new-element/',
                type: 'POST',
                data: {dummy: null, values: datas, basicMethod: method, basicMultAns: multAns, basicSubSec: subSec},
                success: function (data) {
              //      console.log(data);
                    $('#myModal').modal('hide');
                    swal({
                        title: "New Element Updated!",
                        text: "Data successfully updated into database",
                        type: "success"
                    });
                }
            });
        });
     //    $('.genForm').attr('disabled', false);
    });

</script>