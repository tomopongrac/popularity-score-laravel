# Popularity Score

<p>
<a href="https://travis-ci.org/tomopongrac/popularity-score-laravel"><img src="https://travis-ci.org/tomopongrac/popularity-score-laravel.svg" alt="Build Status"></a>

## Opis aplikacije

Ovo je sustav koji računa popularnost određene riječi. Sustav za zadanu riječ pretražuje servis providera i na osnovu broja pozitivnog i negativnog rezultata računa ocjenu popularnosti zadane riječi od 0-10 (rezultat će biti zaokružen na dvije decimale).

## Postavljanje projekta na lokalni server

Server mora zadovoljiti sljedeće zahtjeve:

* PHP >= 7.1
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension

Potrebno je imati instaliran i konfiguriran lokalni server Laravel Homestead. Detaljni postupak instalacije možete pročitati [ovdje](https://laravel.com/docs/5.4/homestead#installation-and-setup).

Za ovaj projekt kreirao sam lokalnu domenu http://api-popularity-score.test

Da biste to napravili u /etc/hosts datoteku dodajte dole navedenu liniju koda

    192.168.10.10  api-popularity-score.test

A u Homestead.yml datoteku pod sites dodajte dole navedeni kod

    sites:
        - map: api-popularity-score.test
          to: /home/vagrant/code/popularity-score-laravel/public

Pokrenite VM i spojite se ssh vezom na virtualni server

    cd ~/Homestead
    vagrant up
    vagrant ssh

Uđite u direktorij

    cd code

Kloniraj repozitorij

    git clone https://github.com/tomopongrac/popularity-score-laravel.git

Prebaci se u direktorij repozitorija
 
     cd popularity-score-laravel

Instaliraj sve komponente aplikacije

    composer install

Kopiraj datoteku env.homestead i eventualne konfigacije promjene

    cp .env.homestead .env

Kreirajte novi ključ za aplikaciju

    php artisan key:generate

Kreirajte bazu na lokalnom serveru

    mysql -u homestead -psecret;
    CREATE DATABASE popularity_score;

Za provjeru da li je baza kreirana upišite naredbu

    SHOW databases;
    exit

Napravi tablice u bazi

    php artisan migrate

Morate kreirati ključeve kako biste mogli kreirati token za pristup aplikaciji

    php artisan passport:install

Kopiraj u .env datoteku Client ID i Client Secret koji ste dobili iz prethodne naredbe

    PASSPORT_CLIENT_ID=<Client ID>
    PASSPORT_CLIENT_SECRET=<Client Secret>

## OAuth

Korišten je osnovni OAuth2 sustav bez korisnika (samo client credentials) preko paketa [laravel/passport](https://github.com/laravel/passport/tree/3.0).

## Korištenje aplikacije

Možete koristiti aplikaciju [Postman](https://www.getpostman.com) ili možete koristiti konzolu.

Api koristi client credentials autorizaciju pa prvo morate kreirati token get pozivom na link http://api-popularity-score.test/get-token

    curl http://api-popularity-score.test/get-token

Na Mac OS-u token možete  pohraniti u clipboard pomoću naredbe

    curl http://api-popularity-score.test/get-token | pbcopy

Kako biste dobili popularnost riječi php u konzolu upišite naredbu gdje umjesto <PASTE TOKEN> upisujete token koji ste dobili iz prethodne naredbe

    curl -H "Authorization: Bearer <PASTE TOKEN>" http://api-popularity-score.test/score\?term\=php

Rezultat će biti (vrijednost score može biti drugačija s obzirom na trenutnu popularnost tražene riječi na provideru)

    {
             term: "php",
             score: 3.39
    }

Ukoliko tražimo riječ koja ne postoji s naredbom

    curl -H "Authorization: Bearer <PASTE TOKEN>" http://api-popularity-score.test/score\?term\=abcdxyz

Dobivamo rezultat

    {
             term: "abcdxyz",
             score: 0
    }
 
 Za korištenje verzije 2 u link dodajemo v2
 
     curl -H "Authorization: Bearer <PASTE TOKEN>" http://api-popularity-score.test/v2/score\?term\=php

gdje je rezultat u JSONAPI specifikaciji

    {
        "data": {
            "term": "php",
            "score": 3.39
        }
    }

## Kreiranje novog providera

Za kreiranje novog providera potrebno je kreirati novu klasu u direktoriju app/Services koja nasljeđuje klasu ServiceProvider u istom direktoriju.

U novoj klasi se moraju kreirati dvije metode:

* getResult()
* getCount()

## Zamjena providera

Ukoliko želite promijeniti providera to ćete napraviti na način da promjenite trentutnog providera (GitHubServiceProvider) u klasi AppServiceProvider koja se nalazi na lokaciji app/Providers/AppServiceProvider.php

    $this->app->bind(ServiceProvider::class, GitHubServiceProvider::class);

## Kreiranje nove verzije API-ja

Za kreiranje nove verzije potrebno je kreirati klasu u direktoriju app/Responses naziva jSonResponseV{broj} koja implementira interaface ResponseInterface.

U novoj klasi se moraju kreirati dvije metode:

* transformValidationResponseData()
* transformNormalDataResponse()
* getResponseHeader()