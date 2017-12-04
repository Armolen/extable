<style>

    .menutop > span {
        float: right;
        font-weight: 500;
        color: #242a30;
        margin-top: 0;
        margin-bottom: 15px;
        line-height: 1.25;
        padding-left:5px;
        padding-right:5px;

    }
    
   .menutop  span > span { 
        font-size: 20px;
        font-family: 'latobold';
        margin-right: 20px;
    }
    
</style>
<div class="row menutop">
    

    <div class=" col-md-12 text-right " style="min-height: 100px; padding:20px;"> 
        <span class="wkretarka @{{wkretarkaostatniedane.connect?'status1':'status3'}}" ng-show="config.wkretarka">
            <span><i class="fa fa-wrench " style="font-size: 37px;"></i> @{{wkretarkaostatniedane.connect?"ONLine":"OFFLine"}}</span>
        </span>
        <span class="projekt @{{'status'+statusp}}">
            <span ng-hide="chooseProjectDataView">
            <img ng-show="statusp==1" src="/packages/getemplate/img/pracag.svg" alt="">
            <img ng-show="statusp==3" src="/packages/getemplate/img/pracar.svg" alt="">
            <img ng-show="statusp==2" src="/packages/getemplate/img/pracao.svg" alt="">

            <span>@{{doClockFromSeconds(synctime()-$storage.startWorkTime)}} 
        </span>
    </span>
        <span class="user status1">
            <img src="/packages/getemplate/img/user.svg" alt="">
            <span>@{{logowanie()}}</span>
        </span>
        @include('getemplate::default.logoff')
        </span>
    </div>
</div>