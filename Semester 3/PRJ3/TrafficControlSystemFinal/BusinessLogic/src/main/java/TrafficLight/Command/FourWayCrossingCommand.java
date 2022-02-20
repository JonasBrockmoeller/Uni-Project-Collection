package TrafficLight.Command;

import TrafficLight.Entities.CarLight;
import TrafficLight.Entities.PedestrianLight;

public class FourWayCrossingCommand implements ICommand{

    private CarLight cLightEast_West;
    private PedestrianLight pLightEast_West;

    private CarLight cLightNorth_South;
    private PedestrianLight pLightNorth_South;

    //NS = North south
    //EW = East west
    public FourWayCrossingCommand(CarLight cLightEW, PedestrianLight pLightEW, CarLight cLightNS, PedestrianLight pLightNS) {
        this.cLightEast_West = cLightEW;
        this.pLightEast_West = pLightEW;
        this.cLightNorth_South = cLightNS;
        this.pLightNorth_South = pLightNS;
    }

    public FourWayCrossingCommand(CarLight carLightEW, CarLight carLightNS){
        this.cLightEast_West = carLightEW;
        this.cLightNorth_South = carLightNS;
    }

    public void unexecute() {
        cLightEast_West.getLightBehaviour().greenToRed(cLightEast_West);

        if(pLightEast_West != null) {
            pLightNorth_South.goToGreen();
            pLightEast_West.goToRed();
        }

        cLightNorth_South.getLightBehaviour().redToGreen(cLightNorth_South);

        if(pLightEast_West != null) {
            pLightEast_West.goToGreen();
            pLightNorth_South.goToRed();
        }

        this.execute();
    }


    @Override
    public void emergency() {
        //Pedestrian Lights can be null for 4 way crossing without pedestrian Lights
        if(pLightEast_West != null) pLightEast_West.getLightBehaviour().emergency(pLightEast_West);
        if(pLightNorth_South != null) pLightNorth_South.getLightBehaviour().emergency(pLightNorth_South);
        cLightNorth_South.getLightBehaviour().emergency(cLightNorth_South);
        cLightEast_West.getLightBehaviour().emergency(cLightEast_West);
    }

    @Override
    public void nightmode() {
        //Pedestrian Lights can be null for 4 way crossing without pedestrian Lights
        if(pLightEast_West != null) pLightEast_West.getLightBehaviour().nightMode(pLightEast_West);
        if(pLightNorth_South != null) pLightNorth_South.getLightBehaviour().nightMode(pLightNorth_South);
        cLightNorth_South.getLightBehaviour().nightMode(cLightNorth_South);
        cLightEast_West.getLightBehaviour().nightMode(cLightEast_West);
    }

    @Override
    public void stop() {
        cLightEast_West.getLightBehaviour().stop(cLightEast_West);
        cLightNorth_South.getLightBehaviour().stop(cLightNorth_South);

    }

    @Override
    public void execute() {
        cLightNorth_South.getLightBehaviour().greenToRed(cLightNorth_South);

        if(pLightEast_West != null) {
            pLightEast_West.goToGreen();
            pLightNorth_South.goToRed();
        }

        cLightEast_West.getLightBehaviour().redToGreen(cLightEast_West);

        if(pLightEast_West != null) {
            pLightNorth_South.goToGreen();
            pLightEast_West.goToRed();
        }

        this.unexecute();
    }
}
