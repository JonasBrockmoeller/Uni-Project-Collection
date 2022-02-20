package TrafficLight.Command;

import TrafficLight.Entities.PedestrianLight;

public interface ICommand {
    void execute();
    void unexecute();
    void emergency();

    void nightmode();

    void stop();
}
