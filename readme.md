# PLUGIN PER GESTIONE PRODOTTI INDIVIDUALE PER ADMIN 

## CREAZIONE AGENZIE
CREARE UN RUOLO IN ADMIN CHIAMATO AGENZIA
ASSEGNARE AGLI UTENTI AGENZIA UN CODICE INTERNO UNIVOCO
IL CODICE VERRA' ASSEGNATO AL PRODOTTO AL MOMENTO DELLA CREAZIONE
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

## FUNZIONAMNTO

Una volta che l'agente avrà effettuato il login, se va a buon fine viene creata una sessione ed un cookie
Qaunto l'utente impersona l'utente, lo USER di riferimento sarà l'utente di MALL.
Effettuare il logout dell' UTENTE DALL' APPOSITO TASTO, in questo modo, la sessione verrà svuotato come da comportato classico di OCTOBER, al termine dell' evento, viene letto il cookie creato al momento del login dell' Agente, in questo modo viene ricreata la sessione dell'agente che non deve quindi effettuare di nuovo il login per poter operare con uno USER diverso.

La configurazione dei cookie attualmente è impostata senza limiti di tempo.

## COMPONENTI

Aggiungere i componenti alle pagine login agente, home agente e lista clienti, specificando gli url richiesti nei parametri dei componenti. Inserire gli slug degli url senza lo "/", quindi se la pagina Home Agente ha come slug:
"/agente" inserire semplicemente "agente"




