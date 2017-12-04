<div class="zatrzymaj" ng-show="oknozatrzymaj">
    <div class="zatrzymajokno">
        <h2>Zatrzymaj prace</h2>
            @foreach(\Config::get('app.statusy',[]) as $key=>$item)
                @if($key!=1)
                    <span class="btn btn-default" ng-click="zmien_status({{$key}})">{{$item}}</span> 
                @endif    
            @endforeach    
    
            <div class="foo">
                <span ng-click="oknozatrzymaj=false" class="btn btn-success">Anuluj</span>
            </div> 
     </div> 
</div>
    