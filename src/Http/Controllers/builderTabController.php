<?php

namespace ciscmodule\extable\Http\Controllers;

use App;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use modoeeTemplate;
use ciscmodule\modoee\Http\Controllers\Controller;  
use ciscmodule\modoee\Model\Projloguser;
use ciscmodule\extable\Model;

class builderTabController extends Controller
{
 

    /**
     * zwraca listę zadań dla danego projektu
     */
    public function getZadania()
    {
        return \App\Zadanie::where('zlecenie_id', \Request::get('projid', 0))->get();
    }

    public function getAkcjazadansVal()
    {
      return \App\AkcjazadansVal::where('kodproj', \Request::get('kodproj',0))->get();    
    }

    public function extableBuffer()
    {
       $dane = \ciscmodule\extable\Model\Modoeeelement::find(\Request::get('kodproj',0));
       $module = \ciscmodule\extable\Model\Modoeemodule::where('modoeeschemes_id', $dane->modoeeschemes_id)->where('id',\Request::get('module_id',0))->get()->first();
       $extable = \ciscmodule\extable\Model\extable::where("module_id",$module->getKey())->get();
       // $dane = \ciscmodule\extable\Model\Modoeeelement::find('projectcode', '123')->first();
       // $dane = $dane->scheme->module[0]->extables;
       foreach($extable as $item)
       {
         foreach(['parent','child','blend','active','dokladka','revision'] as $elem)
            $item->{$elem} = (int) $item->{$elem};
            $item->status=0;
            $item->dokladka_status=0;
       } 
      return response()->json($extable);    
    }

        public function extableBufferCount()
    {
       $dane = \ciscmodule\extable\Model\Modoeeelement::find(\Request::get('kodproj',0));
       $module = \ciscmodule\extable\Model\Modoeemodule::where('modoeeschemes_id', $dane->modoeeschemes_id)->where('id',\Request::get('module_id',0))->get()->first();
       $extable = \ciscmodule\extable\Model\extable::where("module_id",$module->getKey())->count();
       // $dane = \ciscmodule\extable\Model\Modoeeelement::find('projectcode', '123')->first();
       // $dane = $dane->scheme->module[0]->extables;
      return response()->json($extable);    
    }

    public function extableProjectsBuffer() 
    {
       $dane = \ciscmodule\extable\Model\Modoeeelement::find(\Request::get('kodproj',0));
       $module = \ciscmodule\extable\Model\Modoeemodule::where('modoeeschemes_id', $dane->modoeeschemes_id)->where('id',\Request::get('module',0))->get()->first();
       // dd($module);
       // $dane = $dane->scheme->module()->find(\Request::get('module',0));

       //      $dane->projecttime = (int) $dane->projecttime;

      return response()->json($module);    
    }

    public function extableRevisions() 
    {
       $dane = \ciscmodule\extable\Model\extablerevisions::where('code', \Request::get('elemcode',0))->get();
      return response()->json($dane);    
    }
    public function extable_worklogUpdate() 
    {

        $attr = \Request::get('attributes');
       $dane = \ciscmodule\extable\Model\worklog::firstOrCreate(['ip' => $_SERVER['REMOTE_ADDR']]);  
       $dane->attributes=$attr;
       $dane->save();
    }
    public function extable_worklogView() 
    {
       $dane = \ciscmodule\extable\Model\worklog::where('ip',\Request::get('ip',0))->get();  
        return response()->json($dane);   
    }

    
    /**
     * sprawdzenie czy użytkownij jest zalogowany
     *
     * jak jest to przekierownaie do odpowiedniego modułu
     */
    public function index()
    {

        if (\Auth::user() != null) {
            // użytkownik jest zalogowany

        }
        // użytkonijk nie jest zalogowany
//       return redirect(Route('modoee.login')); 
        $this->Controller = 'builderTab';
        return $this->view('builderTab');
    }

    /*
     * wygenerowanie listy uzytkownikow
     */


    public function projectsBufferList()
    {

        $projlog = Projloguser::where('projektid', \Request::get('projid', 0))->where('projkod', \Request::get('projkod', ''))->get();
        return $projlog;

    }


    public function akcjezadansBufferList()
    {

        $akcje = \App\Akcjazadans::where('zadanie_id', \Request::get('zadanie_id', 0))->get();
        return $akcje;

    }


