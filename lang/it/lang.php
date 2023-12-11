<?php return [
    'plugin' => [
        'name' => 'MallExtraAdmin',
        'description' => ''
    ],
    'attributes' => [
        'phone' => 'telefono',
        'partitaiva'=>'partita iva',
        'codicefiscale'=>'codice fiscale'
    ],
    'errors' => [
        'phone' => [
             'required'=>'Il campo telefono è obbligatorio',   
             'numeric' => 'Il campo telefono deve contenere solo numeri.',
             'digits_between' => 'Il campo telefono deve essere compreso tra 8 e 16 caratteri.',
             
            ],
         'partitaiva' => [
             'required' => 'La partita iva è obbligatoria.',
         ],
         'billing_company'=>[
            'required' => 'La ragione sociale è obbligatoria.',
         ]
    ],
    'register_new_buyer' => 'Registra un nuovo cliente',
    'no_permission'=>'Non hai i permessi necessari per vedere questa pagina', 
    'welcome_agent'=>'Bentornato: ',
    'home_agent'=>'Home Page Agente',
    'vat'=>'Partita Iva',
    'fiscal_code'=>'Codice Fiscale',
    'phone'=>'Telefono',
    'client_list'=>'Elenco Clienti',
    'company'=>'Ragione Sociale',
    'email'=>'E-Mail',
    'impersonate'=>'Usa Cliente',
    'use_client'=>'Seleziona',
    'used_user'=>'Stai usando il cliente:',
    'unlink_user'=>'Cambia utente', 
    'goto_customer_list'=>'Vai a elenco clienti',
    'goto_home_agente'=>'Torna alla home', 
    'logout_agente'=>'Logout Agente',
    'mod_password_agente'=>'Modifica Password',  
    'agent_invalid'=>'L\'agente non sembra valido',
    'password_changed_ok'=>'Password aggiornata correttamente.'   
         
];