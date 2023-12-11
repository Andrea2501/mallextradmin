<?php namespace Tecnotrade\Mallextraadmin\Components;

use Cms\Classes\ComponentBase;

use Cms\Classes\Page;


use Flash;
use Illuminate\Support\Facades\Validator;
use October\Rain\Exception\ValidationException;
use Session;

use Redirect;

use Tecnotrade\Mallextraadmin\Models\MallAgentiModel as Agente;
use Rainlab\User\Models\User as FrontendUsers;
use Rainlab\User\Models\User as OctoUser;
use Tecnotrade\Mallextraadmin\Classes\SessionVariables as SessionFx;
use Hash;
use Input;
use Illuminate\Http\Request; 
use Auth;





class ListaClienti extends ComponentBase
{
    public function componentDetails()
    {
        return [
        'name'        => 'Componente lista clienti la pagina elnco clienti',
        'description' => 'Componente lista clienti per la pagina elenco clienti', 
        ];
    }

    public function defineProperties(){
        return [
            'urlPaginaHomeAgenti'=>[
                'title'=>'inserisci lo slug della pagina della home page dell\' agente',
                'description'=>'inserisci lo slug della home page dell\' agente',
                'type' => 'text',
                'validation' => [
                    'required' => [
                        'message' => 'Devi inserire uno slug',
                    ],
                ],
            ],
        ];
            
    }


public $pageUrl;
public $displayForm;
public $nomeCliente;
public $frontendUser;
public $pageHomeAgente;


protected function prepareVars(){
    $this->page["urlHomeAgente"]=$this->property('urlPaginaHomeAgenti'); 
    $this->pageHomeAgente=$this->property('urlPaginaHomeAgenti');
        if(Session::has('agente')){
            if(Session::get('agente')){
                $agente=Session::get('agente');
               
                if (isset($agente->id)){
                    $idAgente=$agente->id;
                   
                    if(!empty($idAgente) && is_numeric($idAgente) && ($idAgente > 0)){
                        $this->page["displayType"]="1";
                        $this->page["frontendUser"]=$this->createListUsers();
                        $user=Auth::getUser();
                        if($user){
                            $this->page["user_impersonate"]=$user;
                            $this->page["agente_is_impersonate"]=1;
                        }
                        
                    }
                    else{
                        $this->page["displayType"]="0";
                        $this->page["user_impersonate"]=null;
                        $this->page["agente_is_impersonate"]=0;
                    }
                }
                else{
                    $this->page["displayType"]="0";
                    $this->page["user_impersonate"]=null;
                    $this->page["agente_is_impersonate"]=0;
                }
            }
            else{
                $this->page["displayType"]="0";
                $this->page["user_impersonate"]=null;
                $this->page["agente_is_impersonate"]=0;
            }
        }
}



public function onRun(){
    $this->addJs('assets/js/common.js?v=1.1');
    $this->addJs('assets/js/customerSearch.js?v=1.1');
    
    $this->prepareVars();
    
   
        
}

public function createListUsers($query=null){
    if($query){
        $frontendUsers = FrontendUsers::where('company','like','%'.$query.'%')
        ->orWhere('email','like','%'.$query.'%')
        ->orWhere('partitaiva','like','%'.$query.'%')
        ->orderBy('company')->paginate(15);

    }
    else{
    $frontendUsers = FrontendUsers::orderBy('company')->paginate(15);
    }
    return $frontendUsers;
}

public function onAgentiCustomerSearch(){
    $valToSearch=input("value");
    $q=null;
    if(trim($valToSearch)!=''){
        $q=$valToSearch;
    }
    $this->page["displayType"]="1";
    $this->page["results"]=$this->createListUsers($q);
    $this->page["items"]=$this->createListUsers($q);
   
    //return ['#table-customers' => $this->renderPartial('@items')];
}

public function onImpersonateCliente(){
    $data = post();
    $idUtente=$data["idutente"];
    $octoUser=OctoUser::find($idUtente);
    Auth::login($octoUser);
    return Redirect::to('/'.$this->property('urlPaginaHomeAgenti'));
}
public function onLogoutImpersonateCliente(){
    Auth::logout();
    return Redirect::to('/'.$this->property('urlPaginaHomeAgenti'));
}
    


}