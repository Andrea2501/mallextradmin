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
       
            
        

    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
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
                'code_agente' => [
                    'label' => 'Codice agente',
                    'type' => 'text',
                    'span' => 'left',
                    'tab'=> 'Agente'
                    
                               
                ]
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

}
