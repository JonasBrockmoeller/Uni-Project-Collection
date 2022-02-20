package TrafficLight.Command;

import TrafficLight.Entities.CarLight;
import TrafficLight.Entities.PedestrianLight;

public class CrossingWithTurnsCommand implements ICommand{

    private CarLight cLightEast_West;
    private CarLight cLightNorth_South;
    private CarLight cLightForTurns;
    private boolean stop = false;

    public CrossingWithTurnsCommand(CarLight cLightEW, CarLight cLightNS, CarLight cLightTurns) {
        this.cLightForTurns = cLightTurns;
        this.cLightEast_West = cLightEW;
        this.cLightNorth_South = cLightNS;
    }

    @Override
    public void unexecute() {
        while(!stop) {
            cLightNorth_South.getLightBehaviour().greenToRed(cLightNorth_South);
            cLightEast_West.getLightBehaviour().redToGreen(cLightEast_West);
            cLightEast_West.getLightBehaviour().greenToRed(cLightEast_West);
            cLightForTurns.getLightBehaviour().redToGreen(cLightForTurns);
            cLightForTurns.getLightBehaviour().greenToRed(cLightForTurns);
            cLightNorth_South.getLightBehaviour().redToGreen(cLightNorth_South);
        }
    }

    @Override
    public void execute() {
        this.stop = true;
    }


    @Override
    public void emergency() {
        cLightEast_West.getLightBehaviour().emergency(cLightEast_West);
        cLightNorth_South.getLightBehaviour().emergency(cLightNorth_South);
        cLightForTurns.getLightBehaviour().emergency(cLightForTurns);
    }

    @Override
    public void nightmode() {
        cLightEast_West.getLightBehaviour().nightMode(cLightEast_West);
        cLightNorth_South.getLightBehaviour().nightMode(cLightNorth_South);
        cLightForTurns.getLightBehaviour().nightMode(cLightForTurns);
    }

    @Override
    public void stop() {
        this.stop = true;
        cLightForTurns.getLightBehaviour().start(cLightForTurns);
        cLightNorth_South.getLightBehaviour().start(cLightNorth_South);
        cLightEast_West.getLightBehaviour().start(cLightEast_West);
    }

    public boolean getStop() {
        return stop;
    }

    public void setStop(boolean stop) {
        this.stop = stop;
    }
}
