<?php if(!class_exists('raintpl')){exit;}?><!doctype>
<html>
    <head>
        <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("layout/tpl/Application/header") . ( substr("layout/tpl/Application/header",-1,1) != "/" ? "/" : "" ) . basename("layout/tpl/Application/header") );?>
    </head>
    <body>
        <div class="container-fluid">
            <style>
                .panel { margin-top: 24px; }
                .select-input { padding: 12px 0px; }
            </style>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#excel_column').multiselect();
                    $('form').submit(function(e) {                      
                        var $val = $('#excel_column').val()
                        $('#multiselect').val($val);
                    });
                });
                function LoadColumn() {
                    var $input = $('#excel_file');
                    var $excel_file = $input.val();
                    var $query = "module=ExcelUtils&action=GetColumnAjax&excel_file=" + $excel_file;
                    var $request = $.ajax({
                                    url: "http://localhost/project/ExcelUtils/index.php?"+$query ,
                                    method: "post",
                                    data: $input[0].files[0],
                                    processData: false,
                                    contentTyle: $input[0].files[0].type
                                    });
                    $request.done(function(data) {
                        if(data.status) {
                            var $col_select = $("#excel_column");
                            for(i = 0; i < data.result.length; i++) {
                                $col_select.append("<option value='" + data.result[i] + "'>" + data.result[i] + "</option>");
                            }
                        }
                    });
                    $request.fail(function( jqXHR, textStatus ) {
                        alert( "Request failed: " + textStatus );
                    });
                }
            </script>
            <div class="row">
                <div class="col-sm-offset-4 col-sm-4">
                     <form method="post" action="http://localhost/project/ExcelUtils/index.php" enctype="multipart/form-data">
                    <div>
                    <h4> Excel Utility - Check Row Duplication </h4>
                   
                        <input type="hidden" name="module" value="ExcelUtils"/>
                        <input type="hidden" name="action" value="DuplicateRow"/>
                        <input type="hidden" name="form_id" value="<?php echo $form_id;?>"/>
                        <input type="hidden" id='multiselect' name="multiselect" value=""/>
                        <div class="input-group">
                            <span class="input-group-addon">Excel File</span>
                            <input type="file" class="form-control" onchange="javascript: LoadColumn()" id="excel_file" name="excel_file" placeholder="Browse an excel file..."></input>
                        </div>
                        
                        <div class="select-input">
                            <label for="excel-column">
                                <span>Excel Column: </span>
                            </label>    
                            <select id="excel_column" name="excel_column" multiple="multiple">
                                
                                <!--
                                <?php $counter1=-1; if( isset($column_list) && is_array($column_list) && sizeof($column_list) ) foreach( $column_list as $key1 => $value1 ){ $counter1++; ?>
                                <option value="<?php echo $value1;?>"><?php echo $value1;?></option>
                                <?php } ?>
                                -->
                            </select>
                        </div>
                    
                    </div>
                    <div>
                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>