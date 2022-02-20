package TrafficLight.Entities;

import TrafficLight.Command.ICommand;
import TrafficLight.IObserver.Observer;

public class Crossing implements Observer {

    private ICommand command;

    public Crossing(ICommand pGo) {
        this.command = pGo;
    }

    public void start() {
        command.unexecute();
    }

    public void request() {
        command.execute();
    }

    @Override
    public void update() {
        command.execute();
    }

    public ICommand getCommand(){
        return command;
    }

    public void emergency() {
        command.emergency();
    }

    public void nightmode() {
        command.nightmode();
    }
    public void stop(){
        command.stop();
    }
}
