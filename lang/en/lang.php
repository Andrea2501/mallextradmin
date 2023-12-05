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
];