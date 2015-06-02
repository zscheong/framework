<div ng-controller="CompareMap">
    <div class="container-fluid">
        <div class="col-sm-offset-2 col-sm-8">
            <form id="form_map" method="post" action="">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <label for="select_reference">Reference Map Column</label>
                                <select id="select_reference" name="select_reference"  class="form-control" tabindex="0" required ng-model="map_reference"
                                        ng-options="opt for opt in opts.reference">
                                  
                                </select>
                            </div>
                            <div class="col-sm-offset-1 col-sm-5">
                                <label for="select_input">Input Map Column</label>
                                <select id="select_input" name="select_input" class="form-control" tabindex="1" required ng-model="map_input" 
                                        ng-options="opt for opt in opts.input">
                                    
                                </select>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-4 col-sm-offset-4" style="padding-top: 8px;">
                                <button type="button" class="btn btn-primary btn-block" ng-click="MapSubmit()">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>