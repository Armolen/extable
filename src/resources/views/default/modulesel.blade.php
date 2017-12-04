

<div class="zatrzymaj" ng-show="chmodule">
    <div class="zatrzymajokno">
        <h2>Przełącz moduł</h2>
        <div class="row">
            <div clas="col-xs-6" ng-repeat="item in selzadania">
                        <span class="btn btn-default" ng-click="zmienzadanie(item.typ)">@{{item.nazwa}}</span>
            </div>
        </div>
           
            <div class="foo">
                <span ng-click="chmodule=false" class="btn btn-success">Anuluj</span>
            </div> 
     </div> 
</div>


