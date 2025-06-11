



#  Dokumentace k projektu WEB-Projekt-3Rocnik

  


  

##  Rozdělení práce

  

-  **Matěj Straka**: Backend (databáze, modely, migrace, API, kontrolery)

-  **David Racin**: Frontend (Blade šablony, Bootstrap, JavaScript, Vite)

-  **Radim Vaculík**: Administrace, testování, dokumentace

  

Každý člen týmu měl jasně vymezenou oblast odpovědnosti. Spolupráce probíhala přes Git a pravidelné konzultace.

  

---
  

##  Využité externí nástroje a knihovny

  

| Název knihovny | Verze | Autor | Licence | Odkaz |
|--|--|--|--|--|
| Laravel Framework | 10.10 | Taylor Otwell | MIT | https://laravel.com/ |
| Bootstrap | 5.3.5 | Twitter, Inc. | MIT | https://getbootstrap.com/ |
| Vite | 6.3.3 | Evan You | MIT | https://vitejs.dev/ |
| Laravel Vite Plugin | 1.2.0 | Laravel | MIT | https://github.com/laravel/vite-plugin |
| Axios | 1.8.4 | Matt Zabriskie | MIT | https://github.com/axios/axios |
| @popperjs/core | 2.11.8 | Federico Zivolo | MIT | https://popper.js.org/ |
| FakerPHP/Faker | 1.9.1 | FakerPHP | MIT | https://fakerphp.github.io/ |
| PHPUnit | 10.1 | Sebastian Bergmann | BSD-3 | https://phpunit.de/ |
| Spatie Laravel Ignition| 2.0 | Spatie | MIT | https://spatie.be/open-source |
| Laravel Pint | 1.0 | Laravel | MIT | https://laravel.com/docs/10.x/pint |
| Mockery | 1.4.4 | Pádraic Brady | BSD-3 | https://github.com/mockery/mockery |
| Nunomaduro/Collision | 7.0 | Nuno Maduro | MIT | https://github.com/nunomaduro/collision |
| Laravel Sanctum | 3.3 | Laravel | MIT | https://laravel.com/docs/10.x/sanctum |
| Laravel Tinker | 2.8 | Laravel | MIT | https://laravel.com/docs/10.x/tinker |

  

---

  

##  Citace použití AI

  

-  **GitHub Copilot** byl použit při generování části kódu a návrhu řešení.

-  **Screenshot chatu** je přiložen v příloze.

  

---

  

##  Citace použitých fór a zdrojů

  

