#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <signal.h>
#include "gestion_message.h"
//quasi copier/coller de http://www.binarytides.com/socket-programming-c-linux-tutorial/
void pipe_handler(int signum) {
	perror("broken pipe ");
	exit(signum);

}
int main (int argc, char *argv[]) {
int ma_socket;
struct sockaddr_in server;
char message[TLIM], reponse_server[TLIM];
strcpy(reponse_server,"");

signal(SIGPIPE, pipe_handler);

//definition de la cible
//server.sin_addr.s_addr = inet_addr("172.17.0.37");
server.sin_addr.s_addr = inet_addr("127.0.0.1");
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
if (argv[1] == NULL) {
  strcpy(message,"JAMES KIRK");
}
  else strcpy(message,argv[1]);
if (send(ma_socket , message, strlen(message) , 0) < 0)
{
  puts ("echec envoie");
  return 1;
}

//reception du resultat de la requete

int n;
int c;
c=1;
while (strcmp(message,"4")) {
	if ((n=read(ma_socket, reponse_server, TLIM))>0) {
		write(1,reponse_server,n);
	}
	if (n<TLIM && n>0) {
		printf("choix : ");
		scanf("%s",message);
		send(ma_socket , &message, TLIM , 0);
		clean_stdin();
	}
	else {
		//printf("long message\n");
	}
}
close(ma_socket);

return 0;
}
