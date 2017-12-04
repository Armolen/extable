<div class="logoleft" ng-show="!$storage.showleftmenu">
    <img src="{{asset('packages/getemplate/imgge/logoge.png')}}" alt="OEE GE" ng-click="hidemenu()" />
</div>

        <div class="panelleft leftview text-left" ng-show="caruselView=='2' && $storage.showleftmenu"> 
                    <div style="position: relative">
                        <img src="{{asset('packages/getemplate/imgge/logoge.png')}}" alt="OEE GE" onclick="location.reload();" />
                        <!--<span class="btn btn-success" style="position: absolute; right: 130px;top:30px;" ng-click="changeorder()"><i class="fa fa-sort"></i></span>-->
<!--                        <span class="btn btn-warning" style="position: absolute; right: 110px;top:30px;" ng-click="changeorder()"><i class="fa " ng-class="order?'fa-sort-up':'fa-sort-down'"></i></span>
                        <span class="btn btn-warning" style="position: absolute; right: 30px;top:30px;" ng-click="changeall()"><i class="fa fa-chain"></i></span>-->
                        <span class="" style="position: absolute; right: 30px;top:30px; font-size: 50px;" ng-click="hidemenu()"><i class="fa fa-arrow-left"></i></span>
                    </div>    
                            <h1>Lista</h1> 
                            <div class="myscroll" style="height: 70vh; overflow: auto;">
                                <div class="row"  style="width: 98%;"> 
                                      <div class="col-md-4" ng-repeat="(key, item) in $storage.database | filter:szukajelemx "> 
                                          <div class="panel panel-default text-center panelbutton" ng-class="getStatusElemItem(key)+(key==$storage.selitem?' active ':' ')" data-attr="{|key|}"  ng-click="selelementdetal(key, $storage.selitem)"  data-a="{|key|}"  ><a name="{|key|}"></a>@{{key+1}}</div> 
                                      </div>
                                </div>
                               
                                
                            </div>
                            <div class="row"  style=" position: absolute; width: 100%; bottom:20px;">
                                <div class="col-md-10">    
                                    <div class="form-group">
                                        <input name="szukajelem" ng-model="szukajelemx"  ng-change="przepisz('szukajelemx')" class="form-control" ng-click="keyView=true; sKeyboard.currentElement = $('input[name=szukajelem]').first()"/>
                                    </div>
                                </div>
                                <div class="col-md-2">    
                                    <svg  ng-click="szukajelemx=''" style="margin-top:-5px;"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="1.482cm" height="1.482cm">
                                       <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
                                        d="M25.104,21.480 L41.229,5.354 C42.230,4.354 42.230,2.731 41.229,1.731 C40.229,0.730 38.607,0.730 37.606,1.731 L21.480,17.856 L5.355,1.731 C4.354,0.730 2.732,0.730 1.731,1.731 C0.730,2.731 0.730,4.354 1.731,5.354 L17.856,21.480 L1.731,37.606 C0.730,38.606 0.730,40.229 1.731,41.229 C2.231,41.730 2.887,41.980 3.542,41.980 C4.198,41.980 4.854,41.730 5.355,41.229 L21.480,25.104 L37.606,41.229 C38.106,41.730 38.762,41.980 39.417,41.980 C40.073,41.980 40.729,41.730 41.229,41.229 C42.230,40.229 42.230,38.606 41.229,37.606 L25.104,21.480 Z"/>
                                       </svg>
                                   
                                </div>
                            </div>
                </div>
