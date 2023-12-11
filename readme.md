# PLUGIN PER GESTIONE PRODOTTI INDIVIDUALE PER ADMIN 

## DOWNLOAD PLUGIN

Al momento utilizzare l'url pubblico di git per scaricare il plugin, creare la cartella "mallextraadmin" all'interno di "plugins/tecnotrade", copiare il contenuto scaricato all'interno della cartella "plugins/tecnotrade/mallextraadmin"
Eseguire il comando:  php artisan october:migrate dalla root del sito

## PREMESSA

La pagina TWIG della Home agente è già stata creata per il corretto funzionamento, occorre stilarla.
Per le regole di autenticazione andare in : plugins/offline/mall/classes/customer/DefaultSignUpHandler.php

e aggiungere i campi contrassegnati con l asterisco:

```php

public static function messages(): array
    {
        return [
            'email.required'          => trans('offline.mall::lang.components.signup.errors.email.required'),
            'email.email'             => trans('offline.mall::lang.components.signup.errors.email.email'),
            'email.unique'            => trans('offline.mall::lang.components.signup.errors.email.unique'),
            'email.non_existing_user' => trans('offline.mall::lang.components.signup.errors.email.non_existing_user'),

            'firstname.required'           => trans('offline.mall::lang.components.signup.errors.firstname.required'),
            'lastname.required'            => trans('offline.mall::lang.components.signup.errors.lastname.required'),
            'billing_lines.required'       => trans('offline.mall::lang.components.signup.errors.lines.required'),
            'billing_zip.required'         => trans('offline.mall::lang.components.signup.errors.zip.required'),
            'billing_city.required'        => trans('offline.mall::lang.components.signup.errors.city.required'),
            'billing_country_id.required'  => trans('offline.mall::lang.components.signup.errors.country_id.required'),
            'billing_country_id.exists'    => trans('offline.mall::lang.components.signup.errors.country_id.exists'),
            'billing_state_id.required'    => trans('offline.mall::lang.components.signup.errors.state_id.required'),
            'billing_state_id.exists'      => trans('offline.mall::lang.components.signup.errors.state_id.exists'),
            'shipping_lines.required'      => trans('offline.mall::lang.components.signup.errors.lines.required'),
            'shipping_zip.required'        => trans('offline.mall::lang.components.signup.errors.zip.required'),
            'shipping_city.required'       => trans('offline.mall::lang.components.signup.errors.city.required'),
            'shipping_country_id.required' => trans('offline.mall::lang.components.signup.errors.country_id.required'),
            'shipping_country_id.exists'   => trans('offline.mall::lang.components.signup.errors.country_id.exists'),

            'password.required' => trans('offline.mall::lang.components.signup.errors.password.required'),
            'password.min'      => trans('offline.mall::lang.components.signup.errors.password.min'),
            'password.max'      => trans('offline.mall::lang.components.signup.errors.password.max'),

            'password_repeat.required' => trans('offline.mall::lang.components.signup.errors.password_repeat.required'),
            'password_repeat.same'     => trans('offline.mall::lang.components.signup.errors.password_repeat.same'),

            'terms_accepted.required' => trans('offline.mall::lang.components.signup.errors.terms_accepted.required'),
            *'phone.required'=>trans('tecnotrade.mallextraadmin::lang.errors.phone.required'),
            *'phone.numeric'=>trans('tecnotrade.mallextraadmin::lang.errors.phone.numeric'),
            *'phone.digits_between'=>trans('tecnotrade.mallextraadmin::lang.errors.phone.beetween'),
            *'partitaiva.required'=>trans('tecnotrade.mallextraadmin::lang.errors.partitaiva.required'),
            *'billing_company.required'=>trans('tecnotrade.mallextraadmin::lang.errors.billing_company.required'),
        ];
    }
```


## CREAZIONE AGENZIE
CREARE UN RUOLO IN ADMIN CHIAMATO AGENZIA
ASSEGNARE AGLI UTENTI AGENZIA UN CODICE INTERNO UNIVOCO
IL CODICE VERRA ASSEGNATO AL PRODOTTO AL MOMENTO DELLA CREAZIONE
ASSEGNARE I PERMESSI MINIMI NECESSARI AL RUOLO AGENZIA

## CREAZIONE AGENTI

CREARE GLI AGENTI DAL BACKEND
ASSEGNARE UN CODICE UNIVOCO A CIASCUN AGENTE

# FRONTEND

CREARE LE SEGUENTI PAGINE:
- HOME AGENTI
- LOGIN AGENTI
- ELENCO CLIENTI

PER UN CORRETTO FUNZIONAMENTO OBBLIGARE IL LOGOUT AGENTE DALLA HOME AGENTE

## FUNZIONAMENTO

Una volta che l agente avrà effettuato il login, se va a buon fine viene creata una sessione ed un cookie
Qaunto l utente impersona l utente, lo USER di riferimento sarà l utente di MALL.
Effettuare il logout dell UTENTE DALL APPOSITO TASTO, in questo modo, la sessione verrà svuotato come da comportato classico di OCTOBER, al termine dell evento, viene letto il cookie creato al momento del login dell Agente, in questo modo viene ricreata la sessione dell agente che non deve quindi effettuare di nuovo il login per poter operare con uno USER diverso.

La configurazione dei cookie attualmente è impostata senza limiti di tempo.

## COMPONENTI

Aggiungere i componenti alle pagine login agente, home agente e lista clienti, specificando gli url richiesti nei parametri dei componenti. Inserire gli slug degli url senza lo /, quindi se la pagina Home Agente ha come slug:
/agente inserire semplicemente agente.    





