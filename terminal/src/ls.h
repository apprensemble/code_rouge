#include <string.h> //pour strlen
#include <stdlib.h>
#include <stdio.h>
#include <fcntl.h>
#include <dirent.h>
#include <sys/types.h>
#ifndef LS_FIC
#define LS_FIC
int lecture(char *nom_de_fichier);
int liste_fichiers(char *rep);
#endif
