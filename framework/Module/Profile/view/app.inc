<script src='<?=$modConfig['mod_doc_dir'] . 'view/app.js'?>'></script>

<link rel='stylesheet' href='<?=$appConfig['doc_dir'] . 'global/directive/TabWidget/TabWidget.css'?>'/>
<link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css'/>
<link rel='stylesheet' href='<?=$appConfig['doc_dir'] . 'global/directive/textAngular/dist/testAngular.css'?>'/>

<script src='<?=$appConfig['doc_dir'] . 'global/directive/TabWidget/TabWidget.js'?>'></script>
<script src="<?=$appConfig['doc_dir'] . 'global/directive/textAngular/dist/textAngular-rangy.min.js'?>"></script>
<script src="<?=$appConfig['doc_dir'] . 'global/directive/textAngular/dist/textAngular-sanitize.min.js'?>"></script>
<script src="<?=$appConfig['doc_dir'] . 'global/directive/textAngular/dist/textAngular.min.js'?>"></script>


<div id='ProfileModule' ng-app="ProfileModule">
     <div ng-controller="ProfileController">
        
        <div ng-include="'<?=$modConfig['mod_doc_dir'] . 'view/ProfileInfo.inc'?>'">
        </div>
        
         
        <div ng-include="'<?=$modConfig['mod_doc_dir'] . 'view/ProfileTabs.inc'?>'">
        </div>
     </div>    
</div>