    public function getDatabase()
    {
        $zadaniemodel = \App\Zadanie::where('zlecenie_id', \Request::get('projid'))->where('typ', \Request::get('modul'))->get()->first();
        $projlog = Projloguser::where('projektid', \Request::get('projid', 0))->where('projkod', \Request::get('projkod', ''))->get();
        $projlog_data = [];
        foreach ($projlog as $item) {
            $projlog_data[$item->uid] = $item;
            $projlog_data[$item->uid]->czaslogowania = date("Y-m-d\TH:i:s", strtotime($item->czaslogowania)) . "Z";
            $projlog_data[$item->uid]->czaspracy = (int)$item->czaspracy;
        }

        foreach (\App\Akcjazadans::where('zadanie_id', $zadaniemodel->getKey())->select('*', \DB::raw("(select elemstatus from akcjazadansval where akcjazadansval.elemid=akcjazadans.id ORDER BY akcjazadansval.id DESC limit 1) as status"))->get() as $item) {
            if (is_null($item->status)) $item->status = 0;
            $dane[] = $item;
        }
        $zadanie = [
            'zadanie' => $zadaniemodel,
            'dane' => $dane,
            'projlog' => $projlog_data,
        ];
        return response()->json($zadanie);
    }

    /**
     * Zapis loga trwania projektu, system codziennie tworzy takiego loga po zalogowaniu się do systemu, i zlicza go przez cały dzieć pracy nad projektem
     * jeżeli pracownik zmieni zadanie, to log jest budowany ponownie, dla nowego zadania, system pamięta log historyczny w tabeli projloguser
     *
     * uid - unikalny kod składa się z datydzis_czasulogowania
     * projektid - projektid danych zadań, powiązanie z tabelą akcjazadanszadid
     * userid - id usera
     * czaslogowania - czas logowania do systemu
     * czaspracy - czas pracy nad danym projektem dziś !!
     *
     * @param Response $data
     */
    public function saveprojlogs($dane)
    {
        foreach ($dane as $key => $item) {
            $element = Projloguser::firstOrCreate(['uid' => $key]);
            if ($element->czaspracy != $item['czaspracy']) {
                $element->fill($item);
                $element->czaslogowania = Date("Y-m-d H:i:s", strtotime($item['czaslogowania']));
                $element->save();
            }
        }


    }


    public function postProjektlogs()
    {
        return $this->saveprojlogs(\Request::get('dane', []));
    }

    /**
     *  Wczytaj listem odułów
     *
     * @return array zwraca liste dostępnych modułów dla projektu
     */
    public function getDatabasemod()
    {
//        dd(\Request::all());
        $zadania = \App\Zadanie::where('zlecenie_id', \Request::get('projid', 0))->get();
        return response()->json($zadania);
    }

    public function postSavelogs()
    {
//        dd(\Request::all());
        $dane = \Request::get('dane', []);
        //  dd('test');
//        dd($dane);
        foreach ($dane as $key => $item) {
            $this->seveLog(
                \Request::get('userid', 0),
                \Request::get('modol', 0),
                \Request::get('compid', 0),
                $item['projid'],
                $item,
                $item['status']
            );
        }

        $this->saveprojlogs(\Request::get('czasproj', []));

        /*
         * czasdodania
         * duration
         * elementid
         * expectedtime
         * status
         * userid
         */

        $statusyczasy = \Request::get('statusyczasy', []);
        foreach ($statusyczasy as $item) {
            if (isset($item['projektkodid']))
                $elem = \ciscmodule\modoee\Model\Akcjazadansval::Create(['czas' => $item['duration'], 'elemstatus' => $item['elemstatus'], 'zadanieid' => $item['projektkodid'], 'elemid' => $item['elementid'], 'userid' => $item['userid'], 'data' => $item['czasdodania'], 'status' => $item['status'], 'kodproj' => $item['projkod']]);
        }

        $complog = \Request::get('compdatax', []);
        $complogdata = \App\zadlog::firstOrCreate(['compid' => $complog['kompid']]);
        $complogdata->user_id = $complog['userid'];
        $complogdata->time = $complog['czasaktualny'];
        $complogdata->status = $complog['status'];
        $complogdata->attr = json_encode($complog);
        $complogdata->akcjazadans_id = $complog['projid'];
        $complogdata->save();

        $przerwy = \App\Przerwy::where(function ($q) use ($complog) {
            $q->where('stanowiska', 'like', "%{$complog['kompid']}%");
            $q->orWhere('stanowiska', 'like', "{$complog['kompid']}%");
        })->get();

        $przerwy_arr = [];
        foreach ($przerwy as $item) {
            $exp = explode(",", $item->stanowiska);
            if (in_array($complog['kompid'], $exp)) {
                $item->czasstart = Date("Y-m-d\TH:i:s\Z", strtotime($item->czasstart));
                $item->czaskoniec = Date("Y-m-d\TH:i:s\Z", strtotime($item->czaskoniec));
                $przerwy_arr[] = $item;
            }

        }

        return response()->json(['przerwy' => $przerwy_arr]);
    }


}

