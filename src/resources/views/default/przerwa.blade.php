<style>
    .przerwa {
        width: 100%;
        height: 100%;
        position: fixed;
        top:0;
        left: 0;
        z-index: 100;
        background-color:#019ddd; 
        color: #fff;
    }
    
    .przerwa .przycisk_anuluj
    {
        position: absolute;
        bottom: 100px;
        text-align: center;
        width: 100%;
    }
    
    .przerwa h2 {
        text-align: center;
        margin-top: 100px;
        font-size:  50px;
    }
    
    .przerwa .przycisk_anuluj span.btn
    {
        font-size: 20px;
        padding: 20px 50px;
    }
    
</style>

<div class="przerwa" ng-show="status!=0">
    <h2>@{{statusyopis[status]}}</h2>
    <h2>@{{wyliczczaskablowania()}}</h2>
    
    <div class="przycisk_anuluj">
        <span class="btn btn-success" ng-click="zmien_status(0)">Przerwij</span>
    </div>
        
    
</div>