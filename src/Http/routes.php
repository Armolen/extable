<?php


\Route::group(['middleware'=>'web'], function() {
    \Route::get('/', [
                    'as'   => 'extable',
                    'uses' => 'builderTabController@index',
            ]);
    \Route::get('database', [
                    'as'   => 'database',
                    'uses' => 'builderTabController@getDatabase',
            ]);
    \Route::post('savelogs', [
                    'as'   => '[przedm.zapiszlog',
                    'uses' => 'builderTabController@postSavelogs',
            ]);
    \Route::post('projektlogs', [
                    'as'   => '[przedm.projektlogs',
                    'uses' => 'builderTabController@postProjektlogs',
            ]);
    \Route::get('databasemod', [
                    'as'   => '[przedm.databasemod',
                    'uses' => 'builderTabController@getDatabasemod',
            ]);
    \Route::get('zadania', [
                    'as'   => '[przedm.zadania',
                    'uses' => 'builderTabController@getZadania',
            ]);



    \Route::get('extableBuffer', [
                    'as'   => '[przedm.downloadextable',
                    'uses' => 'builderTabController@extableBuffer',
            ]);

    \Route::get('extableRevisions', [
                    'as'   => '[przedm.downloadextable',
                    'uses' => 'builderTabController@extableRevisions',
            ]);
    \Route::get('extableBufferCount', [
                    'as'   => '[przedm.downloadextable',
                    'uses' => 'builderTabController@extableBufferCount',
            ]);
    
    \Route::get('extableProjectsBuffer', [
                    'as'   => '[przedm.downloadextable',
                    'uses' => 'builderTabController@extableProjectsBuffer',
            ]);

    \Route::get('downloadProjects', [
                    'as'   => '[przedm.downloadProjects',
                    'uses' => 'builderTabController@projectsBufferList',
            ]);

    \Route::get('loadAkcjazadansVal', [
                    'as'   => '[przedm.downloadAkcjazadansVal',
                    'uses' => 'builderTabController@getAkcjazadansVal',
            ]);
    
    \Route::get('loadAkcjezadans', [
                    'as'   => '[przedm.downloadProjects',
                    'uses' => 'builderTabController@akcjezadansBufferList',
            ]);
    \Route::get('worklogUpdate', [
                    'as'   => '[przedm.worklogUpdate',
                    'uses' => 'builderTabController@extable_worklogUpdate',
            ]);
        \Route::get('worklogView', [
                    'as'   => '[przedm.worklogUpdate',
                    'uses' => 'builderTabController@extable_worklogView',
            ]);
});

\Route::group(['middleware'=>'auth'], function() {
});

