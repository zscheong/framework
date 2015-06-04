<script src='<?=$modConfig['mod_doc_dir'] . 'view/compare.js'?>'></script>
<script src='<?=$appConfig['doc_dir'] . 'global/directive/FileModel.js'?>'></script>

<div id='ExcelCompare' ng-app='AppModule'>
    <div class='container-fluid' ng-controller='CompareController'>
        <div class='row'>
            <div class='col-sm-10 col-sm-offset-1 alert alert-info '>
                <h4>Functions</h4>
                <p>If you want to compare the reference and input excel file, use this function
                    for separate the row by comparing the key columns exist in both files. <br>
                    The result will be an excel file which contains sheet for 
                    match and nonmatch table.</p>        
            </div>
        </div>
    
        <div ng-show=" step == 'upload'">
            <div class="row"  ng-include="'<?=$modConfig['mod_doc_dir'] . 'view/compare_upload.inc'?>'"></div>
        </div>
        <div ng-show=" step == 'map'">
            <div class="row"  ng-include="'<?=$modConfig['mod_doc_dir'].'view/compare_map.inc'?>'"></div>
        </div>
        
        <div class='row'>
            <div class='col-sm-10 col-sm-offset-1 alert alert-warning '>
                <h4>Use Case</h4>
                <p>For example, In a CRM system, you want to import Sales Order from an excel. 
                    For a pre-caution step, you want to make sure the customer and item<br>
                    from the input file are exist in the CRM System. Export the Customer and 
                    Item list from the CRM System and use this function to separate<br> 
                    the non-exist customer and item if found.
                    </p>        
            </div>
        </div>
    
        <button class="btn btn-primary" ng-click="ToggleForm()">Toggle Form</button> 
    </div>
    
</div>