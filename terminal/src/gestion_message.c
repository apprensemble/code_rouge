#include "gestion_message.h"
#include <string.h>
#include <stdio.h>
/*
 *
 * L'idée est d'avoir un bus static de message par thread
 * lors de la creation d'un thread un numero de bus sera attribué
 * lors de la destruction ce numero sera remis dans le pool de bus
 */
static int bus_ids[BUSLIM];
static int pos = BUSLIM - 1; //pos pour position de l'id
static char message[BUSLIM][TLIM];
void charge_id() {
	int i;
	for (i = 0;i < BUSLIM; i++) bus_ids[i] = i;
}
int set_message(char nouveau_message[TLIM], int id) {
  strcpy(message[id], nouveau_message);
}
char* get_message (int id) {
  return message[id];
}
//je ne fais pas de lock et compte sur une gestion en amont
int pop_id() {
	return bus_ids[pos--];
}
void push_id(int id) {
	bus_ids[pos++] = id;
}
