<?php namespace Tecnotrade\Mallextraadmin\Components;

use Cms\Classes\ComponentBase;

use Cms\Classes\Page;


use Flash;
use Illuminate\Support\Facades\Validator;
use October\Rain\Exception\ValidationException;
use Session;
use Cookie;

use Redirect;

use Tecnotrade\Mallextraadmin\Models\MallAgentiModel as Agente;
use Tecnotrade\Mallextraadmin\Classes\SessionVariables as SessionFx;
use Hash;
use Random\Engine\Secure;
use RainLab\User\Facades\Auth;
use Illuminate\Http\Request;
use October\Rain\Exception\ApplicationException;

class InfoAgente extends ComponentBase
{
    public function componentDetails()
    {
        return [
        'name'        => 'Componente per la compilazione della home page agente',
        'description' => 'Usare la pagina agente.htm già configurata come home page agente', 
        ];
    }

    public function defineProperties(){
       return [
        'urlPaginaElencoClienti'=>[
            'title'=>'pagina elenco clienti slug',
            'description'=>'inserisci lo slug della pagina con elenco clienti',
            'type' => 'text',
            'validation' => [
                'required' => [
                    'message' => 'Devi inserire lo slug alla pagina dell\' elenco clienti',
                ],
            ],
        ],
        'urlPaginaCatalogo'=>[
            'title'=>'pagina catalogo slug',
            'description'=>'inserisci lo slug della pagina del catalogo prodotti',
            'type' => 'text',
            'validation' => [
                'required' => [
                    'message' => 'Devi inserire lo slug alla pagina del home del catalogo',
                ],
            ],
        ]
        ];
    }



    protected function prepareVars(){
        
        if(Session::has('agente')){
            if(Session::get('agente')){
                $agente=Session::get('agente');
               
                if (isset($agente->id)){
                    $idAgente=$agente->id;
                   
                    if(!empty($idAgente) && is_numeric($idAgente) && ($idAgente > 0)){
                        
                        $this->page["displayType"]="1";
                        $this->page["pageCatalogo"]='/'.$this->property('urlPaginaCatalogo');
                        $this->page['paginaElencoClienti']='/'.$this->property('urlPaginaElencoClienti');
                        $this->page["agenteInSessione"]=$agente;
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
                $this->page["is_impersonate_user"]=null;
                $this->page["agente_is_impersonate"]=0;
            }
        }
        else{
            $cookieAgente=Cookie::get('agente');
            if($cookieAgente && !empty($cookieAgente)){
                $objAgente=json_decode($cookieAgente);
                if(isset($objAgente->id)){
                    $agente=Agente::find($objAgente->id);
                    if($agente){
                        Session::put('agente',$agente);
                        $this->prepareVars();
                    }
                }
            }
            else{
                $this->page["displayType"]="0";
                $this->page["is_impersonate_user"]=null;
                $this->page["agente_is_impersonate"]=0;
            }
        }
    }

    public function onRun(){
        
        $this->addJs('assets/js/common.js?v=1.1');
        $this->page["linkToListClienti"]=$this->property('urlPaginaElencoClienti');
        $this->page["linkToHomeCatalogo"]=$this->property('urlPaginaCatalogo');
        $this->prepareVars();
       
    }

    public function onLogoutAgente(){
    $data = post();
    Cookie::queue('agente', null, -1);
    Session::forget('agente');
    if(Auth::getUser()){
        Auth::logout();
    }
    return Redirect::to('/');
    }
    public function onLogoutImpersonateUtente(){
        $data=post();
        $urlLista=$data["urllistautenti"];
        if(Auth::getUser()){
            Auth::logout();
            $cookieAgente=Cookie::get('agente');
            if($cookieAgente && !empty($cookieAgente)){
                $objAgente=json_decode($cookieAgente);
                if(isset($objAgente->id)){
                    $agente=Agente::find($objAgente->id);
                    if($agente){
                        Session::put('agente',$agente);
                        $this->prepareVars();
                    }
                }
            }
            return Redirect::to('/'.$urlLista);
        }

    }
    public function onUpdatePasswordAgente(){
        $data = post();
        $rules = [
            'agente_password' => sprintf('required|min:%d|max:255', 8),
            'agente_password_repeat' => 'required|same:agente_password',
            
        ];
        $messages=[
            'agente_password.required' => trans('offline.mall::lang.components.signup.errors.password.required'),
            'agente_password.min'      => trans('offline.mall::lang.components.signup.errors.password.min'),
            'agente_password.max'      => trans('offline.mall::lang.components.signup.errors.password.max'),

            'agente_password_repeat.required' => trans('offline.mall::lang.components.signup.errors.password_repeat.required'),
            'agente_password_repeat.same'     => trans('offline.mall::lang.components.signup.errors.password_repeat.same'),
        ];
        $validation = Validator::make($data, $rules, $messages);
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }
        else{
            $newPassword=$data["agente_password"];
            $idAgente=$data["idcurrentagente"];
            $agente=Agente::find($idAgente);
            if($agente){
                $agente->password=$newPassword;
                $agente->save();
                Flash::success(trans("tecnotrade.mallextraadmin::lang.password_changed_ok"));
                
            }
            else{
                throw new ApplicationException( trans("tecnotrade.mallextraadmin::lang.agent_invalid"));
            }
            
        }
        
    }

}