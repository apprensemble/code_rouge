#include "ls.h"
#include "gestion_message.h"

int lecture(char *nom_de_fichier) {
  char tampax[TLIM];
  int n;
  static int fd =-1;
  char message[TLIM]="";


  if (fd==-1) {
    if ((fd = open(nom_de_fichier,O_RDONLY,0)) == -1) {
      perror("le fichier n'a pu etre ouvert");
      strcpy(message,"le fichier n'a pu etre ouvert\n");
      set_message(message);
      return -1;
    }
  }

  if ((n = read(fd,tampax,TLIM-1)) > 0) {
    strncpy(message,tampax,n);
    set_message(message);
    return 1;
  }
  else {
    close(fd);
    fd=-1;
  }
    return 0;
}

int ecriture(char *nom_de_fichier) {
}

int liste_fichiers(char *rep) {
  //ajout pour pouvoir ecrire dans la socket

  static DIR *dir_fd;
  struct dirent *dp; //structure decrite dans :Man 3 readdir
  char nom[TLIM];
  char message[TLIM];
  if (dir_fd == NULL) {
    if ((dir_fd = opendir(rep)) == NULL) {
      strcat(message,"impossible d'ouvrir le rep ");
      strcat(message,rep);
      strcat(message,"\n");
      set_message(message);
      return 0;
    }
  }
  if ((dp = readdir(dir_fd)) != NULL) {
    if (strcmp(dp->d_name, ".") == 0 || strcmp(dp->d_name, "..") == 0) {
      set_message("\0");
      return 1;

    }
    if (strlen(rep)+strlen(dp->d_name)+2 > sizeof(nom))
      fprintf(stderr, "nom %s/%s trop long pour etre lu\n", rep, dp->d_name);
    else { 
      sprintf(nom, "%s", dp->d_name);
      strcat(nom,"\n");
      strcpy(message,nom);
      set_message(message);
    }
  }
  else {
    dir_fd = NULL;
    return 0;
  }
  return 1;
}
