<script src='<?=$appConfig['doc_dir']. 'modules/'. $modConfig['module'] . '/view/app.js'?>'></script>
<div ng-app='UnitTestModule'>
     <div ng-controller="TestController">
     {{welcome}}
     </div>    
    <pre>
        <?php print_r($_SERVER);?>
    </pre>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4" >
                <button class="btn btn-default btn-block" style="height:400px;" type="button">Testing</button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4">
                <label for="txt_testing">Testing</label>
                <div class="input-group">
                    <input type="text" class="form-control input-click" id="txt_testing" name="txt_testing"></input>
                </div>
            </div>
        </div>
    </div>
    
</div>