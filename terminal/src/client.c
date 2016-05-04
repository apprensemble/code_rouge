#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <signal.h>
#include "gestion_message.h"
#include "ls.h"
//quasi copier/coller de http://www.binarytides.com/socket-programming-c-linux-tutorial/
void pipe_handler(int signum) {
	perror("broken pipe ");
	exit(signum);

}
int creation_fd(char message[]) {
	int fd;
	if ((fd = open(message,O_CREAT | O_CLOEXEC | O_WRONLY,S_IRUSR | S_IWUSR)) == -1) {
		fprintf(stderr,"le fichier %s n'a pu etre cree\n",message);
		fd = 1;
	}
	return fd;
}
void emission(int ma_socket, char message[TLIM]) {
	send(ma_socket , &message, TLIM , 0);
	//clean_stdin();
}
int reception(int ma_socket, int fd) {
	int n = 0;
	char reponse_server[TLIM];
	if ((n=read(ma_socket, reponse_server, TLIM-1))>0) {
		write(fd,reponse_server,n);
		if (fd != 1) write(1,reponse_server,n);
	}
	return n;
}
void quitter(int status) {
			perror("argv[0] --s ip_dest [ --n nom_d_utilisateur ]\n");
			exit(status);
}

int main (int argc, char *argv[]) {

	int ch; // pour le choix des arguments man 
	extern int optind, optopt, opterr; // j'ai l'impression que c'est obligatoire
	extern char *optarg; // ça aussi

	//sauvegarde des options
	char *adresse_serveur = NULL;
	char *nom = NULL; // penser à verifier que le nom fourni n'est pas trop long


	int ma_socket;
	struct sockaddr_in server;
	char message[TLIM], reponse_server[TLIM];
	strcpy(reponse_server,"");

	signal(SIGPIPE, pipe_handler);

	while ((ch = getopt(argc, argv, ":s:n:")) != -1 ) {
		switch(ch) {
			case 's':
				adresse_serveur = optarg;
				break;
			case 'n':
				nom = optarg;
				break;
			case '?':
				quitter(0);
				break;
		}
	}


	if (NULL == nom) {
		nom = "JAMES KIRK";
	}
	if (NULL == adresse_serveur) {
		adresse_serveur = "127.0.0.1";
	}
	printf("----\n");
	printf("%s etabli une cnx vers %s\n", nom, adresse_serveur);

	//definition de la cible
	//server.sin_addr.s_addr = inet_addr("172.17.0.37");
	server.sin_addr.s_addr = inet_addr(adresse_serveur);
	server.sin_family = AF_INET;
	server.sin_port = htons(2080);

	//creation de la socket
	ma_socket = socket(AF_INET , SOCK_STREAM , 0);

	if (ma_socket == -1) {
		printf("impossible de creer ton socket de merde");
	}

	//connexion vers le serveur distant
	if (connect(ma_socket , (struct sockaddr *)&server , sizeof(server)) < 0)
	{

		puts("erreur de connexion");
		return 1;
	}

	puts("connexion active");
	//envoi d'un identifiant(optionnel)
	strcpy(message, nom);
	if (send(ma_socket , &message, strlen(message) , 0) < 0)
	{
		puts ("echec envoie");
		return 1;
	}

	//reception du resultat de la requete

	int n = 1;
	int c;
	int fd = creation_fd("menu"); //stdout
	char *nom_fichier;
	c = 1;
	while (strcmp(message,"3")) {
		n = reception(ma_socket, fd);
		printf("n : %d\n",n);
		if (n<TLIM-1) {
			if (fd != 1) close(fd);
			strcpy(message,"");
			printf("\nnom fichier : ");
			scanf("%s", message);
			fd = creation_fd(message);
			send(ma_socket, &message, TLIM , 0);
		}
		//printf("choix local ?\n");
	}
	if (fd != 1) close(fd);
	close(ma_socket);
	exit(0);

}

