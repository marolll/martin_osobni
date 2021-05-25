Upravená verze nette/sandbox následovně:

Postup tvorby:

    composer create-project nette/sandbox . (pokud chci instalovat do aktuálního adresáře)

    composer require contributte/translations

V tomto projektu jsou:

    - připraveny překlady včetně nastaveného přepínání jazyků v navigační liště stránky, překladů ve složce lang a také ikon jazyků ve formátu .svg

    - jednotlivé jazykové verze byly rozděleny ve složce lang do zvláštních složek, vždy jedna pro každou jazykovou verzi, název složky odpovídá použitému locale

    - zavedeno použití modulů v nette

    - integrována knihovna pro tvorbu výpisů z databázových tabulek, včetně stránkování (Autor: Tomáš Kovařík)

    - integrována knihovna Bootstrap ve verzi 5.0

    - připravena složka sql pro ukládání aktuálního stavu databáze

    - upraven soubor Bootstrap.php tak, aby bylo možné jendnoduše tapínat a vypínat debug režim, zároveň přidán nový typ bootu (BootForCron) pro bootování cron jobů (zároveň může být upraven i soubor index.php, pro vypínání a zapínání debug módu)
   
    - vytvořena složka cron pro uchovávání scriptů, spouštěných pomocí cronu včetně ukázkového souboru (cron-test.php) - nutné pouze vytvořit třídu Cron ve složce App\Model, případně použít jinou sotupnou třídu