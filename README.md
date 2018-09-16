# SQL-kyselyt
PHP / SQL -harjoitustyö kevät 2017

SQL-kyselyohjelman tarkoitus on testata opiskelijoiden SQL-osaamista. 
Ohjelmassa suoritetetaan tehtävälistoja, jotka sisältävät erilaisia tehtäviä. 

Ohjelma on tehty PHP-ohjelmointikielellä, käyttäen olio-ohjelmointia. 
Ohjelman rakenne MVC-arkkitehtuurin mukainen eli malli-, näkymä- ja kontrolleritiedostot ovat erikseen. 

Tiedostot on sijoitettu eri kansioihin seuraavasti:
Mallit: libs/models
Näkymät: views
Kontrollerit: juurihakemisto
Kuvat: img
Bootstrap: css, fonts, js

Tiedostot käyttävät yleisluontoisia funktioita tiedostosta libs/common.php. 
Tietokantayhteys on luotu PDO-oliona ja yhteys muodostetaan tiedoston libs/tietokantayhteys.php avulla.
Kaikille tarvittaville tietokantatauluille on luotu oma olioluokka (mallit). 
Raporteille on oma, yhteinen luokka. Raportit on toteutettu tietokannassa näkyminä (view).
Käyttöliittymä on web-lomakepohjainen. Käyttöliittymän ulkoasun toteutuksessa on hyödynnetty Bootstrap-kirjastoa. 
Näkymien pohjana käytetään tiedostoa views/template.php.

