package TrafficLight.Command;

import TrafficLight.Entities.CarLight;

public class SimpleCarLightCommand implements ICommand {
    private CarLight myLight;
    private boolean run = true;
    public SimpleCarLightCommand(CarLight carL) {
        this.myLight = carL;
    }

    @Override
    public void execute() {
        run = true;
        while(run==true){
            myLight.getLightBehaviour().start(myLight);
            myLight.getLightBehaviour().wait(5);
            myLight.getLightBehaviour().stop(myLight);
            myLight.getLightBehaviour().wait(5);
        }
        }


    @Override
    public void unexecute() {
        run = false;
        myLight.getLightBehaviour().stop(myLight);
    }

    @Override
    public void emergency() {
        run=false;
        myLight.getLightBehaviour().emergency(myLight);
    }

    @Override
    public void nightmode() {
        run=false;
        myLight.getLightBehaviour().nightMode(myLight);
    }

    @Override
    public void stop() {
        run = false;
        myLight.getLightBehaviour().stop(myLight);
    }
}