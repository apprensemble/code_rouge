#ifndef MA_GESTION
#define MA_GESTION
#define TLIM 256 //je ne suis pas capable de decouper un nom de fichier et la taille max d'un fichier est 255car
#define BUSLIM 5
int set_message(char message[TLIM]);
char* get_message();
int pop_id();
void push_id(int id);
void charge_id();
int get_pos();
#endif

