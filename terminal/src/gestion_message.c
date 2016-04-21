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
static char message[BUSLIM][TLIM];
int set_message(char nouveau_message[TLIM], int id) {
  strcpy(message[id], nouveau_message);
}
char* get_message (int id) {
  return message[id];

}
