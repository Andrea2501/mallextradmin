<?php namespace Tecnotrade\Mallextraadmin\Classes;

use GuzzleHttp\Client;
use RainLab\User\Models\User as User;
use Session;
use Tecnotrade\Mallextraadmin\Models\MallAgentiModel as Agenti;
use RainLab\User\Facades\Auth;


class SessionVariables{

    private  $SESSION_NAME='afsesssion';
    private  $AGENTE_CODE='afsession.agentecode';
    private  $AGENTE_NAME='afsession.agentename';
    private  $AGENTE_MAIL='afsession.agentemail';
    private  $AGENTE_ID='afsession.agenteid';
    private  $AGENTE_LOGGEDIN='afsession.agenteloggedin';
    private  $AGENTE_ISIMPERSONATE_USER='afsession.agenteimpersonating';
    private  $USER_IMPERSONATE_ID='afsession.userid';

    
    public function startAgenteSession($codice,$nomecognome,$mail,$id){
        Session::push($this->AGENTE_CODE,$codice);
        Session::push($this->AGENTE_NAME,$nomecognome);
        Session::push($this->AGENTE_MAIL,$mail);
        Session::push($this->AGENTE_ID,$id);
        Session::push($this->AGENTE_LOGGEDIN,'1');
        Session::push($this->AGENTE_ISIMPERSONATE_USER,'0');
        Session::push($this->USER_IMPERSONATE_ID,'0');
        if(Session::has($this->AGENTE_ID)){
            return true;
        }
        else{
            return false;
        }
        
    }


}