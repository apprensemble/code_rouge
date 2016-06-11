##Makefile de debutant

serveur : gestion_message.o ls.o menu.o serveur.c client
	gcc -pthread serveur.c -g -o serveur menu.o ls.o gestion_message.o
menu.o : menu.c menu.h
	gcc -c -O3 menu.c
ls.o : ls.c ls.h
	gcc -c -O3 ls.c
gestion_message.o : gestion_message.c gestion_message.h
	gcc -c -O3 gestion_message.c
client : client.c 
	gcc client.c -o client menu.o ls.o gestion_message.o
clean_socket :
	rm serveur client
clean : clean_socket
	rm menu.o ls.o gestion_message.o
