#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "menu.h"
#include "gestion_message.h"
int banniere(char *nom) {
  char message[TLIM];
  if (nom == NULL) {
    nom = "sombre inconnu";
  }
  strcat(message,"Bienvenue ");
  strcat(message,nom);
  strcat(message,"\n");
  strcat(message,"--------\n\n"); 
  set_message(message);
}
int menu() {
  char message[TLIM];
  strcpy(message,"\n\nmenu : \n1.liste des referentiels\n2.contenu d'un referentiel\n3.telechargement d'un referentiel\n4.quitter\n");
  set_message(message);
  return 0;
}
void clean_stdin() {
  int c;
  while(c=getchar()!='\n');
}
int choix() {
  int c;
  c=0;
  printf("choix : ");
  if (scanf("%d",&c)==1) ;
  else c=0;
  clean_stdin();
  return c;
}
