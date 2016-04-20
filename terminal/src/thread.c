#include <stdio.h>
#include <stdlib.h>
#include <pthread.h>
//largement inspire de http://www.yolinux.com/TUTORIALS/LinuxTutorialPosixThreads.html
void *action_thread1(void *message) {
  //pas envie de me prendre la tete ce sera un message :p
  //pourquoi pas argv1
  int i;
  i=0;
  while(i++<1) {
    printf("Action du thread1 : %s\n",message);
    sleep(1);
  }
  printf("je connais la sortie\n");
  pthread_exit(0);

}
int action_thread2(pthread_t lautre) {
  //pas envie de me prendre la tete ce sera un message aussi :p
  //pourquoi pas argv2
  const char *message = "lire";
  while(1) {
    printf("Action du thread2: %s\n",message);
    sleep(2);
    printf("je te montre la sortie\n");
    pthread_cancel(lautre);
  }
}

int main(int argc, char **argv) {
  pthread_t thread1,thread2;
  pthread_create(&thread1,NULL,action_thread1,argv[1]);
  pthread_create(&thread2,NULL,(void*)action_thread2,(void*)thread1);

  //if () {
    //perror("echec de creation du thread 1\n");
    //exit(EXIT_FAILURE);
//
  //}
pthread_join(thread1,NULL);
printf("DARTH VADOR : fin du thread1 OK...\n");
//pthread_join(thread2,NULL);
sleep(5);
pthread_cancel(thread1);
exit(EXIT_SUCCESS);

}
