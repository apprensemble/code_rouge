tmux new -d \; split-window -h -d \; split-window -d
tmux split-window -t :1.3
tmux send-keys -t :1.4 "./serveur" ENTER
sleep 1
for i in 1 2 3; do 
	tmux send-keys -t :1.$i "cd ../test$i" ENTER
	tmux send-keys -t :1.$i "./client -n client$i" ENTER
done
