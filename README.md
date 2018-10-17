# Finder

## Setup

Einzufügender Code:

```{% include 'Finder::content.Finder' %}```

Container-Verknüpfungen:

Container **Finder Javascript (Finder)**, ```Script loader: After scripts loaded``` (Haken setzen).
Optional kann unter **Finder Stylsheet (Finder)** per Haken unter ```Template: Style``` auch eigenes CSS für das Plugin
hinzugefügt werden.

## Konfiguration

#### Kategorie-Ids für Finder
Hier können die Kategorien & Merkmale festgelegt werden. Dafür können 3 Möglichkeiten gewählt werden:

* eine Kategorie und die definierten Merkmale: 1234;1,3,4
* viele Kategorien und deren Merkmale: 1234;1,2,3 | 4321;5,6,7 | 0987;9,8,4
* es soll eine Suche ausgeführt werden: 0;1,2,3

Bei Möglichkeit ist darauf zu achten, dass für jede Kategorie jeweils gleich viele Merkmalsgruppen angegeben werden.

#### Caching-Zeit
Anfragen für Kategorie- und Merkmaalsgruppeninfos können gecached werden. Hier kann eine Zeit in Minuten hinterlegt werden.

Standard: 300min (5h)

#### Tex für Button
Selbsterklärend.

#### Soll die Trefferanzahl im Button angezeigt werden
Ja/Nein.

Hier ist es empfehlenswert, den Text für den Button entsprechend anzupassen.
