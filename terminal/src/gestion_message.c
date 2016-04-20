#include "gestion_message.h"
#include <string.h>
#include <stdio.h>
static char message[TLIM];
int set_message(char nouveau_message[TLIM]) {
  strcpy(message,nouveau_message);
}
char* get_message () {
  return message;

}
