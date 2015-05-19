<div ng-controller="CompareUpload">
    <div class="container-fluid">
        <div class="col-sm-offset-2 col-sm-8">

            <form id="form_upload" method="post" action="" enctype="multipart/form-data">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <label for="file_reference">Reference Excel File</label>
                            <div class="input-group">
                                <span class="glyphicon glyphicon-file input-group-addon"></span>
                                <input id="file_reference" name="file_reference" file-model="reference" tabindex="0" type="file" 
                                       class="form-control" placeholder="Upload reference excel file" required/>
                            </div>
                        </div>
                        <div class="clearfix"></div><br><br>
                        <div class="col-sm-10">
                            <label for="file_input">Input Excel File</label>
                            <div class="input-group">
                                <span class="glyphicon glyphicon-file input-group-addon"></span>
                                <input id="file_input" name="file_input" file-model="input" tabindex="1" type="file"
                                       class="form-control" placeholder="Upload input excel file" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-offset-6 col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-block btn-primary" ng-click="UploadSubmit();">Submit</button>
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-block btn-default" ng-click="ResetInput();">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
            </div>
            </form
                
        </div>
    </div>
</div>