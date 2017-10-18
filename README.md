# UNMAINTAINED
This project is not maintained anymore. Feel free to fork and use it.
No support nor development will be done!

# UniFi presence
Die Anwesenheit eines WLAN-faehigen Geraetes wird Anhand der Einbuchung in ein UniFi WLAN Netz ermittelt und der Status als Variable abgelegt

### Inhaltverzeichnis

1. [Funktionsumfang](#1-funktionsumfang)
2. [Einrichten der Instanzen in IP-Symcon](#2-einrichten-der-instanzen-in-ip-symcon)
3. [PHP-Befehlsreferenz](#3-php-befehlsreferenz)

### 1. Funktionsumfang

* Anwesenheit eines Geraetes im UniFi WLAN ermitteln und als Variable ablegen

### 2. Einrichten der Instanzen in IP-Symcon

* Unter 'Instanz hinzufuegen das 'UniFiPresence'-Modul auswaehlen und eine neue Instanz erzeugen
* URL, Username und Passwort zum UniFi Controller angeben (ein Benutzer mit Leserechten ist ausreichend)
* MAC-Adresse des zu pruefenden Geraets angeben
* Aktualisierungsinterval waehlen

### 3. PHP-Befehlsreferenz

`LOCIUFP_Update();`
Aktualisiert die Werte der Instanz
