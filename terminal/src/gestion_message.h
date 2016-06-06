#ifndef MA_GESTION
#define MA_GESTION
#define TLIM 256 
#define BUSLIM 5
//je ne suis pas capable de decouper un nom de fichier et la taille max d'un fichier est 255car
int set_message(char message[TLIM]);
char* get_message();
int pop_id();
void push_id(int id);
void charge_id();
int get_pos();
int size_message();
#endif

