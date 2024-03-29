-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 24 Lut 2017, 12:42
-- Wersja serwera: 5.7.14
-- Wersja PHP: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `empresa`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `thumb` varchar(256) NOT NULL,
  `content` text NOT NULL,
  `content_short` varchar(512) NOT NULL,
  `keywords` varchar(512) NOT NULL,
  `description` varchar(512) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cms`
--

CREATE TABLE `cms` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cms_logs`
--

CREATE TABLE `cms_logs` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `logged` int(1) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cms_session`
--

CREATE TABLE `cms_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11),
  `code` varchar(32) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `index_page`
--

CREATE TABLE `index_page` (
  `name` varchar(64) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `index_page`
--

INSERT INTO `index_page` (`name`, `value`) VALUES
('text_1', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `info`
--

CREATE TABLE `info` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `page` varchar(32),
  `content` text NOT NULL,
  `keywords` varchar(512) NOT NULL,
  `description` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `info`
--

INSERT INTO `info` (`id`, `name`, `slug`, `page`, `content`, `keywords`, `description`) VALUES
(1, 'Polityka prywatności', 'polityka-prywatnosci', 'privacy_policy', '<p>Oto nasze stanowisko w sprawie gromadzenia, przetwarzania i wykorzystywania, wprowadzonych przez użytkownik&oacute;w serwisu, adres&oacute;w e-mail i numer&oacute;w telefon&oacute;w.</p>\r\n\r\n<p>Jaka jest polityka serwisu dotycząca adres&oacute;w e-mail?<br />\r\nPodany podczas dodawania ogłoszenia adres e-mail służy do weryfikacji osoby zamieszczającej ogłoszenie, oraz jest adresem kontaktowym, na kt&oacute;ry zostają odesłane oferty od os&oacute;b zainteresowanych ogłoszeniem. Serwis przechowuje adresy e-mail, numery telefon&oacute;w itp. związane tylko z aktualnie dostępnymi ogłoszeniami, oraz adresy e-mail os&oacute;b, kt&oacute;re wielokrotnie zamieszczały ogłoszenia niezgodne z regulaminem serwisu, aby uniemożliwić im dodawanie kolejnych ogłoszeń.&nbsp;</p>\r\n\r\n<p>Czy adresy e-mail i numery telefon&oacute;w są udostępniane innym osobom, lub firmom?<br />\r\nNie udostępniamy takich danych&nbsp;osobom trzecim lub firmom. Jednak należy mieć na uwadze, że podane w treści ogłoszenia dane (numery telefon&oacute;w, adresy e-mail) mogą zostać &quot;zapamiętane&quot; przez inne osoby lub firmy w okresie, w kt&oacute;rym ogłoszenie jest widoczne w serwisie, w celu p&oacute;źniejszego ich wykorzystania niezgodnie z przeznaczeniem.</p>\r\n\r\n<p>Ciasteczka (pliki cookie) i sygnalizatory WWW (web beacon)</p>\r\n\r\n<p>Zastrzegamy sobie możliwość do wykorzystania plik&oacute;w cookie (ciasteczek) oraz tzw session storage. Pliki te są zapisywane na Twoim komputerze. Służą one do:</p>\r\n\r\n<p>a) dostosowania zawartości serwisu&nbsp;do preferencji użytkownika oraz optymalizacji korzystania ze stron internetowych;,</p>\r\n\r\n<p>b) utrzymania sesji użytkownika serwisu internetowego (po zalogowaniu), dzięki kt&oacute;rej użytkownik nie musi na każdej podstronie serwisu ponownie wpisywać loginu i hasła,</p>\r\n\r\n<p>c) dostarczania użytkownikom treści reklamowych bardziej dostosowanych do ich zainteresowań.</p>\r\n\r\n<p>Serwis wyświetla reklamy pochodzące od zewnętrznych dostawc&oacute;w. Dostawcy reklam (np. Google) mogą używać ciasteczek i sygnalizator&oacute;w WWW, mogą uzyskać informację o Twoim adresie IP i typie używanej przeglądarki, sprawdzić czy zainstalowany jest dodatek Flash itp. Dzięki ciasteczkom, sygnalizatorom i znajomości adresu IP dostawcy reklam mogą decydować o treści reklam.&nbsp;</p>\r\n\r\n<p>Przeglądarki internetowe, oraz niekt&oacute;re Firewalle, umożliwiają wyłączenie obsługi ciasteczek i sygnalizator&oacute;w, lub jej ograniczenie dla wszystkich lub tylko dla wybranych stron WWW. Jednak wyłączenie obsługi ciasteczek i sygnalizator&oacute;w może uniemożliwić poprawne działanie naszego serwisu.&nbsp;</p>\r\n\r\n<p>Wsp&oacute;łczesne przeglądarki umożliwiają przeglądanie stron www tzw. &quot;trybie prywatnym (incognito)&quot; co zazwyczaj oznacza, że wszystkie odwiedzone strony www nie zostaną zapamiętane w lokalnej historii przeglądarki, a pobrane ciasteczka zostaną skasowane po zakończeniu pracy z przeglądarką. Szczeg&oacute;łowy opis &quot;trybu prywatnego&quot; jest dostępny w pomocy przeglądarki.</p>\r\n\r\n<p>Wyłączenie &quot;ciasteczek&quot; w najbardziej popularnych przeglądarkach:</p>\r\n\r\n<p><strong>Google Chrome</strong></p>\r\n\r\n<p>Należy kliknąć na menu (w prawym g&oacute;rnym rogu), zakładka Ustawienia &gt; Pokaż ustawienia zaawansowane. W sekcji &bdquo;Prywatność&rdquo; trzeba kliknąć przycisk Ustawienia treści. W sekcji &bdquo;Pliki cookie&rdquo; można zmienić następujące ustawienia plik&oacute;w Cookie:</p>\r\n\r\n<ul>\r\n	<li>Usuwanie plik&oacute;w Cookie,</li>\r\n	<li>Domyślne blokowanie plik&oacute;w Cookie,</li>\r\n	<li>Domyślne zezwalanie na pliki Cookie,</li>\r\n	<li>Domyślne zachowywanie plik&oacute;w Cookie i danych stron do zamknięcia przeglądarki</li>\r\n	<li>Określanie wyjątk&oacute;w dla plik&oacute;w Cookie z konkretnych witryn lub domen</li>\r\n</ul>\r\n\r\n<p><strong>Mozilla Firefox</strong></p>\r\n\r\n<p>Z menu przeglądarki: Narzędzia &gt; Opcje &gt; Prywatność. Uaktywnić pole Program Firefox: &bdquo;będzie używał ustawień użytkownika&rdquo;. O ciasteczkach (cookies) decyduje zaznaczenie &ndash; bądź nie &ndash; pozycji Akceptuj ciasteczka.</p>\r\n\r\n<p><strong>Opera</strong></p>\r\n\r\n<p>Z menu przeglądarki: Narzędzie &gt; Preferencje &gt; Zaawansowane. O ciasteczkach decyduje zaznaczenie &ndash; bądź nie &ndash; pozycji Ciasteczka.</p>\r\n\r\n<p><strong>Safari</strong></p>\r\n\r\n<p>W menu rozwijanym Safari trzeba wybrać Preferencje i kliknąć ikonę Bezpieczeństwo.<br />\r\nW tym miejscu wybiera się poziom bezpieczeństwa w obszarze ,,Akceptuj pliki cookie&rdquo;.</p>\r\n', '', ''),
(2, 'Regulamin', 'regulamin', 'rules', '<ol>\r\n	<li>Regulamin stanowi prawną podstawę określającą zasady korzystania z naszej witryny. Odwiedzając naszą witrynę, akceptujesz aktualne postanowienia tego Regulaminu oraz zobowiązujesz się do przestrzegania wszystkich zawartych w nim zasad.<br />\r\n	Dopełnieniem Regulaminu jest nasza Polityka prywatności.</li>\r\n	<li>Charakter i cel witryny<br />\r\n	Witryna jest&nbsp;serwisem&nbsp;informacyjno-promocyjnymi mającym&nbsp;na celu gromadzenie listy firm w Polsce i za granicą.</li>\r\n	<li>Rejestracja użytkownik&oacute;w i ochrona danych<br />\r\n	Osoba, kt&oacute;ra pragnie dodać do bazy swoją ofertę musi dokonać bezpłatnej rejestracji. Po zakończeniu rejestracji dana osoba będzie miała możliwość zalogowania się do Panelu umożliwiającego dodanie oferty.<br />\r\n	Dane przekazywane podczas rejestracji oraz inne dane osobowe, kt&oacute;re mogą być zbierane od użytkownik&oacute;w podczas korzystania z witryn, są gromadzone i wykorzystywane zgodnie z zasadami zawartymi w naszej Polityce Prywatności oraz Ustawie o ochronie danych osobowych.</li>\r\n	<li>Prawa i możliwości użytkownik&oacute;w witryn<br />\r\n	Rejestrując się w witrynie:\r\n	<ul>\r\n		<li>zgadzasz się podczas rejestracji dostarczyć prawdziwych informacji</li>\r\n		<li>akceptujesz w pełni ten Regulamin korzystania z witryn</li>\r\n		<li>zobowiązujesz się do utrzymania w tajemnicy Twego hasła i zgadzasz się ponosić odpowiedzialność za wszystkie skutki spowodowane zar&oacute;wno swoim, jak i nieuprawnionym dostępem do witryn przez osoby, kt&oacute;rym udostępnisz sw&oacute;j login i hasło</li>\r\n		<li>zobowiązujesz się zawiadomić nas natychmiast o jakimkolwiek nieupoważnionym dostępie do witryn za pomocą Twojego hasła albo o zarejestrowaniu się w witrynach z Twojego konta pocztowego</li>\r\n	</ul>\r\n	</li>\r\n	<li>Respektowanie praw własności, zastrzeżenie praw autorskich<br />\r\n	Udostępniając witrynę, zwracamy szczeg&oacute;lną uwagę na konieczność respektowania praw własności intelektualnej. Informujemy, że witryna&nbsp;zawieraja&nbsp;dokumenty chronione prawem autorskim, znaki towarowe i inne oryginalne materiały, w szczeg&oacute;lności teksty, zdjęcia i grafikę, a przyjęty w witrynie&nbsp;wyb&oacute;r i układ prezentowanych w nim&nbsp;treści stanowi samoistny przedmiot ochrony prawnoautorskiej. Wszystkie loga, znaki towarowe oraz grafika zamieszczone na tych stronach są własnością ich tw&oacute;rc&oacute;w.<br />\r\n	Serwis zastrzega możliwość blokowania kont w dowolnym czasie bez podania przyczyny.</li>\r\n	<li>Aktywność użytkownik&oacute;w w witrynach, przesyłanie materiał&oacute;w<br />\r\n	Masz prawo przesyłania do witryn swoich informacji, materiał&oacute;w, dokument&oacute;w. Z tym prawem wiąże się z jednej strony możliwość oddziaływania na innych użytkownik&oacute;w witryny, a z drugiej dostęp do pewnych obszar&oacute;w naszego systemu komputerowego, wrażliwych na zachowania, kt&oacute;re mogą zakł&oacute;cić sprawność jego działania.<br />\r\n	W związku z tym w pełni zgadzasz się, że Twoja aktywność w ramach witryn i konta:\r\n	<ul>\r\n		<li>nie może być sprzeczna z normami kultury, z powszechnie obowiązującymi przepisami prawa, nie może być dla innych w żaden spos&oacute;b niebezpieczna i w związku z tym nie będziesz przesyłać do witryn lub wykorzystując mechanizmy witryn żadnych informacji i materiał&oacute;w, naruszających og&oacute;lnie przyjęte normy kultury, wulgarnych, nieprzyzwoitych, obscenicznych, nielegalnych, informacji materiał&oacute;w i wypowiedzi, kt&oacute;re wzywają do nietolerancji, nienawiści, przemocy, okrucieństwa czy naruszania prawa w jakikolwiek spos&oacute;b</li>\r\n		<li>nie możesz naruszać praw innych użytkownik&oacute;w witryn, szczeg&oacute;lnie prawa do poszanowania godności, prywatności, do ochrony danych osobowych, do swobody wypowiedzi i w związku z tym powstrzymasz się od wypowiedzi obraźliwych lub agresywnych oraz nie będziesz zbierać lub usuwać jakichkolwiek danych o innych użytkownikach witryn</li>\r\n		<li>nie będziesz wykorzystywać mechanizm&oacute;w witryn do rozsyłania materiał&oacute;w niechcianych, uznawanych za spam</li>\r\n		<li>zgadzasz się, aby wydawca witryn miał prawo do modyfikacji bądź usunięcia każdego Twojego wpisu bez podania przyczyny</li>\r\n	</ul>\r\n	</li>\r\n	<li>Zawiadomienie o naruszeniu praw autorskich<br />\r\n	Jeżeli uważasz, że Twoje lub czyjekolwiek prawa autorskie, prawa własności intelektualnej zostały w jakikolwiek spos&oacute;b bądź w jakiejkolwiek formie naruszone w witrynach, prosimy o przesłanie informacji w tej sprawie do wydawcy witryny.</li>\r\n	<li>Wyłączenia gwarancji<br />\r\n	W pełni akceptujesz, że wydawca udostępnia witrynę&nbsp;taką jaka jest.<br />\r\n	Zdajesz sobie sprawę, że opublikowane w witrynie materiały mogą zawierać informacje nieprawdziwe lub w inny spos&oacute;b nie odpowiadające Twoim potrzebom i oczekiwaniom. Zgadzasz się, że korzystasz z witryny&nbsp;tylko i wyłącznie na własną odpowiedzialność i własne ryzyko.<br />\r\n	Wszystkie informacje, materiały lub usługi dostarczane za pośrednictwem witryny oferowane są bez jakiejkolwiek gwarancji, w szczeg&oacute;lności:<br />\r\n	wydawca witryny nie zapewnia gwarancji dotyczących prawidłowości lub kompletności jakichkolwiek materiał&oacute;w, informacji lub ustaleń umieszczonych w witrynie.<br />\r\n	Wydawca witryny nie gwarantuje, iż każda zamieszczona oferta sprosta oczekiwaniom każdego Użytkownika co do merytorycznej zawartości, dokładności czy przydatności uzyskanych informacji.</li>\r\n	<li>Odsyłacze do innych witryn, ogłoszenia i reklamy<br />\r\n	W witrynie są publikowane odsyłacze do innych witryn. Mogą r&oacute;wnież być publikowane ogłoszenia firm - naszych Klient&oacute;w. Wydawca witryny nie ponosi żadnej odpowiedzialności za treść, ścisłość, zawartość lub dostępność informacji, do kt&oacute;rych prowadzą odsyłacze.</li>\r\n	<li>Rozstrzyganie spor&oacute;w<br />\r\n	W związku z możliwością wystąpienia spor&oacute;w związanych z korzystaniem z witryn:\r\n	<ul>\r\n		<li>zgadzasz się, że niniejszy Regulamin korzystania z witryn podlega prawu polskiemu - wszelkie spory mogące wyniknąć z wykonania zobowiązań zawartych w niniejszych warunkach będą rozstrzygane przez właściwy terytorialnie i rzeczowo sąd powszechny w Polsce.</li>\r\n		<li>zgadzasz się, że w przypadku, gdyby kt&oacute;rekolwiek z postanowień tego Regulaminu zostało uznane za niezgodne z prawem przez właściwy sąd, to decyzja sądu nie powoduje uchylenia innych postanowień tego Regulaminu i w związku z tym wszystkie inne postanowienia zachowują swoją moc.</li>\r\n		<li>zgadzasz się, że w przypadku niezgodności pomiędzy warunkami opisanymi w konkretnym dokumencie w witrynie&nbsp;i sygnowanym przez Wydawcę, a warunkami przedstawionymi w niniejszym Regulaminie, zawsze przyjmuje się za ważniejsze warunki określone w dokumencie, z wyjątkiem wyrażonych gdziekolwiek gwarancji, o kt&oacute;rych mowa była w rozdziale Wyłączenia gwarancji.</li>\r\n	</ul>\r\n	</li>\r\n	<li>Zmiany regulaminu korzystania z witryny<br />\r\n	Zgadzasz się, że Wydawca serwisu zastrzega sobie wyłączne prawo do wprowadzania zmian w witrynie w dowolnym czasie bez potrzeby informowania użytkownik&oacute;w. Użytkownicy odpowiedzialni są za regularne przeglądanie tych warunk&oacute;w oraz zastrzeżeń, a następujące po wszelkich zmianach korzystanie z witryn jest r&oacute;wnoznaczne z ich akceptacją.</li>\r\n	<li>Dodawanie obiekt&oacute;w poprzez nasz zesp&oacute;ł<br />\r\n	Godząc się na dodanie oferty poprzez Zesp&oacute;ł w serwisie zakładamy, że prawa własności materiał&oacute;w kt&oacute;re udostępniasz i z kt&oacute;rych korzystasz przy dodaniu oferty (strona internetowa, zdjęcia itd.) należą do Ciebie.<br />\r\n	Godząc się na dodanie oferty poprzez Zesp&oacute;ł w serwisie zobowiązujesz się do posiadania praw własności materiał&oacute;w wykorzystanych przez serwis. W przeciwnym wypadku zobowiązujesz się do zmiany materiał&oacute;w wyświetlanych w w witrynie.</li>\r\n</ol>\r\n\r\n<p><span style="color:#696969;">Ostatnia aktualizacja regulaminu: 1.01.2017</span></p>\r\n', '', ''),
(3, 'Kontakt', 'kontakt', 'contact', '', '', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logs_mails`
--

CREATE TABLE `logs_mails` (
  `id` int(11) NOT NULL,
  `receiver` varchar(64) NOT NULL,
  `action` varchar(32) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logs_offers`
--

CREATE TABLE `logs_offers` (
  `id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logs_users`
--

CREATE TABLE `logs_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `mails`
--

CREATE TABLE `mails` (
  `name` varchar(64) NOT NULL,
  `full_name` varchar(64) NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `mails`
--

INSERT INTO `mails` (`name`, `full_name`, `subject`, `message`) VALUES
('contact_form', 'Contact form', 'Wiadomość z formularza kontaktowego strony {title}', '<p>Witaj!</p>\r\n\r\n<p>Została do Ciebie wysłana wiadomość z formularza kontaktowego ze strony {base_url}</p>\r\n\r\n<p>Nadawca: {name}</p>\r\n\r\n<p>Adres email: {email}</p>\r\n\r\n<p>Wiadomość: {message}</p>\r\n'),
('finish_promote', 'Finish promote', 'Zakończenie promowania oferty {offer_name}', '<p>Witaj,</p>\r\n\r\n<p>Twoja oferta <a href="{offer_url}">{offer_url}</a>&nbsp;na stronie&nbsp;<a href="{base_url}">{base_url}</a>&nbsp;przestała być promowana.</p>\r\n\r\n<p>Wyr&oacute;żnij się na tle konkurencji i ponownie wypromuj swoją ofertę!</p>\r\n\r\n<p>Więcej szczeg&oacute;ł&oacute;w na stronie&nbsp;<a href="{offer_url}">{offer_url}</a>&nbsp;w zakładce &quot;Promuj&quot;</p>\r\n\r\n<p>Pozdrawiamy<br />\r\n{title}<br />\r\n<br />\r\n<a href="{base_url}">{link_logo}</a></p>\r\n\r\n<p>&nbsp;</p>\r\n'),
('offer', 'Offer', 'Wiadomość do oferty {offer_name}', '<p>Witaj!</p>\r\n\r\n<p>Została do Ciebie wysłana wiadomość ze strony <a href="{base_url}">{base_url}</a> dotycząca oferty <a href="{offer_url}">{offer_url}</a></p>\r\n\r\n<p>Nadawca: {name}</p>\r\n\r\n<p>Adres email: {email}</p>\r\n\r\n<p>Wiadomość: {message}</p>\r\n'),
('offer_start', 'Offer - start displaying', 'Aktywacja oferty {offer_name}', '<p>Witaj,</p>\r\n\r\n<p>Dodałeś ofertę <a href="{offer_url}">{offer_url}</a>&nbsp;na stronie&nbsp;<a href="{base_url}">{base_url}</a>.</p>\r\n\r\n<p>Link do edycji oferty:&nbsp;<a href="{offer_edit_link}">{offer_edit_link}</a>&nbsp;</p>\r\n\r\n<p>Pozdrawiamy<br />\r\n{title}<br />\r\n<br />\r\n<a href="{base_url}">{link_logo}</a></p>\r\n'),
('profile', 'Profile', 'Wiadomość do profilu {username}', '<p>Witaj!</p>\r\n\r\n<p>Została do Ciebie wysłana wiadomość ze strony&nbsp;<a href="{base_url}">{base_url}</a>&nbsp;ze strony Twojego profilu {username}</p>\r\n\r\n<p>Nadawca: {name}</p>\r\n\r\n<p>Adres email: {email}</p>\r\n\r\n<p>Wiadomość: {message}</p>\r\n'),
('register', 'Register', 'Witamy na stronie {title}', '<p>Witaj na stronie <a href="{base_url}">{title}</a>!<br />\r\n<br />\r\nDziękujemy za rejestrację.<br />\r\n<br />\r\nŻeby ją dokończyć kliknij w link: <a href="{activation_link}">{activation_link}</a><br />\r\n<br />\r\nInformujemy że link aktywacyjny jest ważny 24 godziny, po tym czasie nieaktywowane konta zostają usuwane.<br />\r\nJeśli to nie Ty się rejestrowałeś to zignoruj tą wiadomość<br />\r\n<br />\r\nPozdrawiamy<br />\r\n{title}<br />\r\n<br />\r\n<a href="{base_url}">{link_logo}</a></p>\r\n'),
('register_fb', 'Register by Facebook', 'Witamy na stronie {title}', '<p>Witaj na stronie <a href="{base_url}">{title}</a>!<br />\r\n<br />\r\nDziękujemy za rejestrację poprzez konto Facebook.</p>\r\n\r\n<p>Twoje losowo wygenerowane hasło to: {password}<br />\r\n<br />\r\nPozdrawiamy<br />\r\n{title}<br />\r\n<br />\r\n<a href="{base_url}">{link_logo}</a></p>\r\n'),
('reset_password', 'Reset password', 'Reset hasła - {title}', '<p>Witaj {username}!<br />\r\n<br />\r\nAby zresetować swoje hasło do serwisu <a href="{base_url}">{title}</a> kliknij w następujący link: <a href="{reset_password_link}">{reset_password_link}</a><br />\r\n<br />\r\nPozdrawiamy<br />\r\n{title}</p>\r\n'),
('start_promote', 'Start promote', 'Rozpoczęcie promowania oferty {offer_name}', '<p>Witaj,</p>\r\n\r\n<p>Twoja oferta <a href="{offer_url}">{offer_url}</a>&nbsp;na stronie&nbsp;<a href="{base_url}">{base_url}</a>&nbsp;zaczęła być promowana.</p>\r\n\r\n<p>Dzięki temu będzie się wyr&oacute;żniać na tle konkurencji!</p>\r\n\r\n<p>Pozdrawiamy<br />\r\n{title}<br />\r\n<br />\r\n<a href="{base_url}">{link_logo}</a></p>\r\n\r\n<p>&nbsp;</p>\r\n');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `address` varchar(512),
  `address_lat` float(10,6),
  `address_long` float(10,6),
  `url` varchar(128),
  `phone` varchar(32),
  `phone_mobile` varchar(32),
  `email` varchar(64),
  `category` int(11),
  `state` int(11),
  `description` text,
  `active` int(1) NOT NULL,
  `promoted` int(1),
  `promoted_date_end` date,
  `code` varchar(32) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Struktura tabeli dla tabeli `offers_categories`
--

CREATE TABLE `offers_categories` (
  `id` int(11) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `offers_categories`
--

INSERT INTO `offers_categories` (`id`, `slug`, `name`) VALUES
(1, 'biuro', 'Biuro'),
(2, 'biznes', 'Biznes'),
(3, 'budownictwo-i-nieruchomosci', 'Budownictwo i nieruchomości'),
(4, 'dom-i-ogrod', 'Dom i ogród'),
(5, 'edukacja-i-szkolnictwo', 'Edukacja i szkolnictwo'),
(6, 'finanse-i-ubezpieczenia', 'Finanse i ubezpieczenia'),
(7, 'gastronomia', 'Gastronomia'),
(8, 'handel', 'Handel'),
(9, 'hobby-i-rozrywka', 'Hobby i rozrywka'),
(10, 'komputery-i-internet', 'Komputery i Internet'),
(11, 'kultura-i-sztuka', 'Kultura i sztuka'),
(12, 'media-i-informacje', 'Media i informacje'),
(13, 'medycyna-i-zdrowie', 'Medycyna i zdrowie'),
(14, 'motoryzacja', 'Motoryzacja'),
(16, 'odziez-i-obuwie', 'Odzież i obuwie'),
(17, 'poligrafia', 'Poligrafia'),
(18, 'prawo', 'Prawo'),
(19, 'przemysl-i-produkcja', 'Przemysł i produkcja'),
(20, 'rolnictwo-i-lesnictwo', 'Rolnictwo i leśnictwo'),
(21, 'sport-i-turystyka', 'Sport i turystyka'),
(22, 'technika', 'Technika'),
(23, 'transport-i-spedycja', 'Transport i spedycja'),
(24, 'uroda-i-relaks', 'Uroda i relaks'),
(25, 'pozostale', 'Pozostałe'),
(26, 'administracja', 'Administracja');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `offers_options`
--

CREATE TABLE `offers_options` (
  `id` int(11) NOT NULL,
  `name` varchar(128),
  `slug` varchar(128),
  `position` int(11) NOT NULL,
  `kind` varchar(16),
  `required` int(1),
  `select_choices` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `offers_options_values`
--

CREATE TABLE `offers_options_values` (
  `offer_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `offers_state`
--

CREATE TABLE `offers_state` (
  `id` int(11) NOT NULL,
  `slug` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `offers_state`
--

INSERT INTO `offers_state` (`id`, `slug`, `name`) VALUES
(1, 'dolnoslaskie', 'Dolnośląskie'),
(2, 'kujawskopomorskie', 'Kujawsko-pomorskie'),
(3, 'lodzkie', 'Łódzkie'),
(4, 'lubelskie', 'Lubelskie'),
(5, 'lubuskie', 'Lubuskie'),
(6, 'malopolskie', 'Małopolskie'),
(7, 'mazowieckie', 'Mazowieckie'),
(8, 'opolskie', 'Opolskie'),
(9, 'podkarpackie', 'Podkarpackie'),
(10, 'podlaskie', 'Podlaskie'),
(11, 'pomorskie', 'Pomorskie'),
(12, 'slaskie', 'Śląskie'),
(13, 'swietokrzyskie', 'Świętokrzyskie'),
(14, 'warminskomazurskie', 'Warmińsko-mazurskie'),
(15, 'wielkopolskie', 'Wielkopolskie'),
(16, 'zachodniopomorskie', 'Zachodniopomorskie'),
(17, 'zagranica', '- Zagranica');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payments_dotpay`
--

CREATE TABLE IF NOT EXISTS `payments_dotpay` (
  `id` int(11) NOT NULL,
  `dotpay_id` varchar(7) COLLATE utf8_polish_ci NOT NULL,
  `operation_status` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `operation_number` varchar(15) COLLATE utf8_polish_ci NOT NULL,
  `offer_id` int(11) NOT NULL,
  `operation_amount` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `operation_original_amount` varchar(14) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `operation_datetime` datetime NOT NULL,
  `date_URLC` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `offer_id` int(11),
  `thumb` varchar(256) NOT NULL,
  `url` varchar(256) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reset_password`
--

CREATE TABLE `reset_password` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `used` int(1),
  `active` int(1) NOT NULL,
  `code` varchar(32) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `session_offer`
--

CREATE TABLE `session_offer` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `session_user`
--

CREATE TABLE `session_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `settings`
--

CREATE TABLE `settings` (
  `name` varchar(64) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `settings`
--

INSERT INTO `settings` (`name`, `value`) VALUES
('add_offers_not_logged', '1'),
('ads_1', ''),
('ads_2', ''),
('ads_3', ''),
('ads_4', ''),
('ads_side_1', ''),
('ads_side_2', ''),
('analytics', ''),
('automatically_activate_offers', '1'),
('base_url', ''),
('check_ip_user', '1'),
('code_body', ''),
('code_head', ''),
('code_style', ''),
('currency', 'zł'),
('description', 'Skrypt katalogu firm EMPRESA - stwórz swój własny katalog firm w Internecie!'),
('dotpay_currency','PLN'),
('dotpay_id', ''),
('dotpay_pin',''),
('dotpay_test_mode','0'),
('email', ''),
('enable_articles', '1'),
('facebook_api', ''),
('facebook_lang', 'pl_PL'),
('facebook_login', ''),
('facebook_secret', ''),
('facebook_side_panel', ''),
('favicon', '/upload/images/favicon.png'),
('footer_bottom', ''),
('footer_text', ''),
('footer_top', ''),
('generate_sitemap', '1'),
('google_maps', ''),
('google_maps_api', ''),
('google_maps_api2', ''),
('google_maps_lat', '52.072754'),
('google_maps_long', '19.028321'),
('google_maps_zoom_add', '5'),
('google_maps_zoom_offer', '10'),
('hide_data_not_logged', '0'),
('hide_email', '0'),
('hide_phone', '0'),
('hide_views', '0'),
('keywords', 'firmy, katalog firm, internetowy katalog firm, firma'),
('lang', 'pl'),
('limit_page', '10'),
('limit_page_index', '8'),
('logo', '/upload/images/logo.png'),
('logo_facebook', '/upload/images/logo.png'),
('mail_attachment', '1'),
('photo_add', '1'),
('photo_max', '10'),
('photo_max_height', '0'),
('photo_max_size', '0'),
('photo_max_width', '0'),
('photo_quality', '75'),
('promote_by_dotpay', '0'),
('promote_cost', '2.46'),
('promote_days', '30'),
('reviews_facebook', '1'),
('rss', '1'),
('rodo_alert', ''),
('rodo_alert_text', '<p>Szanowny użytkowniku,<br />\r\npragniemy Cię poinformować, że nasz serwis internetowy może personalizować treści marketingowe do Twoich potrzeb. W związku z tym danymi osobowymi, kt&oacute;re przetwarzamy są np. Tw&oacute;j adres IP, dane pozyskiwane na podstawie plik&oacute;w cookies lub podobnych mechanizm&oacute;w na Twoim urządzeniu o ile pozwolą one na zidentyfikowanie Ciebie.&nbsp;<br />\r\nJeżeli klikniesz przycisk &bdquo;Wyrażam zgodę na przetwarzanie moich danych osobowych&rdquo; lub zamkniesz to okno, to wyrazisz zgodę na przetwarzanie Twoich danych przez właściciela witryny i jego zaufanych partner&oacute;w.<br />\r\nWyrażenie zgody jest dobrowolne. Masz prawo do: dostępu do Twoich danych, ich sprostowania oraz usunięcia. Więcej informacji odnośnie przetwarzania danych osobowych znajdziesz w naszej <a href=\"/info/1,polityka-prywatnosci\">Polityce Prywatności.</a></p>\r\n\r\n<p>Lista zaufanych partner&oacute;w:<br />\r\nGoogle - na stronie są zamieszczone kody reklam Adsense oraz Google Analytics, kt&oacute;re mają na celu wyświetlanie spersonalizowanych treści oraz zbieranie informacji o zachowaniu użytkownika w celu poprawy strony.<br />\r\nFacebook - na stronie zamieszczony jest kod Facebook mający na celu wyświetlanie boksu z komentarzami oraz panelu bocznego.</p>\r\n'),
('search_box_address', '0'),
('search_box_category', '1'),
('search_box_distance', '0'),
('search_box_keywords', '1'),
('search_box_options', '1'),
('search_box_state', '1'),
('smtp', '0'),
('smtp_host', ''),
('smtp_mail', ''),
('smtp_password', ''),
('smtp_port', '587'),
('smtp_secure', 'tls'),
('smtp_user', ''),
('social_facebook', '1'),
('social_pinterest', '1'),
('social_twitter', '1'),
('social_wykop', '1'),
('template', 'default'),
('title', 'Skrypt katalogu firm EMPRESA'),
('url_facebook', ''),
('url_privacy_policy', 'polityka-prywatnosci'),
('url_rules', 'regulamin'),
('watermark', '/upload/images/watermark.png'),
('watermark_add', '1');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `content` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(64),
  `email` varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL,
  `active` int(1),
  `moderator` int(1),
  `description` text,
  `activation_code` varchar(32) NOT NULL,
  `register_fb` int(1),
  `register_ip` varchar(40) NOT NULL,
  `activation_date` datetime,
  `activation_ip` varchar(40),
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;


--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_logs`
--
ALTER TABLE `cms_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_session`
--
ALTER TABLE `cms_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `index_page`
--
ALTER TABLE `index_page`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs_mails`
--
ALTER TABLE `logs_mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs_offers`
--
ALTER TABLE `logs_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs_users`
--
ALTER TABLE `logs_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers_categories`
--
ALTER TABLE `offers_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers_options`
--
ALTER TABLE `offers_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers_state`
--
ALTER TABLE `offers_state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments_dotpay`
--
ALTER TABLE `payments_dotpay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset_password`
--
ALTER TABLE `reset_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session_offer`
--
ALTER TABLE `session_offer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session_user`
--
ALTER TABLE `session_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `cms`
--
ALTER TABLE `cms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `cms_logs`
--
ALTER TABLE `cms_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `cms_session`
--
ALTER TABLE `cms_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT dla tabeli `logs_mails`
--
ALTER TABLE `logs_mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `logs_offers`
--
ALTER TABLE `logs_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `logs_users`
--
ALTER TABLE `logs_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `offers_categories`
--
ALTER TABLE `offers_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT dla tabeli `offers_options`
--
ALTER TABLE `offers_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `offers_state`
--
ALTER TABLE `offers_state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT dla tabeli `payments_dotpay`
--
ALTER TABLE `payments_dotpay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `reset_password`
--
ALTER TABLE `reset_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `session_offer`
--
ALTER TABLE `session_offer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `session_user`
--
ALTER TABLE `session_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
