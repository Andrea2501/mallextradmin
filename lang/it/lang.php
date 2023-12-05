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
];