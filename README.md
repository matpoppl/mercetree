# Uruchomienie

```
> php public/index.php
```
```
> php vendor/bin/phpunit
```

# OPIS ZADANIA
Firma produkująca drzewka świąteczne posiada w ofercie drzewka w następujących rozmiarach i cenach:
- małe: 100,00 PLN netto (123,00 PLN brutto)
- średnie: 200,00 PLN netto (246,00 PLN brutto)
- duże: 250,00 PLN netto (307,50 PLN brutto)
```
configs/dataset/trees.php
```
W przyszłości firma planuje powiększyć ofertę o kolejne rozmiary i typy sprzedawanych drzew.
```
configs/dataset/constraints.php
```
Małe drzewko jest ozdabiane w następujący sposób: 4 rzędy na ozdoby
- dolny rząd pomieści 4 ozdoby
- kolejny 3 ozdoby
- kolejny 2 ozdoby
- najwyższy 1 ozdobę

```
configs/dataset/constraints-small.php
```
W analogiczny sposób możliwa jest konfiguracja średniego i dużego drzewka, które
posiadają odpowiednio 5 i 6 rzędów
```
configs/dataset/constraints-medium.php
configs/dataset/constraints-big.php
```
Firma posiada w swojej ofercie następujące ozdoby wraz z cenami za nie:
- małe bombki
  - czerwone 3,30 PLN netto (4,06 PLN brutto),
  - niebieskie 3,50 PLN netto (4,30 PLN brutto),
  - żółte 3,60 PLN netto (4,43 PLN brutto)
- średnie bombki
  - zielone 4,44 PLN netto (5,46 PLN brutto),
  - białe 5,55 PLN netto (6,83 PLN brutto),
  - różowe 6,66 PLN netto (8,19 PLN brutto)
- duże bombki
  - 3 typy: bałwan, mikołaj, renifer - malowane ręcznie 8 PLN netto (9,84 PLN brutto), które nie pasują do małego drzewka
```
configs/dataset/tree-decorations.php
```

# ZAŁOŻENIA
1. Do oferty mogą wejść nowe ozdoby, w nowych kolorach i cenach,
```
configs/dataset/tree-decorations.php
```
oraz sprzedaż może być prowadzona również w innej walucie.
```
configs/shop_component.php ['currency_code' => 'PLN'] // PLN|EUR
class Mateusz\Mercetree\Shop\Currency\Converter\Converter {}
```
2. W jednym rzędzie nie mogą powtarzać się ozdoby
```
configs/dataset/constraints.php
class Mateusz\Mercetree\TreeConfigurator\Builder\Constraint\FeatureRepeatLimit {}
```
oraz na danym rozmiarze drzewka muszą być użyte wszystkie ozdoby dostępne dla tego rozmiaru.

```
configs/dataset/possibilities.php
class Mateusz\Mercetree\TreeConfigurator\Builder\Constraint\UnusedPossibilities {}
```

# ZADANIE
Twoim zadaniem jest przygotowanie programu do dekorowania drzewek

```
public/index.php
class Mateusz\Mercetree\TreeConfigurator\Configurator {}
```
oraz wyceny udekorowania drzewek.
```
public/index.php
class Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary {}
```

Program nie musi posiadać interface’u graficznego, musi za to spełniać wymagania funkcjonalne.
```
tests/unit
tests/integration
tests/acceptance
```
Program może posiadać uproszczoną infrastrukturę - nie musisz używać baz danych – wystarczy, że wytworzysz mosty pomiędzy biznesem a infrastrukturą wraz z odpowiednimi interfejsami.
```
namespace Mateusz\Mercetree\EntityManager {}
namespace Mateusz\Mercetree\Dbal {}
namespace Mateusz\Mercetree\Dbal {}
namespace Mateusz\Mercetree\TreeConfigurator\Data {}
```
