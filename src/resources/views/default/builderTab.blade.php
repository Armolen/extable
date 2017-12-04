@extends(ModoeeTemplate::view('master'))
@section('content')

    @include("getemplate::default.loadpage")
    @include("getemplate::default.modulesel")
    @include("getemplate::default.przerwa")

    <div ng-show="caruselView=='2' && $storage.module!=0">

        @include("getemplate::default.top")  
        @include("getemplate::default.botmenu")
        @include("getemplate::default.leftmenu")
        @include("getemplate::default.zatrzymaj")

 
        <div class="contentpanel @{{$storage.showleftmenu?'resizescreen':''}}">
            <div class="container-fluid">
                <br><br>
                {{-- START WYŚWIETLANIE PASKÓW POSTĘPU PRACY I CZASU >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> --}}


                <div ng-class="{'menuBarLeft' : !$storage.showleftmenu, 'menuBarCenter' : $storage.showleftmenu}">
                    <div ng-show="workTimeCounter>0 || workTimeUp>0">
                    <div class="row">
                        <div  class="col-xs-12 col-sm-12 col-md-12 col-lg-6" >
                            <div ng-if="!$storage.finalWorkTime">
                                <span ng-if="workTimeUp==0">Pozostały czas pracy 
                                <span ng-if="extableProjectsList.projecttime-workTimeCounter<60"> w sekundach: @{{extableProjectsList.projecttime-workTimeCounter}}</span>
                                    <span ng-if="extableProjectsList.projecttime-workTimeCounter>=60"> w minutach: @{{(extableProjectsList.projecttime-workTimeCounter)/60 | number:0}}</span></span>
                                
                                <span ng-if="workTimeUp>0">Przekroczony czas
                                        <span ng-if="workTimeUp<60"> w sekundach: @{{workTimeUp}}</span>
                                    <span ng-if="workTimeUp>=60"> w minutach: @{{workTimeUp/60 | number:0}}</span></span>

                                <div class="progress">
                                    <div class="progress-bar progress-bar-warning progress-bar-striped"
                                         role="progressbar"
                                         aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                         style="width: @{{(extableProjectsList.projecttime - workTimeCounter)*100/extableProjectsList.projecttime}}%"
                                         ng-if="((extableProjectsList.projecttime - workTimeCounter)*100/extableProjectsList.projecttime)<=30 && workTimeUp==0">
                                    </div>
                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                         role="progressbar"
                                         aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                         style="width: @{{(extableProjectsList.projecttime - workTimeCounter)*100/extableProjectsList.projecttime}}%"
                                         ng-if="((extableProjectsList.projecttime - workTimeCounter)*100/extableProjectsList.projecttime)>30 && workTimeUp==0">
                                    </div>
                                    <div class="progress-bar progress-bar-danger progress-bar-striped"
                                         role="progressbar"
                                         aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 100%"
                                         ng-if="workTimeUp>0">
                                    </div>
                                </div>
                            </div> 
                            <div ng-if="$storage.finalWorkTime>0 && $storage.finalWorkTime/1000<extableProjectsList.projecttime">
                                Cel osiągnięty!
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                         role="progressbar"
                                         aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 100%;">
                                         Praca została ukończona w czasie: @{{doClockFromSeconds($storage.finalWorkTime)}}
                                    </div>      
                                    </div>                          
                            </div>
                            <div ng-if="$storage.finalWorkTime>0 && $storage.finalWorkTime/1000>extableProjectsList.projecttime">
                                Przekroczono limit czasu o @{{doClockFromSeconds($storage.finalWorkTime-(extableProjectsList.projecttime*1000))}}
                                <div class="progress">
                                    <div class="progress-bar progress-bar-danger progress-bar-striped"
                                         role="progressbar"
                                         aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 100%;">
                                         Praca została ukończona w czasie: @{{doClockFromSeconds($storage.finalWorkTime)}}
                                    </div>      
                                    </div>                          
                            </div> 
                        </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6" >
                                <div ng-if="checkWorkProgress() < 100">
                                Postęp pracy: @{{checkWorkProgress() | number:0}}%
                                <div ng-if="checkWorkProgress()==100">@{{stopWorkTimer()}}</div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                         role="progressbar"
                                         aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                         style="width: @{{checkWorkProgress()}}%">
                                    </div>
                                </div>
                            </div>
                            <div ng-if="checkWorkProgress()==100">
                                <br><button class="btn btn-success btn-block">Zakończ projekt <i class="fa fa-check" aria-hidden="true"></i></button>
                            </div>

                            </div>
                </div>
            </div>
        </div>



                {{-- FINISH WYŚWIETLANIE PASKÓW POSTĘPU PRACY I CZASU >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> --}}


                {{-- START WYŚWIETLANIE MENU WYBORU POŁĄCZEŃ >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> --}}


                <div class="btn-group btn-group-justified" role="group" aria-label="..."
                     ng-hide="chooseProjectDataView">
                    <div class="btn-group" role="group">
                        <span class="btn btn-warning" ng-click="showToDoList(1)"
                              ng-if="!linesToConnect==0 || !dokladkaList==0">Do połączenia <strong>(@{{linesToConnect}})</strong> / Dokładki <strong>(@{{dokladkaList}})</strong>
                        </span>
                        <span class="btn btn-warning" ng-if="linesToConnect==0 && dokladkaList==0"
                              ng-disabled="true">Do połączenia <strong>(@{{linesToConnect}})</strong> 
                        </span>
                    </div>
                    <div class="btn-group" role="group">
                        <span class="btn btn-success" ng-click="showToDoList(0)"
                              ng-if="!linesConnected==0">Połączone <strong>(@{{linesConnected}})</strong> 
                        </span>
                        <span class="btn btn-success" ng-if="linesConnected==0"
                              ng-disabled="true">Połączone <strong>(@{{linesConnected}})</strong> 
                        </span>
                    </div>
                    {{--                     <div class="btn-group" role="group">
                                            <span class="btn btn-default" ng-click="showToDoList(4)"
                                                  ng-disabled="linesDisactive==0">Połączenia nieaktywne <strong>(@{{linesDisactive}})</strong>
                                            </span>
                                        </div> --}}
                    <div class="btn-group" role="group">
                        <span class="btn btn-primary" ng-click="showToDoList(2)">Wszystkie połączenia
                            <strong>(@{{linesAllIn}})</strong>
                        </span>
                    </div>
                </div>
                <div class="connectionsNavigatorMain" ng-hide="chooseProjectDataView">
                    <div class="connectionsNavigator" style="left:66.66%;"></div>
                </div>
                <hr> 

                {{-- FINISH WYŚWIETLANIE MENU WYBORU POŁĄCZEŃ >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> --}}


                {{-- START - WIDOK POŁĄCZEŃ DLA PROJEKTU NA GŁÓWNYM EKRANIE >>>>>>>>>>>>>>>>>>>>>  --}}

                <div>
                    <tbody> 
                    <tr>
                        <td colspan="2">
                            <div class="scrollGenerate" id="scrollStyle">
                                <table class="table table-condensed table-striped" style="background-color: rgba(255,255,255,0.4);">
                                    <thead style="font-weight: 200 !important;">
                                    <th width="25px">Przekrój przewodu</th>
                                    <th width="25px">Kolor przewodu</th>
                                    <th style="text-align: center !important;">Połączenia</th>
                                    </thead>

                                    <tr ng-repeat="connects in $storage.extableAll" ng-if=" 
                    (extableLines[connects.child] * 3)-extableLinesStats[connects.child]>=$storage.toDoListView && $storage.toDoListView!=0 && connects.parent==connects.child || 
                    $storage.toDoListView==2 && connects.parent==connects.child ||
                     (extableLines[connects.child] * 3)-extableLinesStats[connects.child]==$storage.toDoListView && connects.parent==connects.child"

                                        ng-class="{'nonActiveConnect' : !connects.active, 'borderActiveNew': !inLineChanges(connects.parent), 'redTextColor':!redConnectionsDataChecker(connects.id, 'line')}" style="border-top:0 !important;">
                                        <td>@{{connects.przekroj_przewodu}} @{{$index}}</td>
                                        <td>@{{connects.kolor_przewodu}}
                                        </td>

                                        <td style="padding-left: 20px !important;">
                                            @{{addReadySubConnection(connects.child)}}

                                            <div class="row">
                                                
                                                    <div ng-repeat="suberterConnection in $storage.extableAll"
                                                        ng-if="suberterConnection.child==connects.child "
                                                        style="!important; margin-bottom:5px !important; margin-top:5px !important;"
                                                        ng-class="{'redTextColor':suberterConnection.revision}">
                                                        <div ng-if="!connects.active">
                                                            <div class="col-xs-6 col-sm-1 col-md-1 col-lg-1 connectorLine" ng-class="{'buttonEx' : true, 'buttonEx-first': true,'disConnect': !suberterConnection.active}"
                                                             {{-- ng-click="connectorClick($index, 0, suberterConnection.id, suberterConnection.child) --}}" ng-if="suberterConnection.parent==suberterConnection.child">
                                 <span ng-class="{'redTextColor':!redConnectionsDataChecker(suberterConnection.id, suberterConnection.zlacze)}">
                                 @{{suberterConnection.zlacze}}</span>
                                                         </div>
                                                        </div>

                                                        <div ng-if="connects.active">
                                                        <div class="col-xs-6 col-sm-1 col-md-1 col-lg-1 connectorLine" ng-class="{'buttonEx' : true, 'buttonEx-first': true, 'buttonEx-green': suberterConnection.status==1,'disConnect': !suberterConnection.active}"
                                                             ng-click="connectorClick($index, suberterConnection.parent, suberterConnection.child)" ng-if="suberterConnection.parent==suberterConnection.child">
                                 <span ng-class="{'redTextColor':!redConnectionsDataChecker(suberterConnection.id, suberterConnection.zlacze)}">
                                 @{{suberterConnection.zlacze}}</span>


                                                        </div>
                                                        <div class="hidden-xs hidden-sm hidden-md col-lg-1 boxConnector" ng-if="suberterConnection.dokladka>0"></div>
                                                        <div class="col-xs-6 col-sm-1 col-md-1 col-lg-1 connectorLine" ng-if="suberterConnection.dokladka>0"
                                                              ng-class="{'buttonEx':true, 'dokladkaStatic':dokladkaDisplay!=suberterConnection.dokladka && !suberterConnection.dokladka_status, 'dokladkaActive': dokladkaDisplay==suberterConnection.dokladka && !suberterConnection.dokladka_status, 'dokladkaSuccess':suberterConnection.dokladka_status}"
                                                              style="width: 30px;"
                                                              ng-click="showSameDokladka(suberterConnection.dokladka, suberterConnection.dokladka_status, $index)"><span ng-class="{'redTextColor':!redConnectionsDataChecker(suberterConnection.id, suberterConnection.dokladka)}">@{{suberterConnection.dokladka}}</span></div>

                                                        <div class="hidden-xs hidden-sm hidden-md col-lg-1 boxConnector"  ng-if="suberterConnection.parent!=suberterConnection.child &&
                                                             connects.child==suberterConnection.child
                                                             "></div>

                                                        <div class="col-xs-6 col-sm-1 col-md-1 col-lg-1 connectorLine" ng-class="{'buttonEx' : true, 'buttonEx-neutral': suberterConnection.status==0 && suberterConnection.blend==0, 'buttonEx-green': suberterConnection.status==1,'buttonEx-blend': suberterConnection.blend==1 && suberterConnection.status==0,'disConnect': !suberterConnection.active}"
                                                             ng-click="connectorClick($index, suberterConnection.parent, suberterConnection.child)"
                                                             ng-if="suberterConnection.parent!=suberterConnection.child &&
                                                             connects.child==suberterConnection.child
                                                             ">
                                                            <span ng-class="{'redTextColor':!redConnectionsDataChecker(suberterConnection.id, suberterConnection.zlacze)}">
                                                            <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
                                                             @{{suberterConnection.zlacze}}
                                                         </span>

                                                        </div>
                                                    </div>
                                                    </div> 

                                                    </div>                                         
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </div>
                <div ng-if="connectionsDataChanges">
                    Nastąpiły zmiany w projekcie...
                    <span class="btn btn-danger"
                          ng-click="updateAllData()"><strong>WPROWADŹ ZMIANY</strong>
                        </span>
                </div>

                {{-- FINISH - WIDOK POŁĄCZEŃ DLA PROJEKTU NA GŁÓWNYM EKRANIE >>>>>>>>>>>>>>>>>>>>>  --}}


            </div>

        </div>
    </div>

    <script>

        function isInteger(n) {
            return n === +n && n === (n | 0);
        }


        app.controller('builderTabController', ['config', '$scope', '$localStorage', 'cfpLoadingBar', '$http', '$interval', '$location', '$window', function (config, $scope, $localStorage, cfpLoadingBar, $http, $interval, $location, $window) {

            $scope.getModule = {{\Request::get('module_id',0)}};
            $scope.projektID = localStorage.getItem("ngStorage-projektkod");
            $scope.dokladkaList = 0;

            $scope.$storage = $localStorage.$default();
            if($scope.getModule != 0){
                $scope.$storage.module = $scope.getModule;
            }





// START POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// START POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// START POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// START POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// START POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// START POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

                    //delete $scope.$storage.extableAll;

            $http.get('/extable/extableProjectsBuffer?module='+$scope.$storage.module+'&kodproj=' + $scope.$storage.projektsel.id).then(function (res) {

                $scope.extableProjectsList = res.data;

                      setTimeout(function(){
                                $("#scrollStyle").niceScroll({
                                    cursorwidth:30,
                                    horizrailenabled:false,
                                    cursoropacitymin:0.4,
                                    cursorcolor:'#029ddf',
                                    cursorborder:'none',
                                    cursorborderradius:4,
                                    autohidemode: false,
                                    zindex: 999
                                    });
                            },700);


                $scope.workTimeCounter = 0;
                
                    // angular.forEach($scope.$storage.redConnectionsData, function (val, key) {
                    //     $scope.newConnectionsData.push($scope.$storage.redConnectionsData[key]);
                    // });
                    // $scope.chooseProjectDataView = false;
                    // $scope.workToDoCounter(); 
                    // $scope.blendCounter();
                    // $scope.workTimeUp = 0;
                    // $scope.$storage.startWorkTime = new Date($scope.$storage.startWorkTime);


                    // setInterval(function () {
                    //         if ($scope.workTimeCounter >= $scope.extableProjectsList.projecttime) {
                    //             $scope.workTimeCounter = $scope.extableProjectsList.projecttime;
                    //             $scope.workTimeUp = (($scope.synctime() - $scope.$storage.startWorkTime) / 1000) - $scope.extableProjectsList.projecttime;
                    //         }
                    //         else {
                    //             $scope.workTimeCounter = ($scope.synctime()- $scope.$storage.startWorkTime) / 1000;
                    //         }

                    //     }, 1000);
                



               
                       
// START POBIERANIE EXTABLE Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
                    $http.get('/extable/extableBuffer?module_id=' + $scope.$storage.module+'&kodproj=' + $scope.$storage.projektsel.id).then(function (res) {

                        $http.get('/extable/extableRevisions?elemcode=0').then(function (revisions) {
                            $scope.ignoredRevisions = [];
                            $scope.$storage.revisions = revisions.data;
                            var revCheck = false;
                            angular.forEach(res.data, function(value,key){
                                revCheck = false;
                                if(res.data[key].revision == 1){
                                    angular.forEach(revisions.data, function(valueR,keyR){
                                        if(res.data[key].id == revisions.data[keyR].newconnection_id){
                                            revCheck = true;
                                            angular.forEach(res.data, function(valueF, keyF){
                                                if(res.data[keyF].id == revisions.data[keyR].oldconnection_id){
                                                    if(res.data[keyF].zlacze == res.data[key].zlacze){
                                                        var thisSame = true;
                                                    }

                                                res.data.splice(keyF+1, 0, res.data[key]);
                                                res.data.splice(key+1,1);
                                                res.data[keyF].active = 0;

                                                 if(thisSame){
                                                    res.data.splice(keyF,1);
                                                 }
                                            }
                                            });
                                            
                                        }
                                    });
                                    if(!revCheck){
                                        $scope.ignoredRevisions.push(res.data[key]);
                                        res.data.splice(key,1);
                                    }
                                }
                            });
                                    $scope.extableBufferList = res.data;
                                    $scope.$storage.extableAll = $scope.extableBufferList;
                                    $scope.$storage.redConnectionsData = [];
                                    $scope.chooseProjectDataView = false;
                                    $scope.checkerDokladkaService();
                                    $scope.workToDoCounter();
                                    $scope.blendCounter();

                        }, function (e) {
                console.error('błąd odczydu danych database')
            });



                        $scope.$storage.startWorkTime = $scope.synctime();
                        $scope.workTimeUp = 0;

                        setInterval(function () {
                            if ($scope.workTimeCounter == $scope.extableProjectsList.projecttime) {
                                $scope.workTimeCounter = $scope.extableProjectsList.projecttime;
                                $scope.workTimeUp = (($scope.synctime() - $scope.$storage.startWorkTime) / 1000) - $scope.extableProjectsList.projecttime;
                            }
                            else {
                                $scope.workTimeCounter = ($scope.synctime() - $scope.$storage.startWorkTime) / 1000;
                            }

                        }, 1000);
// START WYSYŁANIE ATRYBUTÓW DO BAZY
                        setInterval(function () {
                                    var attributes = {'workTime':$scope.synctime()-$scope.$storage.startWorkTime,'progress':$scope.checkWorkProgress(), 'projecttime':$scope.extableProjectsList.projecttime};
                         
                                    $http.get('/extable/worklogUpdate?attributes=' + JSON.stringify(attributes)).then(function (res) {
                                    }, function (e) {
                                        console.error('błąd odczydu danych database')
                                    });
                        }, 3000);
// FINISH WYSYŁANIE ATRYBUTÓW DO BAZY



                    }, function (e) {
                        console.error('błąd odczydu danych database')
                    });

                
// FINISH POBIERANIE EXTABLE Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>


            }, function (e) {
                console.error('błąd odczydu danych database')
            });


// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// FINISH POBIERANIE PROJECTS Z TABELI W BAZIE DANYCH >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>


            $scope.connectionsDataChangesAccept = function () {

                $scope.$storage.extableAll = $scope.afterRevisions;
                    if($scope.newConnectorsAdded.length>0){

                        angular.forEach($scope.newConnectorsAdded, function(value2, key2){
                            $scope.$storage.extableAll.push($scope.newConnectorsAdded[key2]);
                        });
                        $scope.newConnectorsAdded = [];
                    }
                    $scope.extableProjectsList.projecttime += 30;
                $scope.$storage.redConnectionsData = $scope.newConnectionsData;
                angular.forEach($scope.newConnectionsData, function (value, key) {
                    $scope.$storage.extableAll[$scope.newConnectionsData[key].key][$scope.newConnectionsData[key].type] = $scope.newConnectionsData[key].value;
                    if ($scope.newConnectionsData[key].type == 'zlacze' || $scope.newConnectionsData[key].type == 'blend')
                    {
                        $scope.$storage.extableAll[$scope.newConnectionsData[key].key].status = 0;
                        $scope.$storage.extableAll[$scope.newConnectionsData[key].key].status = 0;
                        $scope.$storage.extableAll[$scope.newConnectionsData[key].key].dokladka_status = 0;
                    }
                    if ($scope.newConnectionsData[key].type == 'zlacze' || $scope.newConnectionsData[key].type == 'blend')
                    {
                      if($scope.$storage.extableAll[$scope.newConnectionsData[key].key].parent == $scope.$storage.extableAll[$scope.newConnectionsData[key].key].child){
                        $scope.$storage.extableAll[$scope.newConnectionsData[key].key].dokladka_status = 0;
                        $scope.$storage.extableAll[$scope.newConnectionsData[key].key].status = 0;
                      }
                      else{
                        $scope.$storage.extableAll[$scope.newConnectionsData[key].key].dokladka_status = 0;
                        $scope.$storage.extableAll[$scope.newConnectionsData[key].key].status = 0;
                        $scope.$storage.extableAll[$scope.newConnectionsData[key].key].status = 0;   
                      }
                    }

                        $scope.workToDoCounter();
                        $scope.linesCounter();
                        $scope.checkerDokladkaService();
                        $scope.blendCounter();

                });
// $scope.$storage.extableAll = $scope.newConnectionsData;
// $scope.extableCreator = $scope.$storage.extableAll;
    
                $scope.showToDoList(2);
                $scope.newConnectionsData = [];
                $scope.connectionsDataChanges = false;
                $scope.workToDoCounter();
                        $scope.linesCounter();
                        $scope.checkerDokladkaService();
                        $scope.blendCounter();

            }


            $scope.redConnectionsDataChecker = function (id, connector) {
                var keepGoing = true; 

                if ($scope.$storage.redConnectionsData.length > 0) {
                    angular.forEach($scope.$storage.redConnectionsData, function (value, key) { 
                        if (keepGoing) {
                            if ($scope.$storage.redConnectionsData[key].key == id && $scope.$storage.redConnectionsData[key].value == connector){
                                keepGoing = false;

                                if($scope.$storage.redConnectionsData[key].type=="dokladka" && $scope.$storage.redConnectionsData[key].checked!=1){
                                    $scope.$storage.redConnectionsData[key].checked = 1;
                                    $scope.showSameDokladka($scope.$storage.extableAll[key].dokladka, $scope.$storage.extableAll[key].dokladka_status, $scope.$storage.redConnectionsData[key].key); 
                                }
                            }
                            
                        }
                    });
                }
                return keepGoing;
            }

            $scope.inLineChanges = function (conid) {
                var keepGoing = true;

                if ($scope.$storage.revisions.length > 0) {
                    angular.forEach($scope.$storage.extableAll, function (value, key) {
                        if (keepGoing) {
                            if ($scope.$storage.extableAll[key].child == conid && $scope.$storage.extableAll[key].revision == 1){
                                keepGoing = false;
                                } 
                            }
                            
                        
                    });
                }
                return keepGoing;
            }
            $scope.dokladkaCounter = function(){
                $scope.dokladkaList = 0;
                var dokladki = [];
                for (var i = 25 - 1; i >= 0; i--) {
                  dokladki[i] = 0;
                }
                angular.forEach($scope.$storage.extableAll, function(value,key){
                    if($scope.$storage.extableAll[key].dokladka > 0){
                       if($scope.$storage.extableAll[key].dokladka_status == 0){
                        if(dokladki[$scope.$storage.extableAll[key].dokladka]==0){
                            dokladki[$scope.$storage.extableAll[key].dokladka] = 1;
                          }
                        else
                            dokladki[$scope.$storage.extableAll[key].dokladka]++;
                        } 
                    }
                });
                angular.forEach(dokladki, function(value2, key2){
                  if(dokladki[key2]>0)
                    $scope.dokladkaList++;
                })
            }

            $scope.checkerDokladkaService = function () {
                angular.forEach($scope.$storage.extableAll, function (value, key) {
                    if ($scope.$storage.extableAll[key].dokladka == 0)
                        $scope.$storage.extableAll[key].dokladka_status = 1;
                });
            }

// START POBIERANIE EXTABLE Z TABELI W BAZIE DANYCH W CELU SPRAWDZENIA WERSJI>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

            $scope.connectionsDataChanges = false;
            $scope.newConnectionsData = [];
            $scope.newConnectorsAdded = [];

            if($scope.$storage.extableAll.length>0){
            setInterval(function () {
                    $http.get('/extable/extableRevisions?elemcode=0').then(function (revisions) {

                            if (revisions.data.length > $scope.$storage.revisions.length) {
                                $scope.connectionsDataChanges = true;
                            }

                    }, function (e) {
                    console.error('błąd odczydu danych database')
                });

            }, 3000);
            }

            $scope.updateAllData = function(){
                $http.get('/extable/extableRevisions?elemcode=0').then(function (revisions) {

                    if (revisions.data.length - $scope.$storage.revisions.length == 1) {

                        $http.get('/extable/extableBuffer?module_id=' + $scope.$storage.module+'&kodproj=' + $scope.$storage.projektsel.id).then(function (revs) {

                        

                                    angular.forEach($scope.$storage.extableAll, function(value,key){

                                        if($scope.$storage.extableAll[key].id == revisions.data[revisions.data.length-1].oldconnection_id){

                                                
                                            angular.forEach(revs.data, function(valueF, keyF){
                                                if(revs.data[keyF].id == revisions.data[revisions.data.length-1].newconnection_id){

                                                $scope.$storage.extableAll.splice(key+1, 0, revs.data[keyF]);
                                                $scope.$storage.extableAll[key].active=0;
                                                $scope.$storage.extableAll[key].status=0;
                                                var projectTime = parseInt($scope.extableProjectsList.projecttime);
                                                var extraTime = parseInt(revs.data[keyF].extratime);
                                                projectTime += extraTime;
                                                $scope.extableProjectsList.projecttime = projectTime;
                                                if($scope.$storage.extableAll[key].zlacze == revs.data[keyF].zlacze)
                                                    $scope.$storage.extableAll.splice(key,1);

                                                } 
                                            });
                                            
                                        }
                                    });

                                    $scope.showToDoList(2);
                                    $scope.newConnectionsData = [];
                                    $scope.connectionsDataChanges = false;
                                    $scope.workToDoCounter();
                                            $scope.linesCounter();
                                            $scope.checkerDokladkaService();
                                            $scope.blendCounter();
                                    $scope.connectionsDataChanges = false;
                                    $scope.$storage.revisions = revisions.data;


                        // var idRestList = [];
                        // for (var i = res.data.length - 1; i >= 0; i--) {
                        //     idRestList.push(res.data[i].id);
                        // }
                        // idRestList.sort(function(a, b){return a - b});
                        // for (var y = 0; y < res.data.length - $scope.$storage.extableAll.length; y++) {
                        //     angular.forEach(res.data, function (value, key) {

                        //         if (res.data[key].id == idRestList[res.data.length - (1 + y)]) {

                        //             var chochlik = 0;
                        //             angular.forEach($scope.newConnectorsAdded, function(v1, k1){
                        //                 if($scope.newConnectorsAdded[k1].id == res.data[key].id)
                        //                     chochlik = 1;
                        //             })
                        //             if(chochlik==0)
                        //             $scope.newConnectorsAdded.push(res.data[key]);

                        //             chochlik=0;
 
                        //         if(res.data[key].parent == res.data[key].child){
                        //            $scope.newConnectionsData.push({
                        //                 key: res.data.length - (1 + y),
                        //                 type: "line",
                        //                 value: "line"
                        //             });

                        //         }else{

                        //             $scope.newConnectionsData.push({
                        //                 key: res.data.length - (1 + y),
                        //                 type: "zlacze",
                        //                 value: res.data[res.data.length - (1 + y)].zlacze
                        //             });
                        //           }
                        //            // $scope.$storage.redConnectionsData = $scope.newConnectionsData;
                        //         }
                        //     });
                        // }
                        // $scope.connectionsDataChanges = true;
                                        }, function (e) {
                    console.error('błąd odczydu danych database')
                });


                    }
                    // if (res.data.length == $scope.$storage.extableAll.length) {
                    //     angular.forEach(res.data, function (value, key) {

                    //         angular.forEach(['parent','child','zlacze', 'blend', 'active', 'dokladka'], function (val, key2) {
                    //             if (res.data[key][val] != $scope.$storage.extableAll[key][val]) {

                    //                 $scope.connectionsDataChanges = true;
                    //                 $scope.newConnectionsData.push({key: key, type: val, value: res.data[key][val]});
                    //                // $scope.$storage.redConnectionsData = $scope.newConnectionsData;
                    //                 $scope.checkerDokladkaService();
                    //                 $scope.blendCounter();

                    //             }


                    //         });
                    //     });
                    // }


                }, function (e) {
                    console.error('błąd odczydu danych database')
                });
}

// FINISH POBIERANIE EXTABLE Z TABELI W BAZIE DANYCH W CELU SPRAWDZENIA WERSJI>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

            $scope.synctime = function () {
                return new Date(moment().add($scope.$storage.timeoffset).format("YYYY-MM-DD\THH:mm:ss.000") + "\Z");
            }

            $scope.blendCounter = function(){
               $scope.blendy = 0;
                angular.forEach($scope.$storage.extableAll, function(value,key){
                    if($scope.$storage.extableAll[key].blend == 1){
                        $scope.blendy++;
                    }
                });
            }


            $scope.chooseProjectDataView = true;
            $scope.chooseProjectData = function () {

  

            }

            $scope.stopWorkTimer = function () {
                clearInterval($scope.workTimerInterval);
            }

            $scope.connectorLogs = [];

            $scope.connectorClick = function ($index, parent, child) {
              if($scope.$storage.extableAll[$index].blend==1 && $scope.$storage.module!=11){
                return;
              }

                $scope.$storage.extableAll[$index].status = 1 - $scope.$storage.extableAll[$index].status;

                $scope.checkWorkProgress();
                $scope.workToDoCounter();
                $scope.dokladkaCounter();


                if($scope.$storage.toDoListView==0 && $scope.linesConnected==0)
                    $scope.showToDoList(1);
                if($scope.$storage.toDoListView==1 && $scope.linesToConnect==0 && $scope.dokladkaList==0)
                    $scope.showToDoList(0);

                  if($scope.$storage.extableAll[$index].status == 1 || $scope.$storage.extableAll[$index].status ==1){
                  $scope.connectorLogs.push({zlacze:$scope.$storage.extableAll[$index].zlacze , zlacze:$scope.$storage.extableAll[$index].zlacze, projekt_kod:$scope.$storage.projektkod, module:$scope.$storage.module, user:$scope.$storage.userlogin, time:$scope.$storage.timeoffsetxx });
                  }
                  else 
                  {
                    angular.forEach($scope.connectorLogs, function(value,key){
                      if(
                        $scope.connectorLogs[key].zlacze == $scope.$storage.extableAll[$index].zlacze &&
                        $scope.connectorLogs[key].zlacze == $scope.$storage.extableAll[$index].zlacze &&
                        $scope.connectorLogs[key].user == $scope.$storage.userlogin &&
                        $scope.connectorLogs[key].projekt_kod == $scope.$storage.projektkod &&
                        $scope.connectorLogs[key].module == $scope.$storage.module 
                        ){
                        $scope.connectorLogs.splice(key,1);
                      }
                    });

                  }


            }


            $scope.extableLines = [];
            $scope.extableLinesStats = [];
            $scope.linesCounter = function () {
                $scope.dokladkaCounter(); 
                var counter = 0;
                var stats = 0;
                $scope.extableLines = [];
                $scope.extableLinesStats = [];
                angular.forEach($scope.$storage.extableAll, function (value, key) {

                    if ($scope.$storage.extableAll[key].parent == $scope.$storage.extableAll[key].child) {
                        angular.forEach($scope.$storage.extableAll, function (value2, key2) {
                          if($scope.$storage.extableAll[key2].blend==1 && $scope.$storage.module!=11){

                          }
                          else{
                            if ($scope.$storage.extableAll[key].child == $scope.$storage.extableAll[key2].child) {
                                counter++;
                                stats += ($scope.$storage.extableAll[key2].status + $scope.$storage.extableAll[key2].status + $scope.$storage.extableAll[key2].dokladka_status);
                            }
                          }
                        });
                        $scope.extableLines[$scope.$storage.extableAll[key].child] = counter;
                        $scope.extableLinesStats[$scope.$storage.extableAll[key].child] = stats;
                        stats = 0;
                        counter = 0;
                    }
                });
                console.log($scope.extableLines);
                console.log($scope.extableLinesStats);
            }


            $scope.workToDoCounter = function () {

                $scope.linesCounter();

                // $scope.linesReadytoGo=0;        
                // angular.forEach($scope.extableLines, function (value1, key1) {
                //     if($scope.extableLines[key1]*3 == $scope.extableLinesStats[key1]){
                //         $scope.linesReadytoGo++; 
                //         console.log( $scope.linesReadytoGo);      
                //     }
                //     if($scope.extableLines[key1]*3 > $scope.extableLinesStats[key1] && $scope.linesReadytoGo>0){
                //         $scope.linesReadytoGo--; 
                //         console.log( $scope.linesReadytoGo);      

                //     }
                // });

                $scope.linesToConnect = 0;
                $scope.linesConnected = 0;
                $scope.linesDisactive = 0;
                $scope.linesAllIn = 0;

                angular.forEach($scope.$storage.extableAll, function (value, key) {
                    var numb = $scope.$storage.extableAll[key].status;
                    if (numb == 1) {
                        $scope.linesConnected++;
                        $scope.linesAllIn++;
                        if (!$scope.$storage.extableAll[key].active) {
                            $scope.linesConnected--;
                            $scope.linesAllIn--;
                            $scope.linesDisactive++;
                        }

                    }

                    if (numb == 0 && $scope.$storage.extableAll[key].active) {
                        $scope.linesToConnect++;
                        $scope.linesAllIn++;
                        if (!$scope.$storage.extableAll[key].active) {
                            $scope.linesToConnect--;
                            $scope.linesDisactive++;
                            $scope.linesAllIn--;
                        }
                    }
                });

                    if($scope.$storage.module!=11 && $scope.linesToConnect>0 && $scope.linesAllIn>0){
                      $scope.blendCounter();
                      $scope.linesToConnect -= $scope.blendy;
                      $scope.linesAllIn -= $scope.blendy;
                    }

            }
            $scope.dokladkaDisplay = 0;
            $scope.showSameDokladka = function (numb, stat, $index) {

                if ($scope.dokladkaDisplay != numb){
                    $scope.$storage.extableAll[$index].dokladka_status = 1 - stat;
                    $scope.dokladkaDisplay = numb;
                }
                else
                    $scope.$storage.extableAll[$index].dokladka_status = 1 - stat;
                $scope.workToDoCounter();
                $scope.dokladkaCounter();

                if($scope.$storage.toDoListView==0 && $scope.linesConnected==0)
                    $scope.showToDoList(1);
                if($scope.$storage.toDoListView==1 && $scope.linesToConnect==0 && $scope.dokladkaList==0)
                    $scope.showToDoList(0);

            }


            $scope.checkWorkProgress = function () {
                var progress = 0;
                var counter = 0;
                angular.forEach($scope.$storage.extableAll, function (value, key) {

                    if ($scope.$storage.extableAll[key].active) {
                        progress += $scope.$storage.extableAll[key].status;
                        progress += $scope.$storage.extableAll[key].status;
                        if ($scope.$storage.extableAll[key].dokladka > 0) {
                            progress += $scope.$storage.extableAll[key].dokladka_status;
                            counter += 1;
                        }
                        counter += 2; 
                    }

                });

                    if($scope.$storage.module!=11){
                      counter -= 2*$scope.blendy;
                    }

                counter = progress / counter * 100;
                if(counter<100){
                    $scope.finalTimeGuard=0;
                    $scope.$storage.finalWorkTime = 0;
                }

                if(counter == 100 && $scope.finalTimeGuard==0){
                    // $scope.$storage.toDoListView = 2;
                    $scope.finalTimeGuard = 1;
                    $scope.$storage.finalWorkTime = $scope.synctime()-$scope.$storage.startWorkTime;
                }
                return counter;
            }

            $scope.$storage.toDoListView = 2;

            $scope.showToDoList = function (numb) {
                $scope.$storage.toDoListView = numb;
                if(numb==0){
                    $('.connectionsNavigator').animate({left: '33.33%'});
                }
                if(numb==1){
                    $('.connectionsNavigator').animate({left: '0'});
                }
                if(numb==2){
                    $('.connectionsNavigator').animate({left: '66.66%'});
                }
            }

            $scope.doClockFromSeconds = function (sec) {
                let czas = moment('2000-01-01').startOf('day').seconds(sec / 1000)
                return moment(czas).diff(moment('2000-01-01').startOf('day'), 'hours') + moment(czas).format(":mm:ss");
            }


            $http.get('/extable/loadAkcjezadans?zadanie_id=46').then(function (res) {

                $scope.baseLogsBufferList1 = res;
            }, function (e) {
                console.error('błąd odczydu danych database')
            });


            $scope.projektID = $scope.$storage.projektkod;

            $http.get('/extable/loadAkcjazadansVal?kodproj=' + $scope.projektID).then(function (res) {

                $scope.akcjaZadansVal = res;

            }, function (e) {
                console.error('błąd odczydu danych database')
            });



            $scope.showleftmenu = true;


/************************
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*/





            var time = moment().locale('pl');
            $scope.oknozatrzymaj = false;

            $scope.statusk = 1;
            $scope.statusp = 1;
            $scope.status = 0;

            $scope.statusyopis = {!!json_encode(\Config::get('app.statusy',[]))!!};

            $scope.pierwszystart_odczytwkretarka = true;

            if ($scope.$storage.selitem == undefined)
                $scope.$storage.selitem = 0;

            <?php
                $config = \App\Ekran::where('ip', Request::ip())->get()->first();
                if ($config == null)
                    $config = \App\Ekran::where('module', 0)->get()->first();

                if ($config != null) {
                    $selmodule = $config->module;
                    if (\Request::get('module', null) != null) {
                        $selmodule = \Request::get('module', '0');
                    }
                }
                ?>





            if ($scope.$storage.czasostatniegozadaniakablowania == undefined) $scope.$storage.czasostatniegozadaniakablowania = 0; //czas ostatniego zadania kablowania
            if ($scope.$storage.statusylog == undefined) $scope.$storage.statusylog = []; //log zmiany statusów
            if ($scope.$storage.zmianylog == undefined) $scope.$storage.zmianylog = []; //log zmiany statusów
            if ($scope.$storage.statusyczasy == undefined) $scope.$storage.statusyczasy = []; // log zmian statusów, ilosci elementów, czasów zadanych na element
            if ($scope.$storage.czasprojektu == undefined) $scope.$storage.czasprojektu = {};
            if ($scope.$storage.praceczasy == undefined) $scope.$storage.praceczasy = [];
            if ($scope.$storage.wkretarkalog == undefined) $scope.$storage.wkretarkalog = [];
            if ($scope.$storage.projekt == undefined) $scope.$storage.projekt = 0;
            if ($scope.$storage.przerwy == undefined) $scope.$storage.przerwy = [];
            if ($scope.$storage.logstatusowy == undefined) $scope.$storage.logstatusowy = [];
            if ($scope.$storage.iloscwykonana == undefined) $scope.$storage.iloscwykonana = 0; // ilosc elementow wykonanych
            if ($scope.$storage.iloscusunietych == undefined) $scope.$storage.iloscusunietych = 0; // ilosc elementow usunietych


            if ($scope.$storage.module == undefined)
                $scope.$storage.module = {{$selmodule}};

            $scope.czasprojsek = 0; //wyliczenie czasu projektu w sek

            @if($config!=null)
                $scope.$storage.config = {!! $config->config !!};
            $scope.config = {!! $config->config !!}
            @endif


            //    $scope.config =  $scope.$storage.config.config;
            //    console.log($scope.config);


            if ($scope.$storage.ostatniaaktualizacjaserwera == undefined) $scope.$storage.ostatniaaktualizacjaserwera = null; // ostatnia aktualicja serwera
            if ($scope.$storage.ostatniaaktualizacjadanych == undefined) $scope.$storage.ostatniaaktualizacjadanych = null; // ostatnia aktualicja danych lokalnych
            if ($scope.$storage.czasostatniejzmianystatusu == undefined) $scope.$storage.czasostatniejzmianystatusu = null; // ostatnia aktualicja danych lokalnych

            $scope.wkretarkaostatniedane = {}

            $scope.start = function () {
                cfpLoadingBar.start();
            };

            $scope.start();

            // typ: rodzaj akceptacji
            /*     potwierdzenie ręczne
             *     potwierdzenie za pomocą wkrętarki
             *     potwierdzenie reczne lub wkrętarka
             *
             */

            /*
             * możliwe status
             *
             * 0 nie wykonano
             * 1 wykonano ok
             * 2 wyknano nie ok
             * 3 brak
             */

            $scope.dodajdologa = function (status) {
                let log = {
                    status: status,
                    elemid: $scope.$storage.database[$scope.$storage.selitem].id,
                    czas: $scope.synctime(),
                    userid: $scope.$storage.userloginid,
                    projid: $scope.$storage.projekt,
                    projkod: $scope.$storage.projektkod,
                    iloscwykonana: $scope.$storage.iloscwykonana,
                    selitem: $scope.$storage.selitem
                };
                $scope.$storage.zmianylog.push($scope.$storage.selitem);
                $scope.zmienczasprojektu();
                // console.log($scope.$storage.database[$scope.$storage.selitem]);
                $scope.$storage.ostatniaaktualizacjadanych = $scope.synctime(); // aktualny czas zsynchronizowany z serwerem
                $scope.$storage.praceczasy.push(log);
            }


            $scope.zapiszproglog = function () {
                $http.post('/extable/projektlogs', {dane: $scope.$storage.czasprojektu}).then(function (d) {


                }, function (e) {
                });
            }

            $scope.zatrzymaj = function () {
                $scope.oknozatrzymaj = true;

            }


            // aktualizacjia czasu projektu
            $interval(function () {
                $scope.savelogs = true;
            }, 60000);


            // automatyczny zapis loga
            $interval(function () {

                if ($scope.$storage.userloginid == undefined)
                    $scope.logoffx();

                angular.forEach($scope.$storage.przerwy, function (val, key) {

                    if ($scope.status == 0 && moment(val.czasstart).format("hh:mm") <= moment($scope.synctime()).format("hh:mm") && moment(val.czaskoniec).format("hh:mm") > moment($scope.synctime()).format("hh:mm")) {
                        $scope.zmien_status(1);
                    }
                    if ($scope.status == 1 && moment(val.czaskoniec).format("hh:mm") <= moment($scope.synctime()).format("hh:mm")) {
                        $scope.zmien_status(0);
                    }
                });


                var dane = [];
                angular.forEach($scope.$storage.zmianylog, function (val, key) {
                    dane.push($scope.$storage.database[val])
                });
//        zmiana danych dokonuje się tylko gdy zostanie wykonana operacja 
                if ($scope.$storage.praceczasy.length > 0 || $scope.$storage.zmianylog.length > 0 || $scope.$storage.wkretarkalog.length > 0 || $scope.savelogs) {
                    $scope.zmienczasprojektu();

                    let czasdzis = moment().diff($scope.$storage.userlogintime, 'seconds');


                    let compdata = {
                        czasprojektu: $scope.czasprojdodzis(),
                        czaslogowania: $scope.$storage.userlogintime,
                        czaskablowania: $scope.wyliczczaskablowanialiczba(),
                        status: $scope.status,
                        statusk: $scope.statusk,
                        statusp: $scope.statusp,
                        userid: $scope.$storage.userloginid,
                        kodproj: $scope.$storage.projektkod,
                        projid: $scope.$storage.projekt,
                        kompid: $scope.config.komputerid,
                        projstatus: $scope.projstatus,
                        czasaktualny: $scope.synctime(),
                        zadstatus: $scope.zadstatus,
                        okablowalem: $scope.$storage.iloswykonana,
                        okablowalem: $scope.$storage.iloscusunietych,
                    }

                    $http.post('/extable/savelogs', {
                        compdatax: compdata,
                        dane: $scope.$storage.praceczasy,
                        elementy: dane,
                        czasproj: $scope.$storage.czasprojektu,
                        danewkretarki: $scope.$storage.wkretarkalog,
                        loguser: $scope.$storage.statusylog,
                        statusyczasy: $scope.$storage.statusyczasy
                    }).then(function (r) {
                        //console.log(r);
                        $scope.savelogs = false;
                        delete $scope.$storage.statusyczasy;
                        delete $scope.$storage.praceczasy;
                        delete $scope.$storage.zmianylog;
                        $scope.$storage.statusyczasy = [];
                        $scope.$storage.praceczasy = [];
                        $scope.$storage.zmianylog = [];
                        $scope.$storage.przerwy = r.data.przerwy;
                    }, function (e) {

                    })


                }

                if (moment($scope.synctime()).format('mm:ss') == '00:00') $scope.zmien_status($scope.status);

                //
//        logstatusowy
//        var czas = moment($scope.synctime()).format('YYYYMMDDhh');
//        $scope.czasstat = czas+''+$scope.status;
//        if($scope.storage.logstatusowy[$scope.czasstat]==undefined)
//            $scope.storage.logstatusowy[$scope.czasstat]={czasstatus:$scope.czasstat,updated_at:$scope.synctime(),status:$scope.stat,selstat:}
//        var rekord = $scope.storage.logstatusowy[$scope.czasstat]; 
//            
//        $scope.storage.logstatusowy[$scope.czasstat] = rekord;

            }, 1000);


            // wyliczenie czasu dziennego dla projektu
            $scope.zmienczasprojektu = function () {

                var data_czas = moment().format("YYYYMMDD") + $scope.$storage.userloginid + "_" + moment($scope.$storage.userlogintime).format("YYYMMDDHHmmss");
                var rekord = $scope.$storage.czasprojektu[data_czas];
                if (rekord == undefined) {
                    rekord = {
                        projektid: $scope.$storage.projekt,
                        userid: $scope.$storage.userloginid,
                        projkod: $scope.$storage.projektkod,
                        czaslogowania: $scope.$storage.userlogintime,

                        czaspracy: moment().diff($scope.$storage.userlogintime, 'seconds'),
                    }
                }
                else {
                    rekord.czaspracy = moment().diff($scope.$storage.userlogintime, 'seconds');
                }

                var sum = 0;
                angular.forEach($scope.$storage.czasprojektu, function (val, key) {
                    if (val.czaslogowania != $scope.$storage.userlogintime && val.projektid == $scope.$storage.projekt)
                        sum += val.czaspracy;
                });
                $scope.czasprojsek = sum;

                $scope.$storage.czasprojektu[data_czas] = rekord;
            }

            /**
             * czas projektu do teraz
             */
            $scope.czasprojdodzis = function () {
                if ($scope.czasprojsek == 0) {
                    var sum = 0;

                    angular.forEach($scope.$storage.czasprojektu, function (val, key) {
                        if (val.czaslogowania != $scope.$storage.userlogintime && val.projektid == $scope.$storage.projekt)

                            sum += parseInt(val.czaspracy);
                    })
                    $scope.czasprojsek = sum;
                }
                return $scope.czasprojsek;
            }


            $scope.wyliczczasprojektu = function () {
                $scope.czasprojdodzis();

                let czasdzis = moment().diff($scope.$storage.userlogintime, 'seconds');

                let czas = moment('2000-01-01').startOf('day').seconds($scope.czasprojsek + czasdzis);

                if (czas > ($scope.$storage.czasoczekiwanynaproj * 0.8) && czas < $scope.$storage.czasoczekiwanynaproj)
                    $scope.statusp = 2;
                else if (czas > $scope.$storage.czasoczekiwanynaproj)
                    $scope.statusp = 3;
                else
                    $scope.statusp = 1;

                return moment(czas).diff(moment('2000-01-01').startOf('day'), 'hours') + moment(czas).format(":mm:ss");
            }

            $scope.anulujwykonane = function () {
                $scope.dodajdologa(0);
                let rekord = $scope.$storage.database[$scope.$storage.selitem];
                rekord.status = 0;
//        rekord.silawykonana =  wkretarkasila;
                let czaskablowania = $scope.wyliczczaskablowanialiczba();
                rekord.czaswykonywanyz += czaskablowania;

                $scope.logpracy($scope.status, rekord, czaskablowania);
                $scope.$storage.czasostatniegozadaniakablowania = new Date();
                $scope.$storage.database[$scope.$storage.selitem] = rekord;
                $scope.$storage.iloscusunietych++;
            }

            $scope.brakaparatu = function () {
                $scope.dodajdologa(2);
                let rekord = $scope.$storage.database[$scope.$storage.selitem];
                rekord.status = 2;
                let czaskablowania = $scope.wyliczczaskablowanialiczba();
                rekord.czaswykonywanyz += czaskablowania;
                $scope.$storage.czasostatniegozadaniakablowania = new Date();
                $scope.$storage.database[$scope.$storage.selitem] = rekord;
                $scope.logpracy($scope.status, rekord, czaskablowania);

//        $scope.logpracy($scope.status, rekord, czaskablowania);
                angular.forEach($scope.$storage.database, function (val, key) {
                    if (val.aparat == rekord.aparat)
                        val.status = 2;
                });

                $scope.nastepny();
            }

            $scope.montujaparat = function () {
                $scope.dodajdologa(0);
                let rekord = $scope.$storage.database[$scope.$storage.selitem];
                rekord.status = 0;
                let czaskablowania = $scope.wyliczczaskablowanialiczba();
                rekord.czaswykonywanyz += czaskablowania;
                $scope.$storage.database[$scope.$storage.selitem] = rekord;

                $scope.logpracy($scope.status, rekord, czaskablowania);

                angular.forEach($scope.$storage.database, function (val, key) {
                    if (val.aparat == rekord.aparat)
                        val.status = 0;
                });
            }

            $scope.zmien_status = function (nowy_status) {
                //$scope.status = nowy_status;

                $scope.oknozatrzymaj = false

                if ($scope.$storage.czasostatniejzmianystatusu == null)
                    $scope.$storage.czasostatniejzmianystatusu = $scope.$storage.userlogintime;

                if (nowy_status != 0) {
                    let rekord = $scope.$storage.database[$scope.$storage.selitem];
                    let czaskablowania = $scope.wyliczczaskablowanialiczba();
                    rekord.czaswykonywanyz += czaskablowania;
                    $scope.$storage.database[$scope.$storage.selitem] = rekord;
                }

                $scope.$storage.czasostatniegozadaniakablowania = new Date;

                let czas_teraz = $scope.synctime();
                let czassek = moment(czas_teraz).diff(new Date($scope.$storage.czasostatniejzmianystatusu), 'seconds');
                $scope.logpracy($scope.status, $scope.$storage.database[$scope.$storage.selitem], czassek);
                $scope.$storage.statusylog.push({
                    czas: czas_teraz,
                    poprzedni: $scope.$storage.czasostatniejzmianystatusu,
                    statuspoprzedni: $scope.status,
                    statusnowy: nowy_status,
                    wykonanie: $scope.$storage.iloscwykonana,
                    iloscusunietych: $scope.$storage.iloscusunietych,
                    iloscsek: czassek
                })
                $scope.$storage.czasostatniejzmianystatusu = czas_teraz;
                $scope.$storage.iloscusunietych = 0;
                $scope.$storage.iloscwykonana = 0;
                $scope.status = nowy_status;
                $scope.savelogs = true;
            }

//    console.log($scope.$storage.statusylog);

            $scope.logpracy = function (status, element, czas) {
                // dodaj loga user zmidyfikowal element
                /* statusy
                 * -1 - wylogowanie
                 * -2 - logowanie
                 */
                let elemstat = -1;
                if ($scope.$storage.database[$scope.$storage.selitem] != undefined)
                    elemstat = $scope.$storage.database[$scope.$storage.selitem].status

                $scope.$storage.statusyczasy.push({
                    elementid: element.id,
                    elemstatus: elemstat,
                    userid: $scope.$storage.userloginid,
                    projkod: $scope.$storage.projektkod,
                    projektkodid: $scope.$storage.projektkodid,
                    status: status,
                    duration: czas,
                    expectedtime: element.czasoczekiwany,
                    czasdodania: $scope.synctime()
                });
            }

            // $scope.wykonane = function (wkretarkasila=-1, wkretarka=-1) {

            //     $scope.dodajdologa(1);
            //     let rekord = $scope.$storage.database[$scope.$storage.selitem];
            //     rekord.status = 1;
            //     rekord.silawykonana = wkretarkasila;

            //     let czaskablowania = $scope.wyliczczaskablowanialiczba();
            //     rekord.czaswykonywanyz += czaskablowania;

            //     $scope.$storage.czasostatniegozadaniakablowania = new Date();
            //     $scope.$storage.database[$scope.$storage.selitem] = rekord;

            //     $scope.logpracy($scope.status, rekord, czaskablowania);

            //     $scope.$storage.iloscwykonana++;
            //     $scope.nastepny();
            // }


            $scope.nastepny = function () {
                let ilosc = 0;
                let elementx = $scope.$storage.selitem;
                let obecne = $scope.$storage.selitem;

//          console.log($scope.$storage.database.length);

                while (obecne == $scope.$storage.selitem && ilosc > $scope.$storage.database.length - 1) {
                    console.log(ilosc);
                    ilosc++;
                    elementx++;
                    if (elementx < $scope.$storage.database.length && $scope.$storage.database[elementx].status != 1) {
                        $scope.$storage.selitem = elementx;
                    }
                    if (elementx > $scope.$storage.database.length - 1) {
                        elementx = -1;
                    }
                    if (elementx == obecne) {
                        ilosc++;
                    }
                }

                if (obecne != $scope.$storage.selitem) $scope.back = obecne;


                $scope.selelementdetal($scope.$storage.selitem, $scope.back); // zmien element
            }


            $scope.konieckablowania = function () {
                let rekord = $scope.$storage.database[$scope.$storage.selitem];
                let czaskablowania = $scope.wyliczczaskablowanialiczba();
                rekord.czaswykonywanyz += czaskablowania;
                $scope.logpracy(-1, $scope.$storage.database[$scope.$storage.selitem], rekord.czaswykonywanyz);
                $scope.$storage.database[$scope.$storage.selitem] = rekord;
                $scope.zapiszproglog();

                setTimeout(function () {
                    $scope.logoffx();
                }, 2000)
            }


//     $scope.onExit = function() {
//         $scope.konieckablowania();
//         $scope.zapiszproglog();
//         
//      return true;
//    };

            //$window.onbeforeunload =  $scope.onExit;

            /*
             *
             *
             */
            $scope.wyliczczaskablowanialiczba = function () {
                if ($scope.$storage.czasostatniegozadaniakablowania == 0 || $scope.$storage.czasostatniegozadaniakablowania < $scope.$storage.userlogintime)
                    $scope.$storage.czasostatniegozadaniakablowania = $scope.$storage.userlogintime;

                let czasdzis = moment().diff($scope.$storage.czasostatniegozadaniakablowania, 'seconds');

                return czasdzis;
//        return moment().diff($scope.$storage.czasostatniegozadaniakablowania,'hours')+moment().format(":mm:ss");
            }


            /*
             *
             *
             */
            $scope.wyliczczaskablowania = function () {
                let czasdzis = $scope.wyliczczaskablowanialiczba();
                let czas = moment('2000-01-01').startOf('day').seconds(czasdzis);
                // wyliczenie status dla kablowania
                if (czasdzis >= ($scope.$storage.czasoczekiwanynapunkt * 0.8) && czasdzis < $scope.$storage.czasoczekiwanynapunkt)
                    $scope.statusk = 2;
                else if (czasdzis > $scope.$storage.czasoczekiwanynapunkt)
                    $scope.statusk = 3;
                else
                    $scope.statusk = 1;

//        $scope.statusk = czasdzis >= ($scope.$storage.czasoczekiwanynapunkt*0.8) 
                $scope.czasKablowaniaSekundy = czasdzis;
                return moment(czas).diff(moment('2000-01-01').startOf('day'), 'hours') + moment(czas).format(":mm:ss");
            }


            /*
             *
             *
             */
            $scope.selelementdetal = function (elem, old) {
//        console.log($scope.$storage.database[elem]);
                $scope.back = old;
                $scope.$storage.selitem = elem;
                if ($scope.config.wkretarka && $scope.$storage.database[$scope.$storage.selitem].silaprogram != "") {
                    $http.get($scope.config.wkretarkaadres + '/job?job=' + $scope.$storage.database[$scope.$storage.selitem].silaprogram).then(function (e) {

                    }, function (e) {
                    })
                }
            }


            // wyloguj z systemu zapisz dane do bazy
            $scope.logoffx = function () {
                delete $scope.$storage.userloginid;
                delete $scope.$storage.userlogintime;
                delete $scope.$storage.projektkod;
                delete $scope.$storage.projekt;
                location.href = '/modoee/login';
            }

            /*
             * -1 logowanie
             * {status:0, czas:"2017-09-01D22:00:00Z"}
             * -2 wylogowanie
             */
            if ($scope.$storage.database == undefined || $scope.$storage.database.length == 0)
                $scope.$storage.database = [];


            /**
             * pobranie danych z modułu
             */
            $scope.wczytajprojekt = function (module) {
                $scope.$storage.module = module;
                $scope.zapiszproglog();
                $http.get('/extable/database?modul=' + $scope.$storage.module + '&projid=' + $scope.$storage.projekt + '&projkod=' + $scope.$storage.projektkod).then(function (res) {
                    delete $scope.$storage.database;
                    if ($scope.$storage.selitem == undefined || res.data.dane.length >= $scope.$storage.selitem)
                        $scope.$storage.selitem = 0;
                    $scope.$storage.database = res.data.dane;
                    $scope.$storage.czasprojektu = res.data.projlog;

                    var oczekiwany = 0;
                    angular.forEach($scope.$storage.database, function (val, key) {
                        oczekiwany += parseInt(val.czasoczekiwany);
                    });

                    $scope.$storage.czasoczekiwanynaproj = oczekiwany;
                    $scope.$storage.czasoczekiwanynapunkt = oczekiwany / $scope.$storage.database.length;


//            console.log(res.data.projlog);
                    $scope.logowanieuseraproc();
//            $scope.$storage.przerwy = res.data.przerwy;
                }, function (e) {
                    console.error('błąd odczydu danych database')
                });
            }


            // wczytaj projekt jeżeli jest okreslony moduł
            if ($scope.$storage.module != 0)
                $scope.wczytajprojekt($scope.$storage.module);
            else {
                $http.get('/extable/databasemod?modul=' + $scope.$storage.module + '&projid=' + $scope.$storage.projekt + '&projkod=' + $scope.$storage.projektkod).then(function (res) {
                    // jakie są moduły
                    $scope.datamod = res.data;

                }, function (e) {
                    console.error('błąd odczydu danych database')
                });
            }


            // wyliczenie czasu zalogowania
            $scope.logowanie = function () {
                let czas_godzinowy = moment().diff($scope.$storage.userlogintime, 'hours');
                let czas = moment(moment().diff($scope.$storage.userlogintime)).format(":mm:ss");
                return czas_godzinowy + czas;
            }

            $scope.dane = {};


            $scope.getStatusElemItem = function (elem) {
                return 'status' + $scope.$storage.database[elem].status;
            }

            try {
                //synchroniozacja czasu
                $http.get('/modoee/time').then(function (e) {
//            console.log(e.data.time);
                    $scope.$storage.timeoffset = parseInt(new Date(e.data.time) - new Date(time.format("YYYY-MM-DD\THH:mm:ss.000") + 'Z'));
                    $scope.$storage.timeoffsetxx = $scope.synctime();
//            $scope.$storage.timeoffset1 = new Date().getTimezoneOffset();
                    $scope.$storage.timeoffset2 = new Date(e.data.time);
//            $scope.$storage.timeoffset3 = time.format("YYYY-MM-DD\THH:mm:ss.000\Z") //.format('YYYY-MM-DD\THH:mm:ss.SSS')+"Z";

                })
            } finally {

            }

            $scope.explode = function (tekst) {

            }


            $interval(function () {
                $scope.$storage.timeoffsetxx = $scope.synctime();
            }, 1000)

            if ($scope.config != null && $scope.config.wkretarka) {
                // komunikacja z wkretarka
                $interval(function () {

                    $http({
                        url: $scope.config.wkretarkaadres + '/data',
                        method: 'GET',
                        params: {ip: $scope.config.wkretarkaip, port: $scope.config.wkretarkaport}
                    }).then(function (e) {
                        //console.log(e.data);
                        $scope.wkretarkaostatniedane.licznik = e.data[0].licznik;
                        $scope.wkretarkaostatniedane.connect = e.data[0].connect;
                        $scope.wkretarkaostatniedane.keepalive = e.data[0].keepalive;
                        if ($scope.wkretarkaostatniedane.numerzdarzenia != e.data[0].numerzdarzenia && !$scope.pierwszystart_odczytwkretarka) {
                            $scope.wkretarkaostatniedane = e.data[0];
                            if (e.data[0].wkrstatus == true) {
                                $scope.$storage.wkretarkalog.push({
                                    zadanieid: $scope.$storage.database[$scope.$storage.selitem].id,
                                    dane: $scope.wkretarkaostatniedane
                                })
                                $scope.wykonane($scope.wkretarkaostatniedane.silawykonana, $scope.wkretarkaostatniedane.numerprogramu);
                            }
                        } else if ($scope.pierwszystart_odczytwkretarka) {
                            $scope.pierwszystart_odczytwkretarka = false;
                            $scope.wkretarkaostatniedane = e.data[0];
                        }
                    }, function (x) {

                    })
                }, 1000);
            }


            $scope.zmienzadanie = function (m) {
                $scope.$storage.module = m;
                location.reload();

            }

            $scope.pezelaczzadania = function () {
                $scope.chmodule = 1;
                $http.get('/extable/zadania?projid=' + $scope.$storage.projekt).then(
                    function (e) {
                        $scope.selzadania = e.data;

                    },
                    function (e) {
                    }
                );
            }


            $scope.logowanieuseraproc = function () {
                if ($scope.$storage.userlogowanie && $scope.$storage.database.length > 0) {
                    delete $scope.$storage.statusylog;
                    $scope.$storage.statusylog = [];
                    $scope.zmien_status(0);
                    let rekord = $scope.$storage.database[$scope.$storage.selitem];
                    $scope.logpracy(-2, rekord, rekord.czaswykonywanyz);
                    $scope.$storage.userlogowanie = false;
                    $scope.savelogs = true;
                }
            }


            $scope.complete = function () {
                cfpLoadingBar.complete();
            };

            $scope.keyView = false; // ukryj klawiature


            $scope.caruselView = 2;

            jsKeyboard.init("virtualKeyboard");

            $scope.manual = function () {
                $scope.manualne = !$scope.manualne;

            }

            $scope.hidemenu = function () {
                $scope.$storage.showleftmenu = !$scope.$storage.showleftmenu;
            }

            setTimeout(function () {
                $scope.scrolls = $('.myscroll').jScrollPane({autoReinitialise: true});
            }, 400);


            //if(!$scope.$storage.extableAll)
            // if($scope.extableBufferList)
            //  $scope.$storage.extableAll = $scope.extableBufferList;


            $scope.complete();
            $scope.loadpage = true;
        }]);

  $(document).ready(function() {
    



  });

    </script>
@endsection