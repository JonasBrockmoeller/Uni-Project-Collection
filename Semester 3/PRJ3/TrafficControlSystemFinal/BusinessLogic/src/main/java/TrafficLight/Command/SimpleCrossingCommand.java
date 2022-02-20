package TrafficLight.Command;

import TrafficLight.Entities.CarLight;
import TrafficLight.Entities.ICarLight;
import TrafficLight.Entities.IPedestrianLight;
import TrafficLight.Entities.PedestrianLight;
import TrafficLight.IObserver.Observer;

import java.io.IOException;

public class SimpleCrossingCommand implements ICommand {

    private CarLight cLight;
    private PedestrianLight pLight;

    public SimpleCrossingCommand(CarLight cLight, PedestrianLight pLight) {
        this.cLight = cLight;
        this.pLight = pLight;
    }

    @Override
    public void execute(){
        // cLight should change with goTORed and call the lightbehaviour inside the method
        cLight.getLightBehaviour().stop(cLight);
        pLight.getLightBehaviour().request(pLight);
        this.unexecute();
    }

    @Override
    public void unexecute() {
        System.out.println("\n");
        pLight.getLightBehaviour().stop(pLight);
        // cLight should change with goTORed and call the lightbehaviour inside the method
        cLight.getLightBehaviour().start(cLight);
    }

    public PedestrianLight getpLight() {
        return pLight;
    }

    @Override
    public void emergency() {
        cLight.getLightBehaviour().emergency(cLight);
        pLight.getLightBehaviour().emergency(pLight);
    }

    @Override
    public void nightmode() {
        cLight.getLightBehaviour().nightMode(cLight);
        pLight.getLightBehaviour().nightMode(pLight);
    }

    @Override
    public void stop() {
        pLight.getLightBehaviour().stop(pLight);
        // cLight should change with goTORed and call the lightbehaviour inside the method
        cLight.getLightBehaviour().start(cLight);
    }
}