-  [Stack Overflow](https://stackoverflow.com/)

-  [Laravel Documentation](https://laravel.com/docs/10.x/)

-  [Bootstrap Documentation](https://getbootstrap.com/docs/5.3/)

-  [TinyMCE 7](https://www.tiny.cloud/docs/tinymce/latest/)

  

---

  

##  Popis metod v kontrolerech

  
###  AuthController

-  **showRegisterForm()**

Zobrazí registrační formulář pro nového uživatele.

-  **register(Request $request)**

Zpracuje registraci uživatele: validuje vstupní data, vytvoří nového uživatele, zahashuje heslo, automaticky přihlásí uživatele a přesměruje na dashboard.

-  **showLoginForm()**

Zobrazí přihlašovací formulář.

-  **login(Request $request)**

Zpracuje přihlášení uživatele: validuje vstupní data, pokusí se uživatele přihlásit, v případě úspěchu regeneruje session a přesměruje na dashboard, v případě neúspěchu vrací chybu.

-  **logout(Request $request)**

Odhlásí uživatele, invaliduje session a přesměruje na přihlašovací stránku.

-  **dashboard()**

Zobrazí dashboard přihlášeného uživatele a předá mu jeho data.

---

###  BooksController

-  **__construct()**

Při vytvoření instance kontroleru načte všechny knihy z databáze (s eager loadingem žánrů a autorů) a stránkuje je po 50 položkách.

-  **books()**

Vrací view se seznamem knih, žánrů, autorů, nakladatelství a měst vydání pro zobrazení uživateli.

-  **addBook(Request $request)**

Přidá novou knihu na základě dat z požadavku. Uloží obrázek obálky, nastaví základní informace o knize, uloží ji do databáze a přiřadí jí vybrané žánry a autory.

-  **deleteBook($id)**

Smaže knihu podle ID z databáze.

-  **editBook($id, Request $request)**

Upraví existující knihu podle ID a nových dat z požadavku. Aktualizuje informace o knize, případně obrázek obálky, a znovu přiřadí žánry a autory.

---

###  GenreController

-  **__construct()**

Při vytvoření instance kontroleru načte všechny žánry z databáze a uloží je do proměnné pro další použití v metodách.

-  **genre()**

Vrací view s přehledem všech žánrů pro uživatelské rozhraní.

-  **genreAdmin()**

Vrací view s přehledem všech žánrů pro administrátorské rozhraní.

-  **deleteGenre(Request $request)**

Smaže žánr podle ID z požadavku. Pokud žánr existuje, odstraní ho a přesměruje zpět s úspěšnou hláškou, jinak vrátí chybu.

-  **addGenre(Request $request)**

Přidá nový žánr na základě názvu z požadavku a uloží ho do databáze. Přesměruje zpět s úspěšnou hláškou.

-  **editGenre(Request $request)**

Upraví existující žánr podle ID a nového názvu z požadavku. Pokud žánr existuje, aktualizuje ho a přesměruje zpět s úspěšnou hláškou, jinak vrátí chybu.

---
### PublicBookController

-  **index(Request $request)**

Zobrazí hlavní stránku s výpisem knih, umožňuje filtrování podle žánru a řazení, stránkuje výsledky po 12 knihách.

-  **show($id)**

Zobrazí detail vybrané knihy včetně autorů, žánrů, nakladatele, města a země vydání a recenzí.

-  **byGenre($genreId)**

Zobrazí knihy pouze z vybraného žánru, řazené podle roku vydání, stránkované po 12.

-  **byAuthor($authorId)**

Zobrazí knihy pouze od vybraného autora, řazené podle roku vydání, stránkované po 12.

-  **search(Request $request)**

Vyhledává knihy podle názvu, popisu, autora, žánru nebo ISBN, výsledky řadí a stránkuje.

-  **prepareBookData($books, $featuredBooks = null)**

Pomocná metoda pro zpracování dat knih pro výpis ve view (hlavní i doporučené knihy, stránkování).

---

### ReviewController

- **store(Request $request, $bookId)**  
  Uloží novou recenzi ke knize. Kontroluje přihlášení uživatele, validuje vstup, ověřuje, zda už uživatel recenzi nevložil, a ukládá recenzi do databáze.

- **update(Request $request, $reviewId)**  
  Upraví existující recenzi. Kontroluje vlastnictví recenze, validuje vstup a aktualizuje recenzi v databázi.

- **destroy($reviewId)**  
  Smaže recenzi. Kontroluje vlastnictví recenze nebo administrátorská práva a provede smazání recenze z databáze.

---

##  Popis vlastních knihoven a jejich metod

  

###  helpers.php

  

-  **delete_modal(...)**

Generuje HTML pro modální okno pro potvrzení mazání záznamu.

-  **edit_modal(...)**

Generuje HTML pro modální okno pro editaci záznamu.

  

---

  

##  Popis konfiguračních proměnných
| Proměnná | Význam | Možné hodnoty / příklad |
|-------------------------|------------------------------------------------------------------------|----------------------------------------|
| APP_NAME | Název aplikace | Laravel, WEB-Projekt-3Rocnik |
| APP_ENV | Prostředí aplikace | local, production, staging |
| APP_KEY | Klíč pro šifrování dat v aplikaci | (generovaný řetězec) |
| APP_DEBUG | Zapnutí/vypnutí debug režimu | true/false |
| APP_URL | Základní URL aplikace | http://localhost |
| LOG_CHANNEL | Kanál pro logování | stack, single, daily, syslog, errorlog |
| LOG_DEPRECATIONS_CHANNEL| Kanál pro logování deprecated hlášek | null, stack, single, daily |
| LOG_LEVEL | Úroveň logování | debug, info, notice, warning, error |
| DB_CONNECTION | Typ databáze | mysql, pgsql, sqlite, sqlsrv |
| DB_HOST | Hostitel databáze | 127.0.0.1, localhost |
| DB_PORT | Port databáze | 3306 |
| DB_DATABASE | Název databáze | laravel, webprojekt3 |
| DB_USERNAME | Uživatelské jméno do databáze | root, uživatelské jméno |
| DB_PASSWORD | Heslo do databáze | (prázdné nebo dle nastavení) |
| BROADCAST_DRIVER | Způsob broadcastingu událostí | log, null, pusher, redis |
| CACHE_DRIVER | Způsob cachování dat | file, redis, memcached |
| FILESYSTEM_DISK | Výchozí disk pro ukládání souborů | local, public, s3 |
| QUEUE_CONNECTION | Způsob zpracování fronty | sync, database, redis, beanstalkd |
| SESSION_DRIVER | Způsob ukládání session | file, cookie, database, redis |
| SESSION_LIFETIME | Doba platnosti session (v minutách) | 120 |
| MEMCACHED_HOST | Hostitel pro Memcached cache | 127.0.0.1 |
| REDIS_HOST | Hostitel pro Redis cache | 127.0.0.1 |
| REDIS_PASSWORD | Heslo pro Redis | null, heslo |
| REDIS_PORT | Port pro Redis | 6379 |
| MAIL_MAILER | Způsob odesílání emailů | smtp, sendmail, mailgun, ses |
| MAIL_HOST | SMTP server | mailpit, smtp.gmail.com |
| MAIL_PORT | Port SMTP serveru | 1025, 587, 465 |
| MAIL_USERNAME | Uživatelské jméno pro SMTP | null, email |
| MAIL_PASSWORD | Heslo pro SMTP | null, heslo |
| MAIL_ENCRYPTION | Šifrování SMTP | null, tls, ssl |
| MAIL_FROM_ADDRESS | Výchozí email odesílatele | hello@example.com |
| MAIL_FROM_NAME | Výchozí jméno odesílatele | "Laravel", "WEB-Projekt-3Rocnik" |
| AWS_ACCESS_KEY_ID | Přístupový klíč pro AWS S3 | (řetězec) |
| AWS_SECRET_ACCESS_KEY | Tajný klíč pro AWS S3 | (řetězec) |
| AWS_DEFAULT_REGION | Výchozí region pro AWS S3 | us-east-1, eu-central-1 |
| AWS_BUCKET | Název bucketu pro AWS S3 | (řetězec) |
| AWS_USE_PATH_STYLE_ENDPOINT | Způsob adresování bucketu | true/false |
| PUSHER_APP_ID | ID aplikace pro Pusher | (řetězec) |
| PUSHER_APP_KEY | Klíč aplikace pro Pusher | (řetězec) |
| PUSHER_APP_SECRET | Tajný klíč pro Pusher | (řetězec) |
| PUSHER_HOST | Hostitel pro Pusher | (řetězec) |
| PUSHER_PORT | Port pro Pusher | 443 |
| PUSHER_SCHEME | Protokol pro Pusher | https, http |
| PUSHER_APP_CLUSTER | Cluster pro Pusher | mt1, eu, ap1 |
| VITE_APP_NAME | Název aplikace pro Vite frontend | ${APP_NAME} |
| VITE_PUSHER_APP_KEY | Klíč aplikace pro Pusher ve Vite | ${PUSHER_APP_KEY} |
| VITE_PUSHER_HOST | Hostitel pro Pusher ve Vite | ${PUSHER_HOST} |
| VITE_PUSHER_PORT | Port pro Pusher ve Vite | ${PUSHER_PORT} |
| VITE_PUSHER_SCHEME | Protokol pro Pusher ve Vite | ${PUSHER_SCHEME} |
| VITE_PUSHER_APP_CLUSTER | Cluster pro Pusher ve Vite | ${PUSHER_APP_CLUSTER} |


  

##  Závěr

  

Tato dokumentace shrnuje rozdělení práce, použité knihovny, popis metod, vlastních funkcí a konfiguračních proměnných. V případě dotazů nebo potřeby rozšíření dokumentace kontaktujte autory projektu.

## Přílohy
![ai-screen](https://github.com/user-attachments/assets/69242660-7f78-4339-bef3-f46833d0d816)
![ai_screen_2](https://github.com/user-attachments/assets/0bd600cb-615d-47f9-ad4c-08d1edbd623f)
![ai_screen_3](https://github.com/user-attachments/assets/53e36bd2-94c9-49d3-b7c3-43b6899c0129)
![ai_screen_4](https://github.com/user-attachments/assets/7297081f-6ff6-46fd-b837-c2c07cd67632)

![ai_screen_1_1](https://github.com/user-attachments/assets/2d896159-7229-4a63-b189-2e0054764ce8)
![ai_screen_1_4](https://github.com/user-attachments/assets/da0f9aa4-e637-45a8-9b93-493f025ded04)
![ai_screen_1_3](https://github.com/user-attachments/assets/bcfa81cd-6890-4193-9fdd-423ac94457cb)
![ai_screen_1_2](https://github.com/user-attachments/assets/6ce5eeb5-3e8c-472a-a8b2-f6ee4b3c43f6)
