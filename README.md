CODE ROUGE alias fil rouge 2015/2016
====================================

Le but est de reproduire ce que l'on a vu en cours

* phase1 : ./terminal
* phase2 : ./terminal/res/
* phase3 : ./php/
* phase4 : ./redaction/UML_Fil_Rouge.jpg
* phase5 : ./php/
* phase6 : ./phase6
* phase7 : ./mvc_dom/IhmFilRouge
* phase9 : ./mvc_dom/ihmFilRouge

# phase1

## prerequis :

* tmux
* env de compilation c

## avec tmux

Aller dans le repertoire terminal src 
make clean
make
make test
tmux attach

## sans tmux 

./serveur coté serveur

./client --s ip_dest -n username_au_hasard

# phase2

./transformer
firefox index.html

# phase3

deployer le php
inserer dans la bdd mysql : mysql -u root -p < scripts/gestion_site.sql
viser AdminProd_Accueil.php dans le navigateur

# phase4

c'est un diagramme : ./redaction/UML_Fil_Rouge.jpg

# phase5

viser login.php

# phase6

deployer dans eclipse le rep phase6/servlet

# phase7

dans le rep mvc_dom/IhmFilRouge

1. Installer nodeJS
2. bower install
3. npm install
4. npm start

http://localhost:8000/app

# phase9

dans le rep mvc_doc/ihmFilRouge

mvn clean
mvn install
mvn spring-boot:run

acces : http://localhost:8001/ihmFilrouge/lireProduits

# slides :

./redaction/slides/Présentation-filRouge.pptx
