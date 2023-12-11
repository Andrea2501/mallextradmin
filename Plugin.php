<?php namespace Tecnotrade\Mallextraadmin;

use Backend\Classes\BackendController;
use System\Classes\PluginBase;
use OFFLINE\Mall\Controllers\Products as ProductController;
use OFFLINE\Mall\Models\Product as ProductModel;
use Backend\Models\User as BackendUserModel;
use Backend\Controllers\Users as BackendUserController;
use Backend\Facades\BackendAuth as BackAuth;
use Exception as AppException;
use Rainlab\User\Models\User as UserModel;
use Rainlab\User\Controllers\Users as UsersController;
use Input;
use Session;
use Route;


/**
 * Plugin class
 */
class Plugin extends PluginBase
{
    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        Route::post('/listaclienti/impersonatecliente',function(\Illuminate\Http\Request $request) {
            return (new \Tecnotrade\Mallextraadmin\Components\ListaClienti())->onImpersonateCliente($request);
        });
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
        // aggiungo il campo del codice utente di backend che inserisce il prodotto alla tabella prodotti di mall
        $this->extendProductController();

        // aggiungo il campo codice amministratore al backend
        $this->extendBackendUserController();
     

        // faccio il binding della query della lista al controller dei prodotti
       $this->filterProductsByCodeAzienda();


       // estendo la funzione di creazione del prodotto
       $this->extendModelProductCreate();

       //estendo il modello customer aggiungendo il campo codice_agente
       $this->extendCustomerModel();

       $this->extendUserModelForSignup();

