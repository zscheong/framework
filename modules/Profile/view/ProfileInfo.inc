<style>
img.person { 
    max-width: 100px;
    max-height: 100px;
    width: 100%;
    height: 100%;
    border-radius: 50%; 
}
</style>

<div ng-controller="InfoController">
    <div class="container-fluid">
         <div class="row">
             <div class="col-sm-offset-2 col-sm-8">
                 
<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-4 text-center">
                <div>
                    <img class="person" src="global/img/person.jpg" alt="profile image" title="profile image"/>
                </div>
                <h5><b>{{user.short}}</b></h5>
            </div>
            <div class="col-sm-8">
                <h4>{{user.name}} - {{user.designation}}</h4>
                <div class="row">
                    <div class="col-xs-4 col-sm-4">Country: &nbsp;</div>
                    <div class="col-xs-8 col-sm-8"> <span>{{user.country}}</span></div>
                    <div class="clearfix"></div>
                    
                    <div class="col-xs-4 col-sm-4">Phone: &nbsp;</div>
                    <div class="col-xs-8 col-sm-8"><span>{{user.phone}}</span></div>
                    <div class="clearfix"></div>
                    
                    <div class="col-xs-4 col-sm-4">Email: &nbsp;</div>
                    <div class="col-xs-8 col-sm-8"><span>{{user.email1}}<br>{{user.email2}}</span></div>
                </div>
               
                <div class="row">
                    <div class="col-sm-12" style="padding-top: 8px;">
                        <p>I believe in Software can make life differences.<br>
                            Passionate for every new technology and mainly focus on mobile<br>
                            and web technology</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <marquee behaviour="scroll" direction="left" scrollamount="2">{{note}}</marquee>
    </div>
</div>
            </div>
        </div>
</div>