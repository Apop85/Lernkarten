# Lernkarten
Diese Seite durchsucht alle Word-Dokumente nach darin hinterlegten Lernkarten-Einträgen.

# Installation
1. Repository herunterladen
2. Apache-Server oder Nginx installieren
3. PHP herunterladen
4. Apache/Nginx/PHP konfigurieren
5. Python 3 herunterladen und installieren
6. Python als Systemvariabel hinterlegen
7. Lernkarten-Dateien in HTML-Ordner von Apache oder Nginx verschieben

# Setup
Die Seite wird als erstes nach dem Installationspfad und dem Dokumentenpfad fragen.

Beispiel Installationspfad: C:\Apache\httpd\Lernkarten

Beispiel Dokumentenpfad: C:\Users\Username\Dokumente

Danach wird nach der Einleitung und dem Trennzeichen für die Fragen gefragt
Als standardeintrag für die Einleitung ist "//qa" hinterlegt und als Trennzeichen "<"

Dies wird folgendermassen in Worddateien verwendet:
//qa<Fach/Thema<Frage<Antwort<

Beispiel:
//qa<Mathematik/Addition<Was ergibt 1+1?<2<