       $this->extraRulesForSignupUser();
       
      
            
        

    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return [
            'Tecnotrade\Mallextraadmin\Components\LoginAgente'=> 'LoginAgente',
            'Tecnotrade\Mallextraadmin\Components\InfoAgente'=> 'InfoAgente',
            'Tecnotrade\Mallextraadmin\Components\ListaClienti'=> 'ListaClienti',
        ];
    }

    /**
     * registerSettings used by the backend.
     */
    public function registerSettings()
    {
    }


    protected function extendProductController(){
        ProductController::extendFormFields(function($form, $model, $context) {
            if (!$model instanceof ProductModel) {
                return;
            }

            $form->addTabFields([
                'owner_code'=>[
                       'label' => 'Codice Owner',
                        'type' => 'text',
                        'span' => 'left',
                        'tab'=> 'offline.mall::lang.product.general' 
                                   
                    ]
                
            ]);
            
        });
        ProductController::extendListColumns(function($list, $model){
            if (!$model instanceof ProductModel) {
                return;
            }
            $list->addColumns([
                'owner_code' => [
                    'label' => 'Owner',
                    'type' => 'text',
                    'sortable' => true,
                    'invisible' => false,
                ]
            ]);
        });
    }
        protected function extendBackendUserController(){
            BackendUserController::extendFormFields(function($form, $model, $context) {
                if (!$model instanceof BackendUserModel) {
                    return;
                }
    
                $form->addTabFields([
                    'internal_code' => [
                        'label' => 'Codice Identificativo Univoco',
                        'type' => 'text',
                        'span' => 'left',
                        
                                   
                    ]
                ]);
                
            });
            BackendUserController::extendListColumns(function($list, $model){
                if (!$model instanceof BackendUserModel) {
                    return;
                }
                $list->addColumns([
                    'internal_code' => [
                        'label' => 'Code',
                        'type' => 'text',
                        'sortable' => true,
                        'invisible' => false,
                    ]
                ]);
            });

            

    }

    protected function getBackendUserData(){
        $currentUser=BackAuth::getUser();
        $backendUserCode=null;
        $backendUserRoleName=null;
        $backendUserRoleCode=null;
       
        if($currentUser){
            $backendUserCode=$currentUser->internal_code;
            $backendUserRoleName=$currentUser->role["name"];
            $backendUserRoleCode=$currentUser->role["code"];
            $backendUser=[
                "userCode"=>$backendUserCode,
                "userRole"=>$backendUserRoleName,
                "userRoleCode"=>$backendUserRoleCode,
            ];
            return $backendUser;
        }
        else{
            throw new AppException('L\'utente non sembra loggato');
            die();
        }
        
    }



    protected function filterProductsByCodeAzienda(){
        \Event::listen('backend.list.extendQuery', function ($listWidget, $query) {
            if (get_class($listWidget->getController()) !== ProductController::class)
                return;
            $backendUser=$this->getBackendUserData();

            $codiceBackendUser=$backendUser["userCode"];
            $ruoloUtente=$backendUser["userRole"];
            $userRoleCode=$backendUser["userRoleCode"];
            
            if(strtoupper($ruoloUtente)=="AZIENDA"){
                $query->where('owner_code','=',$codiceBackendUser);
            }
            else{
                // gli admin possono vedere tutto 
                return;
            }
        });
    }

    protected function extendModelProductCreate(){
       
        ProductModel::extend(function($model) {
            $model->bindEvent('model.beforeCreate', function() use ($model) {
                $backendUser=$this->getBackendUserData();
                $codiceBackendUser=$backendUser["userCode"];
                $ruoloUtente=$backendUser["userRole"];
                $userRoleCode=$backendUser["userRoleCode"];
                $model->owner_code=$userRoleCode;
                
            });
        });
    
    }

    protected function extendCustomerModel(){
        UsersController::extendFormFields(function($form, $model, $context) {
            if (!$model instanceof UserModel) {
                return;
            }

            $form->addTabFields([
                
                'partitaiva'=>[
                    'label'=> 'Partita iva',
                    'type'=>'Text',
                    'span'=>'left',
                    'tab'=>'rainlab.user::lang.user.account' 
                ],
                'codicefiscale'=>[
                    'label'=> 'Codice fiscale',
                    'type'=>'Text',
                    'span'=>'right',
                    'tab'=>'rainlab.user::lang.user.account' 
                ],
                'code_agente' => [
                    'label' => 'Codice agente',
                    'type' => 'text',
                    'span' => 'left',
                    'tab'=> 'rainlab.user::lang.user.account'
                    
                               
                ],
            ]);
            
            
        });
        UsersController::extendListColumns(function($list, $model){
            if (!$model instanceof UserModel) {
                return;
            }
            $list->addColumns([
                'code_agente' => [
                    'label' => 'Codice agente',
                    'type' => 'text',
                    'sortable' => true,
                    'invisible' => false,
                ]
            ]);
        });
    }
    
    protected function extendUserModelForSignup(){
        UserModel::extend(function ($model) {
            $model->addFillable(['phone']); // Crea il campo fillable, senza il quale non puoi salvare il campo
            $model->addFillable(['partitaiva']); // Crea il campo fillable, senza il quale non puoi salvare il campo
            $model->addFillable(['codicefiscale']);
            $model->addFillable(['company']);
            $model->addFillable(['street_addr']);
            $model->addFillable(['city']);
            $model->addFillable(['zip']);
            $model->addFillable(['state_id']);
            $model->addFillable(['country_id']);
            
            
            
            
            // Aggiungi regole di validazione personalizzate per il campo 'phone

            $model->attributeNames = [
                'phone' => trans('tecnotrade.mallextraadmin::lang.attributes.phone')
            ];
            $model->attributeNames = [
                'partitaiva' => trans('tecnotrade.mallextraadmin::lang.attributes.partitaiva')
            ];
            $model->attributeNames = [
                'codicefiscale' => trans('tecnotrade.mallextraadmin::lang.attributes.codicefiscale')
            ];
            
            // Prima di convalidare il modello User, aggiungi il valore dell'attributo phone dai dati del modulo di invio
            $model->bindEvent('model.beforeValidate', function () use ($model) {
                
                if (Input::has('phone') ) {
                    $phone = Input::get('phone');
                    $model->phone = $phone;
                }
                if (Input::has('partitaiva') ) {
                    $vat = Input::get('partitaiva');
                    $model->partitaiva = $vat;
                }

                if (Input::has('codicefiscale') ) {
                    $cf = Input::get('codicefiscale');
                    $model->codicefiscale = $cf;
                }
                
                if (Input::has('billing_company') ) {
                    $rs = Input::get('billing_company');
                    $model->company = $rs;
                }
                if (Input::has('billing_lines') ) {
                    $indirizzo = Input::get('billing_lines');
                    $model->street_addr = $indirizzo;
                }
                if (Input::has('billing_zip') ) {
                    $zip = Input::get('billing_zip');
                    $model->zip = $zip;
                }
                if (Input::has('billing_city') ) {
                    $city = Input::get('billing_city');
                    $model->city = $city;
                }
                if (Input::has('billing_country_id') ) {
                    $country = Input::get('billing_country_id');
                    $model->country_id = $country;
                }
                if (Input::has('billing_state_id') ) {
                    $state = Input::get('billing_state_id');
                    $model->state_id = $state;
                }
                  
                
                
            });
                    
        });
    }

    protected function extraRulesForSignupUser(){
        \Event::listen('mall.customer.extendSignupRules', function (&$rules, $forSignup) {
            // Aggiungi le tue regole di validazione personalizzate per il campo 'phone' qui
                $rules['phone'] = 'required|numeric|digits_between:7,16';
                $rules['partitaiva'] = 'required|unique:users,partitaiva';
                $rules['billing_company']='required';
                
                //$arrV=json_decode(($v));
               
                
            });
    }

  

}
