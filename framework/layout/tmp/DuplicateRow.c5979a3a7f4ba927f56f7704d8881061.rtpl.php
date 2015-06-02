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
                    //Set value for multiselect
                    $('#excel_column').multiselect();
                    $('form').submit(function(e) {                      
                        var $val = $('#excel_column').val()
                        $('#multiselect').val($val);
                    });
                });
            </script>
            <div class="row">
                <div class="col-sm-offset-4 col-sm-4">
                     <form method="post" action="http://localhost/project/ExcelUtils/index.php" enctype="multipart/form-data">
                    <div>
                    <h4> Excel Utility - Check Row Duplication </h4>
                   
                        <input type="hidden" name="module" value="ExcelUtils"/>
                        <input type="hidden" name="view" value="ShowResult"/>
                        <input type="hidden" name="form_id" value="<?php echo $form_id;?>"/>
                        <input type="hidden" name="excel_file" value="<?php echo $excel_file;?>"/>
                        <input type="hidden" id='multiselect' name="multiselect" value=""/>
                        <div>
                            <span>Excel File</span>
                            <span><?php echo $excel_file;?></span>
                        </div>
                        
                        
                        <div class="select-input">
                            <label for="excel-column">
                                <span>Excel Column: </span>
                            </label>    
                            <select id="excel_column" name="excel_column" multiple="multiple">
                                
                                <?php $counter1=-1; if( isset($column_list) && is_array($column_list) && sizeof($column_list) ) foreach( $column_list as $key1 => $value1 ){ $counter1++; ?>
                                <option value="<?php echo $value1;?>"><?php echo $value1;?></option>
                                <?php } ?>
                                
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