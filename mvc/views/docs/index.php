<div class="container-fluid" style="height:100%">
  <div class="row" style="height:100%">
    <div class="col-sm-12 col-md-3 no-flat " style="border-right:1px solid #dfdfdf;">
      <div class="text-center my-4">
        <h5>Chapter list</h5>
      </div>
      <ul class="doc-nav sticky-top">
        <li><a href="#intro">Wprowadzenie</a></li>
        <li><a href="#howItWorks">Jak to działa?</a></li>
        <li><a href="#install">Instalacja i konfiguracja</a></li>
      </ul>
    </div>
    <div class="col-sm-8 no-flat">
      <div class="display-4">
        Dokumentacja
      </div>
      <section>
        <div class="text-success my-3 ml-2">
          <h3 id="intro">Wprowadzenie</h3>
        </div>
        <div class="ml-1 lead" style="font-size:1.1rem">
          Framework jest gotową interpretacją wzorca MVC, który służy do tworzenia stron WWW.
          Zawiera większość podstawowych funkcjonalności, które powinna posiadać każda ze stron, są to:<br>
          <ul>
            <li>Routing</li>
            <li>Podział na część logiczną i graficzną</li>
            <li>Obsługa bazy danych</li>
            <li>Obsługa sesji, ciasteczek</li>
            <li>Rejestracja i logowanie użytkowników</li>
            <li>Obsługa e-mail</li>
            <li>Kontrola uprawnień dla użytkowników</li>
            <li>Obsługa formularzy, plików</li>
            <li>Zapytania XHR</li>
          </ul>
          Do front-endu strony został domyślnie dołączony Framework Bootstrap.
        </div>
      </section>
      <section>
        <div class="text-success my-3 ml-2">
          <h3 id="howItWorks">Jak to działa?</h3>
        </div>
        <div class="ml-1 lead" style="font-size:1.1rem">
          Ogólny schemat działania aplikacji napisanej zgodnie z tym frameworkiem wygląda jak poniżej:<br>
          <img src="<?=URL;?>public/images/lib/rys1.png" class="rounded mx-auto d-block" style="max-width:100%;">
          <h5>Sanityzacja URL</h5>
          Z zapytania zostają usunięte potencjalne niebezpieczne znaki. Następnie URL jest rozbijany na kolejne składowe, czyli:
          <ul>
            <li>Controller</li>
            <li>Metodę</li>
            <li>Listę argumentów</li>
          </ul>
          <h5 >Kontrola uprawnień</h5>
          Z bazy danych pobierane są dane dostępowe dla danej metody załadowanego kontrolera.
          Jeśli metoda jest publiczna, dalsza autoryzacja jest pomijana - strona dostępna jest dla wszystkich.
          Jeśli metoda nie jest publiczna, sprawdza się najpierw czy użytkownik jest zalogowany, jeśli tak, to czy jego
          rola (Owner, Admin, Default) jest wystarczająca by uzyskać dostęp do metody.
          W przeciwnym wypadku następuje przekierowanie do strony z błędem o braku uprawnień.
          <h5 class="mt-2">Pozostałe procedury</h5>
          Pozostałe procedury są odpowiedzialne za załadowanie odpowiedniego kontrollera, modelu, przetworzenie danych i przesłanie
          ich do widoku, który wyrenderuje dla nas stronę gotową do obsługi przez naszą przeglądarkę.
        </div>
      </section>
      <section>
        <div class="text-success my-3 ml-2">
          <h3 id="install">Instalacja i konfiguracja</h3>
        </div>
        <div class="ml-1 lead" style="font-size:1.1rem">
          W celu instalacji aplikacji na serwerze WWW należy skopiować tam to repozytorium, a następnie skonfigurować plik
          libs/<strong>config.php</strong>, który zawiera:<br>
          <ul>
            <li>tryb działania aplikacji</li>
            <li>URL aplikacji</li>
            <li>ścieżkę do folderu głównego aplikacji</li>
            <li>Dane logowania do bazy danych</li>
            <li>"sól" potrzebną do szyfrowania danych</li>
          </ul>
          Należy następnie przekopiować i wykonać w bazie danych polecenia również z pliku config, utworzą one tabele dla użytkowników oraz dodadzą domyślnego użytkownika.
          W prawidłowo skonfigurowanej aplikacji po jej uruchomieniu powinno być możliwe zalogowanie użytkownika
          <strong>testuser</strong> oraz haśle <strong>zaq1@WSX</strong>.
          <div class="alert alert-danger my-2" role="alert">
            <a href="" class="alert-link">Uwaga!</a> Po ukończeniu aplikacji zaleca się <u><strong>wyłączenie</strong></u> trybu DEVELOP,
            ponieważ wyświetlane są wszystkie błędy, które są pomocne w procesie programowania, jednak mogą zostać wykorzystane do ataku na stronę.
          </div>
        </div>
      </section>
      <section>
        <div class="text-success my-3 ml-2">
          <h3>Proces tworzenia</h3>
        </div>
        <div class="ml-1 lead" style="font-size:1.1rem">
          Framework został zaprojektowany obiektowo. Każda nowa funkcjonalość to nic innego jak kolejna metoda odpowiedniego kontrollera.<br>
          <strong>Przykład</strong>: Chcemy dodać funkcjonalność wyświetlania loginów wszystkich zarejestrowanych użytkowników.<br><br>
          <h5>Kontroller</h5>
          controllers/user.php<br>
          <img src="<?=URL;?>public/images/lib/rys2.png" class="rounded mx-auto d-block py-2" style="max-width:100%;">
          Po przekierowaniu zapytania do tego miejsca kontroller rozpoczyna pracę:<br>
          <ul>
            <li>ustawia tytuł dokumentu</li>
            <li>pobiera dane</li>
            <li>renderuje wszystkie elementy widoku</li>
          </ul>
          <h5>Model</h5>
          controllers/User_Model.php<br>
          <img src="<?=URL;?>public/images/lib/rys3.png" class="rounded mx-auto d-block py-2" style="max-width:100%;">
          Model pobiera dane z bazy i zwraca je w formie tablicy, w przypadku braku rekordów zwróci pustą tablicę
          <h5>Widok</h5>
          views/user/allUserList.php<br>
          <img src="<?=URL;?>public/images/lib/rys4.png" class="rounded mx-auto d-block py-2" style="max-width:100%;">
          Po prostu wypisuje kolejne login użytkowników, w przypadku pustej tablicy podaje stosowną informację.
          <h5>Prawa dostępu</h5>
          Do bazy danych należy dodać rekord, który musi zawierać nazwę kontrollera, metodę oraz typ dostępu (domyślnie jest on publiczny).
          <div class="alert alert-success my-2">
            Takie rekordy dodaje się regularnie do bazy, więc przy włączonym trybie DEVELOP dodawanie ich zostało zautomatyzowane.
          </div>
          <br>
          Tak wygląda proces dodawania nowej funkcjonalności do strony, w następnych akapitach omówimy kolejne standardowe metody, służące m.in obsłudze
          bazy danych czy formularzy
        </div>
      </section>
      <section>
        <div class="text-success my-3 ml-2">
          <h3></h3>
        </div>
        <div class="ml-1 lead" style="font-size:1.1rem"></div>
      </section>
      <section>
        <div class="text-success my-3 ml-2">
          <h3>Formularze</h3>
        </div>
        <div class="ml-1 lead" style="font-size:1.1rem">
          Formularz HTML tworzony w widoku musi zawierać dodatkowe, ukryte pole "formName", by wykorzystać je potem do zwrócenia
          ewentualnych błędów walidacji.<br>
          Action naszego formularza to odpowienio przygotowana metoda w kontrollerze, która waliduje dane i przekazuje je dalej lub, w przypadku
          błędów w walidacji, zwraca odpowiednią informację.<br>
          Weźmy za przykład proces rejestracji użytkownika.<br>
          <h5>Nowa metoda kontrollera</h5>
          controllers/user.php<br>
          <img src="<?=URL;?>public/images/lib/rys5.png" class="rounded mx-auto d-block py-2" style="max-width:100%;">
          Do naszego kontrollera dodajemy nową metodę w której zawarty będzie formularz rejestracji.
          <ul>
            <li>Sprawdzamy czy użytkownik nie jest zalogowany</li>
            <li>Dodajemy tytuł, opcjonalnie akrusz stylów</li>
            <li>jeśli wystąpiły błędy przy rejestracji bindujemy je, oraz usuwamy by po odświeżeniu strony już ich nie było</li>
            <li>renderujemy stronę</li>
          </ul>
          <h5>Widok - formularz HTML</h5>
          Widok dla takiego logowania może wyglądać na przykład tak:
          views/user/signin.php<br>
          <img src="<?=URL;?>public/images/lib/rys6.png" class="rounded mx-auto d-block py-2" style="max-width:100%;">
          <h5>Nowa metoda kontrollera</h5>
          controllers/user.php<br>
          W tym miejscu będziemy walidować nasz formularz.
          <img src="<?=URL;?>public/images/lib/rys7.png" class="rounded mx-auto d-block py-2" style="max-width:100%;">
          <ul>
            <li>Tworzymy nowy obiekt formularza</li>
            <li>Metodą post dodajmy kolejne pola</li>
            <li>Metoda <strong>val</strong> służy do walidacji danych</li>
            <li>Metoda <strong>identity</strong> służy do sprawdzenia, czy podane pola są takie same</li>
            <li>Jeśli nie ma błędów wstawiamy nowego użytkownika do bazy</li>
            <li>W przeciwnym wypadku wracamy do formularza</li>
          </ul>
          Jeśli wystąpiły błędy przy walidacji w metoda <strong>Submit</strong> automatycznie ustawia w sesji zmienną
          zawierającą opisy błędów o takiej samej nazwie jak pole formName z naszego formularza.
          <h5>Wstawianie do bazy</h5>
          models/User_Model.php<br>
          Na koniec po prostu wstawiamy użytkownika do bazy i generujemy hash do potwierdzenia jego adresu email. Następnie wysyłamy go.<br>
          Domyślnie zostaje też ustawiona zmienna informująca o potwierdzeniu e-mail'a, która pojawi się na stronie głównej.
          <img src="<?=URL;?>public/images/lib/rys8.png" class="rounded mx-auto d-block py-2" style="max-width:100%;">
        </div>
      </section>
      <section>
        <div class="text-success my-3 ml-2">
          <h3>Pliki</h3>
        </div>
        <div class="ml-1 lead" style="font-size:1.1rem"></div>
      </section>
      <section>
        <div class="text-success my-3 ml-2">
          <h3></h3>
        </div>
        <div class="ml-1 lead" style="font-size:1.1rem"></div>
      </section>
      <section>
        <div class="text-success my-3 ml-2">
          <h3></h3>
        </div>
        <div class="ml-1 lead" style="font-size:1.1rem"></div>
      </section>
    </div>
  </div>
</div>
