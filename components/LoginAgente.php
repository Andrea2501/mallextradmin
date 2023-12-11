<?php namespace Tecnotrade\Mallextraadmin\Components;

use Cms\Classes\ComponentBase;

use Cms\Classes\Page;
use Cookie;
use Flash;
use Illuminate\Support\Facades\Validator;
use October\Rain\Exception\ValidationException;
use Session;

use Redirect;

use Tecnotrade\Mallextraadmin\Models\MallAgentiModel as Agente;
use Tecnotrade\Mallextraadmin\Classes\SessionVariables as SessionFx;
use Hash;


class LoginAgente extends ComponentBase
{
    public function componentDetails()
    {
        return [
        'name'        => 'Componente per il login degli agenti',
        'description' => 'Componente per il login degli agenti', 
        ];
    }

    public function defineProperties(){
       return [
        'urlPaginaAuthAgenti'=>[
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


public $pageUrlHomeAgenti;
public $displayForm;
public $nomeCliente;

public function onRun(){
    //dd(Session::flush());
    $this->pageUrlHomeAgenti=$this->property('urlPaginaAuthAgenti'); 
    if(Session::has('agente')){
        return Redirect::to('/'.$this->pageUrl);
    }

}


public function onAgenteUserLogin(){
    $this->pageUrlHomeAgenti=$this->property('urlPaginaAuthAgenti'); 
    $data=post();

    $validation = Validator::make($data, [
        'email'=>'required|email',
        'password'=>'required',
        'terms_accepted'=>'required'
        
    
    ]);
    if ($validation->fails()) {
        throw new ValidationException($validation);
    }
    $email=$data['email'];
    $password=$data["password"];
    
    $agente=$this->getAgente($password,$email);
    if($agente){
        $nomeAgente=$agente->nome .' '. $agente->cognome;
        $idAgente=$agente->id;
        $codiceAgente=$agente->codice_agente;
        $agenteEmail=$agente->email;
        $redirect=$this->pageUrl.'/'.$idAgente.'/'.$codiceAgente;
        
        $agenteEncoded=json_encode($agente);
        Session::put('agente',$agente);
        $cookie=Cookie::forever('agente',json_encode($agente));
        Cookie::queue($cookie);
        
        $redirect=$this->pageUrlHomeAgenti;
        return Redirect::to('/'.$redirect);
        
        
        
        
    }
    else{
        
        Flash::error('Credenziali non valide');
    }

}

protected function getAgente($password,$email){
    $loggedUser=Agente::where('email','=',$email)
        ->first();
        
        if(isset($loggedUser)){
            $hashedPassword=$loggedUser->password;
            if(Hash::check($password,$hashedPassword)){
                return $loggedUser; 
            }
            else{
                return null;
            }
        }
        else{
            return null;
        }
}

}