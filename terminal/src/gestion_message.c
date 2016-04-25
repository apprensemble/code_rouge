#include "gestion_message.h"
#include <string.h>
#include <stdio.h>
/*
 *
 * L'idée est d'avoir un bus static de message par thread
 * lors de la creation d'un thread un numero de bus sera attribué
 * lors de la destruction ce numero sera remis dans le pool de bus
 * !!!!!! changement de programme j'utilise a present les push et pop comme compteur de fork !!!! fini les threads
 */
static int bus_ids[BUSLIM];
//static int pos = BUSLIM - 1; //pos pour position de l'id
static int pos = 0;
static char message[TLIM];
void charge_id() {
	int i;
	for (i = 0;i < BUSLIM; i++) bus_ids[i] = i;
}
int set_message(char nouveau_message[TLIM]) {
  strcpy(message, nouveau_message);
}
char* get_message () {
  return message;
}
//je ne fais pas de lock et compte sur une gestion en amont
int pop_id() {
		printf("poped %d\n",get_pos());
	return bus_ids[pos--];
}
void push_id(int id) {
	int status = 0;
	if (pos >= BUSLIM-1) {
		wait(&status);
	}
	else {
		bus_ids[pos++] = id;
	}
}
int get_pos() {
	return pos;
}
