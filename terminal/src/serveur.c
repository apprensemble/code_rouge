//pour les sockets
#include <errno.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <arpa/inet.h>

//gestion des signaux
#include <signal.h>

//pour le fork
#include <unistd.h>
#include <sys/wait.h>


//perso
#include "menu.h"
#include "ls.h"
#include "gestion_message.h"

static int compteur = 0;
//definition du serveur (cad adresse/port d'ecoute)
int def_serveur(struct sockaddr_in *server) {

	//definition de la cible
	server->sin_addr.s_addr = htonl(INADDR_ANY);
	server->sin_family = AF_INET;
	server->sin_port = htons(2080);

	return 0;
}

void liste_referentiel(int ta_socket) {
	lecture("entete_ref");
	ecriture_s(ta_socket);
		while (liste_fichiers(".")) {
			ecriture_s(ta_socket);
		}
}
//creation socket qu'on attache au serveur
int init_serveur(struct sockaddr_in *server) { 

	//creation de la socket
	int ma_socket;
	ma_socket = socket(AF_INET , SOCK_STREAM , 0);

	if (ma_socket == -1) {
		perror("impossible de creer ton socket de merde\n");
		exit(errno);

	}

	//il faut a present rattacher la socket au couple adresse/port defini dans la struct server
	if (bind(ma_socket,(struct sockaddr *) server,sizeof *server) <0) {
		perror("impossible de joindre les deux bouts\n");
		exit(errno);
	}

	//on accepte une file de 5(5 ou 1 je ne vois pas la diff)
	if(listen(ma_socket,5)<0) {
		perror("can't listen, je suis sourd\n");
		exit(errno);
	}
	return ma_socket;
}

creation_canal(int ma_socket,int *ta_socket,struct sockaddr_in *client) {
	int client_size = sizeof client;
	//a present on prend en charge les connexions
	*ta_socket = accept(ma_socket,(struct sockaddr *)client,&client_size);
	if (*ta_socket < 0) {
		perror("change ta socket\n");
		exit(errno);
	}
}

int ecriture_s(int ta_socket) {
	char message[TLIM];
	strcpy(message,get_message());
	int n = strlen(message);
	printf("%s de taille %d\n",message,n);
	//ajouter un mode debug?
	//printf("strlen message : %d\n%s\n",strlen(message),message);
	write(ta_socket,message,n);
}
int lecture_s(int ta_socket) {
	char message[TLIM];
	char garde_message[TLIM];
	int n;
	//if ((n=read(ta_socket, message, TLIM))>0 && n<=TLIM) strncpy(garde_message,message,n);
	if ((n=read(ta_socket, message, TLIM))>0) strncpy(garde_message,message,n);
	else strcpy(garde_message,"pas de reponse");
	set_message(garde_message);
	return n;
}

void quitter(int ta_socket) {
	//fermeture des connexions
	printf("bye bye...\n");
	close(ta_socket);
	pop_id();
	exit(0);
}

//c'est le vrai main. le coeur du service
void lancement_service(int ta_socket) {

	chdir("refs");
	int n;
	int choix;
	choix = 1;
	char mMessage[TLIM] = "";
	char reponse[TLIM] = "";
	char nom[TLIM] = "";
	if ((n=read(ta_socket, nom, TLIM))>0);
	else strcpy(nom,"sombre inconnu");
	banniere(nom);
	ecriture_s(ta_socket);
	while (choix) {
		n = lecture_s(ta_socket);
		if (sscanf(get_message(),"%s",mMessage)>0) {
			while ((n=lecture(mMessage))==1) {
				ecriture_s(ta_socket);
			}
			if (n<0) {
				liste_referentiel(ta_socket);
			}
		}
		if (!strcmp(mMessage,"3")) {
			choix = 0;
			quitter(ta_socket);
		}
	}
}


void pipe_handler(int signum) {
	printf("numero de signal %d\n",signum);
	exit(0);

}

void connexion_individuelle(void* m_socket) {
	//cree un canal puis lance le service grace a ta_socket


	int ma_socket = *(int*) m_socket;
	int ta_socket;
	struct sockaddr_in client;
	creation_canal(ma_socket,&ta_socket,&client);
	printf("lancement service\n");
	close(ma_socket);
	lancement_service(ta_socket);
}

int main(int argc,int **argv) {
	char *message, reponse_server[TLIM];
	//charge_id();


	signal(SIGPIPE, pipe_handler);

	//tout en un cote serveur
	struct sockaddr_in server;
	def_serveur(&server);
	int ma_socket = init_serveur(&server);

	int i;
	i=0;
	while(1) {
		pid_t pid;
		int status;
		pid = fork();
		push_id(pid);
		if (pid == 0) {
			connexion_individuelle(&ma_socket);
			printf("n'arrive jamais %d\n",get_pos());
		}
		sleep(1);
	}

	printf("compteur %d\n",compteur);
	printf("good bye\n");
	exit(0);
}
