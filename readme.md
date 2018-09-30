# Popularity Score

<p>
<a href="https://travis-ci.org/tomopongrac/popularity-score-laravel"><img src="https://travis-ci.org/tomopongrac/popularity-score-laravel.svg" alt="Build Status"></a>

## Opis aplikacije

Ovo je sustav koji računa popularnost određene riječi. Sustav za zadanu riječ pretražuje servis providera i na osnovu broju pozitivnog i negativnog rezultata računa ocjenu popularnosti zadane riječi od 0-10 (rezultat će biti zaokružen na dvije decimale).

## Postavljanje projekta na lokalni server

Server mora zadovoljiti sljedeće zahtjeve:

* PHP >= 7.0
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension

Potrebno je imati instaliran i konfiguriran lokalni server Laravel Homestead. Detaljni postupak instalacije možete pročitati [ovdje](https://laravel.com/docs/5.4/homestead#installation-and-setup). Za ovaj projekt kreirao sam lokalnu domenu http://api-popularity-score.test

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

    mysql -uhomestead -psecret;
    CREATE DATABASE popularity_score:

Za provjeru da li je baza kreirana upišite naredbu

    SHOW databases;
    exit

Napravi tablice u bazi

    php artisan migrate

## Korištenje aplikacije

Kako biste dobili popularnost riječi php u konzolu upišite naredbu

    curl http://popularity-score.test/score?term=php

Rezultat će biti (vrijednost score može biti drugačija s obzirom na trenutnu popularnost tražene riječi na provideru)

    {
             term: "php",
             score: 3.39
    }

Ukoliko tražimo riječ koja ne postoji s naredbom

    curl http://popularity-score.test/score?term=abcdxyz

Dobivamo rezultat

    {
             term: "abcdxyz",
             score: 0
    }

## Kreiranje novog providera

Za kreiranje novog providera potrebno je kreirati novu klasu u direktoriju app/Services koja nasljeđuje klasu ServiceProvider u istom direktoriju.

U novoj klasi se moraju kreirati dvije metode:

* getResult()
* getCount()

## Zamjena providera

Ukoliko želite promijeniti providera to ćete napraviti na način da promjenite trentutnog providera (GitHubServiceProvider) u klasi AppServiceProvider koja se nalazi na lokaciji app/Providers/AppServiceProvider.php

    $this->app->bind(ServiceProvider::class, GitHubServiceProvider::class);