@extends('layouts.layout')

@section('title', 'Documentation')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <button id="exportPDF" class="btn btn-danger">
            <i class="fa fa-file-pdf"></i> Exportovat do PDF
        </button>
    </div>

    <div id="doc-content">
    <style>
        body { background: #f8f9fa; }
        .markdown-section h1, .markdown-section h2, .markdown-section h3 { margin-top: 2rem; }
        .markdown-section table { background: #fff; }
        .markdown-section th, .markdown-section td { vertical-align: middle; }
        .markdown-section code { background: #f1f3f5; padding: 2px 6px; border-radius: 4px; }
        .markdown-section pre { background: #f1f3f5; padding: 1rem; border-radius: 6px; }
        .markdown-section hr { margin: 2rem 0; }
        .markdown-section ul { margin-bottom: 1rem; }
        .markdown-section .table-responsive { margin-bottom: 2rem; }
        .doc-img {
            max-width: 700px;
            width: 100%;
            height: auto;
            display: block;
            margin-bottom: 1rem;
            border-radius: 6px;
            border: 1px solid #e1e1e1;
        }
    </style>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">WEB-Projekt-3Rocnik Dokumentace</a>
        </div>
    </nav>
    <div class="container markdown-section">
        <h1>Dokumentace k projektu WEB-Projekt-3Rocnik</h1>

        <h2>Rozdělení práce</h2>
        <ul>
            <li><strong>Matěj Straka</strong>: Backend (databáze, modely, migrace, API, kontrolery)</li>
            <li><strong>David Racin</strong>: Frontend (Blade šablony, Bootstrap, JavaScript, Vite)</li>
            <li><strong>Radim Vaculík</strong>: Administrace, testování, dokumentace</li>
        </ul>
        <p>Každý člen týmu měl jasně vymezenou oblast odpovědnosti. Spolupráce probíhala přes Git a pravidelné konzultace.</p>
        <hr>

        <h2>Využité externí nástroje a knihovny</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Název knihovny</th>
                        <th>Verze</th>
                        <th>Autor</th>
                        <th>Licence</th>
                        <th>Odkaz</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Laravel Framework</td><td>10.10</td><td>Taylor Otwell</td><td>MIT</td><td><a href="https://laravel.com/" target="_blank">laravel.com</a></td></tr>
                    <tr><td>Bootstrap</td><td>5.3.5</td><td>Twitter, Inc.</td><td>MIT</td><td><a href="https://getbootstrap.com/" target="_blank">getbootstrap.com</a></td></tr>
                    <tr><td>Vite</td><td>6.3.3</td><td>Evan You</td><td>MIT</td><td><a href="https://vitejs.dev/" target="_blank">vitejs.dev</a></td></tr>
                    <tr><td>Laravel Vite Plugin</td><td>1.2.0</td><td>Laravel</td><td>MIT</td><td><a href="https://github.com/laravel/vite-plugin" target="_blank">github.com/laravel/vite-plugin</a></td></tr>
                    <tr><td>Axios</td><td>1.8.4</td><td>Matt Zabriskie</td><td>MIT</td><td><a href="https://github.com/axios/axios" target="_blank">github.com/axios/axios</a></td></tr>
                    <tr><td>@popperjs/core</td><td>2.11.8</td><td>Federico Zivolo</td><td>MIT</td><td><a href="https://popper.js.org/" target="_blank">popper.js.org</a></td></tr>
                    <tr><td>FakerPHP/Faker</td><td>1.9.1</td><td>FakerPHP</td><td>MIT</td><td><a href="https://fakerphp.github.io/" target="_blank">fakerphp.github.io</a></td></tr>
                    <tr><td>PHPUnit</td><td>10.1</td><td>Sebastian Bergmann</td><td>BSD-3</td><td><a href="https://phpunit.de/" target="_blank">phpunit.de</a></td></tr>
                    <tr><td>Spatie Laravel Ignition</td><td>2.0</td><td>Spatie</td><td>MIT</td><td><a href="https://spatie.be/open-source" target="_blank">spatie.be/open-source</a></td></tr>
                    <tr><td>Laravel Pint</td><td>1.0</td><td>Laravel</td><td>MIT</td><td><a href="https://laravel.com/docs/10.x/pint" target="_blank">laravel.com/docs/10.x/pint</a></td></tr>
                    <tr><td>Mockery</td><td>1.4.4</td><td>Pádraic Brady</td><td>BSD-3</td><td><a href="https://github.com/mockery/mockery" target="_blank">github.com/mockery/mockery</a></td></tr>
                    <tr><td>Nunomaduro/Collision</td><td>7.0</td><td>Nuno Maduro</td><td>MIT</td><td><a href="https://github.com/nunomaduro/collision" target="_blank">github.com/nunomaduro/collision</a></td></tr>
                    <tr><td>Laravel Sanctum</td><td>3.3</td><td>Laravel</td><td>MIT</td><td><a href="https://laravel.com/docs/10.x/sanctum" target="_blank">laravel.com/docs/10.x/sanctum</a></td></tr>
                    <tr><td>Laravel Tinker</td><td>2.8</td><td>Laravel</td><td>MIT</td><td><a href="https://laravel.com/docs/10.x/tinker" target="_blank">laravel.com/docs/10.x/tinker</a></td></tr>
                </tbody>
            </table>
        </div>
        <hr>

        <h2>Citace použití AI</h2>
        <ul>
            <li><strong>GitHub Copilot</strong> byl použit při generování části kódu a návrhu řešení.</li>
            <li><strong>Screenshot chatu</strong> je přiložen v příloze.</li>
        </ul>
        <hr>

        <h2>Citace použitých fór a zdrojů</h2>
        <ul>
            <li><a href="https://stackoverflow.com/" target="_blank">Stack Overflow</a></li>
            <li><a href="https://laravel.com/docs/10.x/" target="_blank">Laravel Documentation</a></li>
            <li><a href="https://getbootstrap.com/docs/5.3/" target="_blank">Bootstrap Documentation</a></li>
            <li><a href="https://www.tiny.cloud/docs/tinymce/latest/" target="_blank">TinyMCE 7</a></li>
        </ul>
        <hr>

        <h2>Popis metod v kontrolerech</h2>
        <h3>AuthController</h3>
        <ul>
            <li><strong>showRegisterForm()</strong> – Zobrazí registrační formulář pro nového uživatele.</li>
            <li><strong>register(Request $request)</strong> – Zpracuje registraci uživatele: validuje vstupní data, vytvoří nového uživatele, zahashuje heslo, automaticky přihlásí uživatele a přesměruje na dashboard.</li>
            <li><strong>showLoginForm()</strong> – Zobrazí přihlašovací formulář.</li>
            <li><strong>login(Request $request)</strong> – Zpracuje přihlášení uživatele: validuje vstupní data, pokusí se uživatele přihlásit, v případě úspěchu regeneruje session a přesměruje na dashboard, v případě neúspěchu vrací chybu.</li>
            <li><strong>logout(Request $request)</strong> – Odhlásí uživatele, invaliduje session a přesměruje na přihlašovací stránku.</li>
            <li><strong>dashboard()</strong> – Zobrazí dashboard přihlášeného uživatele a předá mu jeho data.</li>
        </ul>
        <hr class="my-4">

        <h3>BooksController</h3>
        <ul>
            <li><strong>__construct()</strong> – Při vytvoření instance kontroleru načte všechny knihy z databáze (s eager loadingem žánrů a autorů) a stránkuje je po 50 položkách.</li>
            <li><strong>books()</strong> – Vrací view se seznamem knih, žánrů, autorů, nakladatelství a měst vydání pro zobrazení uživateli.</li>
            <li><strong>addBook(Request $request)</strong> – Přidá novou knihu na základě dat z požadavku. Uloží obrázek obálky, nastaví základní informace o knize, uloží ji do databáze a přiřadí jí vybrané žánry a autory.</li>
            <li><strong>deleteBook($id)</strong> – Smaže knihu podle ID z databáze.</li>
            <li><strong>editBook($id, Request $request)</strong> – Upraví existující knihu podle ID a nových dat z požadavku. Aktualizuje informace o knize, případně obrázek obálky, a znovu přiřadí žánry a autory.</li>
        </ul>
        <hr class="my-4">

        <h3>GenreController</h3>
        <ul>
            <li><strong>__construct()</strong> – Při vytvoření instance kontroleru načte všechny žánry z databáze a uloží je do proměnné pro další použití v metodách.</li>
            <li><strong>genre()</strong> – Vrací view s přehledem všech žánrů pro uživatelské rozhraní.</li>
            <li><strong>genreAdmin()</strong> – Vrací view s přehledem všech žánrů pro administrátorské rozhraní.</li>
            <li><strong>deleteGenre(Request $request)</strong> – Smaže žánr podle ID z požadavku. Pokud žánr existuje, odstraní ho a přesměruje zpět s úspěšnou hláškou, jinak vrátí chybu.</li>
            <li><strong>addGenre(Request $request)</strong> – Přidá nový žánr na základě názvu z požadavku a uloží ho do databáze. Přesměruje zpět s úspěšnou hláškou.</li>
            <li><strong>editGenre(Request $request)</strong> – Upraví existující žánr podle ID a nového názvu z požadavku. Pokud žánr existuje, aktualizuje ho a přesměruje zpět s úspěšnou hláškou, jinak vrátí chybu.</li>
        </ul>
        <hr class="my-4">

        <h3>PublicBookController</h3>
        <ul>
            <li><strong>index(Request $request)</strong> – Zobrazí hlavní stránku s výpisem knih, umožňuje filtrování podle žánru a řazení, stránkuje výsledky po 12 knihách.</li>
            <li><strong>show($id)</strong> – Zobrazí detail vybrané knihy včetně autorů, žánrů, nakladatele, města a země vydání a recenzí.</li>
            <li><strong>byGenre($genreId)</strong> – Zobrazí knihy pouze z vybraného žánru, řazené podle roku vydání, stránkované po 12.</li>
            <li><strong>byAuthor($authorId)</strong> – Zobrazí knihy pouze od vybraného autora, řazené podle roku vydání, stránkované po 12.</li>
            <li><strong>search(Request $request)</strong> – Vyhledává knihy podle názvu, popisu, autora, žánru nebo ISBN, výsledky řadí a stránkuje.</li>
            <li><strong>prepareBookData($books, $featuredBooks = null)</strong> – Pomocná metoda pro zpracování dat knih pro výpis ve view (hlavní i doporučené knihy, stránkování).</li>
        </ul>
        <hr class="my-4">

        <h3>ReviewController</h3>
        <ul>
            <li><strong>store(Request $request, $bookId)</strong> – Uloží novou recenzi ke knize. Kontroluje přihlášení uživatele, validuje vstup, ověřuje, zda už uživatel recenzi nevložil, a ukládá recenzi do databáze.</li>
            <li><strong>update(Request $request, $reviewId)</strong> – Upraví existující recenzi. Kontroluje vlastnictví recenze, validuje vstup a aktualizuje recenzi v databázi.</li>
            <li><strong>destroy($reviewId)</strong> – Smaže recenzi. Kontroluje vlastnictví recenze nebo administrátorská práva a provede smazání recenze z databáze.</li>
        </ul>
        <hr>

        <h2>Popis vlastních knihoven a jejich metod</h2>
        <h3>helpers.php</h3>
        <ul>
            <li><strong>delete_modal(...)</strong> – Generuje HTML pro modální okno pro potvrzení mazání záznamu.</li>
            <li><strong>edit_modal(...)</strong> – Generuje HTML pro modální okno pro editaci záznamu.</li>
        </ul>
        <hr>

        <h2>Popis konfiguračních proměnných</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th>Proměnná</th>
                        <th>Význam</th>
                        <th>Možné hodnoty / příklad</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>APP_NAME</td><td>Název aplikace</td><td>Laravel, WEB-Projekt-3Rocnik</td></tr>
                    <tr><td>APP_ENV</td><td>Prostředí aplikace</td><td>local, production, staging</td></tr>
                    <tr><td>APP_KEY</td><td>Klíč pro šifrování dat v aplikaci</td><td>(generovaný řetězec)</td></tr>
                    <tr><td>APP_DEBUG</td><td>Zapnutí/vypnutí debug režimu</td><td>true/false</td></tr>
                    <tr><td>APP_URL</td><td>Základní URL aplikace</td><td>http://localhost</td></tr>
                    <tr><td>LOG_CHANNEL</td><td>Kanál pro logování</td><td>stack, single, daily, syslog, errorlog</td></tr>
                    <tr><td>LOG_DEPRECATIONS_CHANNEL</td><td>Kanál pro logování deprecated hlášek</td><td>null, stack, single, daily</td></tr>
                    <tr><td>LOG_LEVEL</td><td>Úroveň logování</td><td>debug, info, notice, warning, error</td></tr>
                    <tr><td>DB_CONNECTION</td><td>Typ databáze</td><td>mysql, pgsql, sqlite, sqlsrv</td></tr>
                    <tr><td>DB_HOST</td><td>Hostitel databáze</td><td>127.0.0.1, localhost</td></tr>
                    <tr><td>DB_PORT</td><td>Port databáze</td><td>3306</td></tr>
                    <tr><td>DB_DATABASE</td><td>Název databáze</td><td>laravel, webprojekt3</td></tr>
                    <tr><td>DB_USERNAME</td><td>Uživatelské jméno do databáze</td><td>root, uživatelské jméno</td></tr>
                    <tr><td>DB_PASSWORD</td><td>Heslo do databáze</td><td>(prázdné nebo dle nastavení)</td></tr>
                    <tr><td>BROADCAST_DRIVER</td><td>Způsob broadcastingu událostí</td><td>log, null, pusher, redis</td></tr>
                    <tr><td>CACHE_DRIVER</td><td>Způsob cachování dat</td><td>file, redis, memcached</td></tr>
                    <tr><td>FILESYSTEM_DISK</td><td>Výchozí disk pro ukládání souborů</td><td>local, public, s3</td></tr>
                    <tr><td>QUEUE_CONNECTION</td><td>Způsob zpracování fronty</td><td>sync, database, redis, beanstalkd</td></tr>
                    <tr><td>SESSION_DRIVER</td><td>Způsob ukládání session</td><td>file, cookie, database, redis</td></tr>
                    <tr><td>SESSION_LIFETIME</td><td>Doba platnosti session (v minutách)</td><td>120</td></tr>
                    <tr><td>MEMCACHED_HOST</td><td>Hostitel pro Memcached cache</td><td>127.0.0.1</td></tr>
                    <tr><td>REDIS_HOST</td><td>Hostitel pro Redis cache</td><td>127.0.0.1</td></tr>
                    <tr><td>REDIS_PASSWORD</td><td>Heslo pro Redis</td><td>null, heslo</td></tr>
                    <tr><td>REDIS_PORT</td><td>Port pro Redis</td><td>6379</td></tr>
                    <tr><td>MAIL_MAILER</td><td>Způsob odesílání emailů</td><td>smtp, sendmail, mailgun, ses</td></tr>
                    <tr><td>MAIL_HOST</td><td>SMTP server</td><td>mailpit, smtp.gmail.com</td></tr>
                    <tr><td>MAIL_PORT</td><td>Port SMTP serveru</td><td>1025, 587, 465</td></tr>
                    <tr><td>MAIL_USERNAME</td><td>Uživatelské jméno pro SMTP</td><td>null, email</td></tr>
                    <tr><td>MAIL_PASSWORD</td><td>Heslo pro SMTP</td><td>null, heslo</td></tr>
                    <tr><td>MAIL_ENCRYPTION</td><td>Šifrování SMTP</td><td>null, tls, ssl</td></tr>
                    <tr><td>MAIL_FROM_ADDRESS</td><td>Výchozí email odesílatele</td><td>hello@example.com</td></tr>
                    <tr><td>MAIL_FROM_NAME</td><td>Výchozí jméno odesílatele</td><td>"Laravel", "WEB-Projekt-3Rocnik"</td></tr>
                    <tr><td>AWS_ACCESS_KEY_ID</td><td>Přístupový klíč pro AWS S3</td><td>(řetězec)</td></tr>
                    <tr><td>AWS_SECRET_ACCESS_KEY</td><td>Tajný klíč pro AWS S3</td><td>(řetězec)</td></tr>
                    <tr><td>AWS_DEFAULT_REGION</td><td>Výchozí region pro AWS S3</td><td>us-east-1, eu-central-1</td></tr>
                    <tr><td>AWS_BUCKET</td><td>Název bucketu pro AWS S3</td><td>(řetězec)</td></tr>
                    <tr><td>AWS_USE_PATH_STYLE_ENDPOINT</td><td>Způsob adresování bucketu</td><td>true/false</td></tr>
                    <tr><td>PUSHER_APP_ID</td><td>ID aplikace pro Pusher</td><td>(řetězec)</td></tr>
                    <tr><td>PUSHER_APP_KEY</td><td>Klíč aplikace pro Pusher</td><td>(řetězec)</td></tr>
                    <tr><td>PUSHER_APP_SECRET</td><td>Tajný klíč pro Pusher</td><td>(řetězec)</td></tr>
                    <tr><td>PUSHER_HOST</td><td>Hostitel pro Pusher</td><td>(řetězec)</td></tr>
                    <tr><td>PUSHER_PORT</td><td>Port pro Pusher</td><td>443</td></tr>
                    <tr><td>PUSHER_SCHEME</td><td>Protokol pro Pusher</td><td>https, http</td></tr>
                    <tr><td>PUSHER_APP_CLUSTER</td><td>Cluster pro Pusher</td><td>mt1, eu, ap1</td></tr>
                    <tr><td>VITE_APP_NAME</td><td>Název aplikace pro Vite frontend</td><td>${APP_NAME}</td></tr>
                    <tr><td>VITE_PUSHER_APP_KEY</td><td>Klíč aplikace pro Pusher ve Vite</td><td>${PUSHER_APP_KEY}</td></tr>
                    <tr><td>VITE_PUSHER_HOST</td><td>Hostitel pro Pusher ve Vite</td><td>${PUSHER_HOST}</td></tr>
                    <tr><td>VITE_PUSHER_PORT</td><td>Port pro Pusher ve Vite</td><td>${PUSHER_PORT}</td></tr>
                    <tr><td>VITE_PUSHER_SCHEME</td><td>Protokol pro Pusher ve Vite</td><td>${PUSHER_SCHEME}</td></tr>
                    <tr><td>VITE_PUSHER_APP_CLUSTER</td><td>Cluster pro Pusher ve Vite</td><td>${PUSHER_APP_CLUSTER}</td></tr>
                </tbody>
            </table>
        </div>
        <hr>

        <h2>Závěr</h2>
        <p>
            Tato dokumentace shrnuje rozdělení práce, použité knihovny, popis metod, vlastních funkcí a konfiguračních proměnných. V případě dotazů nebo potřeby rozšíření dokumentace kontaktujte autory projektu.
        </p>
        <h3>Přílohy</h3>
        <img src="images/ai_screen_1.png" alt="ai_screen_1" class="doc-img" />
        <img src="images/ai_screen_2.png" alt="ai_screen_2" class="doc-img" />
        <img src="images/ai_screen_3.png" alt="ai_screen_3" class="doc-img" />
        <img src="images/ai_screen_4.png" alt="ai_screen_4" class="doc-img" />
        <img src="images/ai_screen_5.png" alt="ai_screen_5" class="doc-img" />
        <img src="images/ai_screen_6.png" alt="ai_screen_6" class="doc-img" />
        <img src="images/ai_screen_7.png" alt="ai_screen_7" class="doc-img" />
        <img src="images/ai_screen_8.png" alt="ai_screen_8" class="doc-img" />
    </div>
    <footer class="bg-light text-center py-3 mt-5 border-top">
        <small>&copy; {{ date('Y') }} WEB-Projekt-3Rocnik</small>
    </footer>
</div>
@endsection

<!-- html2canvas & jsPDF CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('exportPDF');
    if (!btn) return;
    btn.addEventListener('click', function () {
        const element = document.getElementById('doc-content');
        html2pdf().set({
            margin:       0.5,
            filename:     'dokumentace.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        }).from(element).save();
    });
});
</script>