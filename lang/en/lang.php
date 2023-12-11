<?php return [
    'plugin' => [
        'name' => 'MallExtraAdmin',
        'description' => ''
    ],
    'attributes' => [
        'phone' => 'phone',
        'partitaiva'=>'vat nuber',
        'codicefiscale'=>'fiscal code'
    ],
    'errors' => [
        'phone' => [
             'required'=>'Phone field is required',   
             'numeric' => 'Phone field must be numeric',
             'digits_between' => 'Phone field between 8 e 16 chars',
             
            ],
         'partitaiva' => [
             'required' => 'Vat number is required.',
         ],
         'billing_company'=>[
            'required' => 'Billing company is required',
         ]
    ],
    'register_new_buyer' => 'Register new company',
    'no_permission'=>'You don\'t have permission to see this section',
    'welcome_agent'=>'Welcome back: ',
    'home_agent'=>'Agent Home Page',
    'vat'=>'Vat number',
    'fiscal_code'=>'Fiscal Code',
    'phone'=>'phone',
    'client_list'=>'Customer List',
    'company'=>'Billing Company',
    'email'=>'E-Mail',
    'impersonate'=>'Use Customer',
    'use_client'=>'Select',
    'used_user'=>'You are using customer:',
    'unlink_user'=>'Unlink current user',
    'goto_customer_list'=>'Go to Customers List',
    'goto_home_agente'=>'Got Home page Agente',       
];