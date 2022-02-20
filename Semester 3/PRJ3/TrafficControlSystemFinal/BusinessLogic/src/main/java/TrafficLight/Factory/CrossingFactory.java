package TrafficLight.Factory;

import TrafficLight.Command.*;
import TrafficLight.Entities.CarLight;
import TrafficLight.Entities.PedestrianLight;
import TrafficLight.Entities.Crossing;
import TrafficLight.Enum.Direction;

public class CrossingFactory {
    private CarLightFactory carFactory;
    private PedestrianLightFactory pedFactory;
    private ICommand carGo;

    public CrossingFactory() {
        carFactory = new CarLightFactory();
        pedFactory = new PedestrianLightFactory();
    }

    public Crossing createSimpleCrossing(){
        CarLight carlight = carFactory.createGerman(Direction.STRAIGHT);
        PedestrianLight pedlight = pedFactory.createGerman(Direction.STRAIGHT);
        carGo = new SimpleCrossingCommand(carlight, pedlight);
        Crossing simpleCrossing = new Crossing(carGo);
        pedlight.registerObserver(simpleCrossing);
        return simpleCrossing;
    }

    public Crossing createSimpleCrossing(PedestrianLight pedL, CarLight carL) {
        carGo = new SimpleCrossingCommand(carL, pedL);
        Crossing simpleCrossing = new Crossing(carGo);
        pedL.registerObserver(simpleCrossing);
        return simpleCrossing;
    }

    public Crossing createFourWayCrossing(){
        CarLight carLightEW = carFactory.createGerman(Direction.EAST_WEST);
        PedestrianLight pedLightEW = pedFactory.createGerman(Direction.EAST_WEST);
        CarLight carLightNS = carFactory.createGerman(Direction.NORTH_SOUTH);
        PedestrianLight pedLightNS = pedFactory.createGerman(Direction.NORTH_SOUTH);
        carGo = new FourWayCrossingCommand(carLightEW, pedLightEW, carLightNS, pedLightNS);
        Crossing fourWayCrossing = new Crossing(carGo);
        pedLightEW.registerObserver(fourWayCrossing);
        return fourWayCrossing;
    }

    public Crossing createFourWayCrossingWithoutPedestrian(CarLight carLightEW, CarLight carLightNS){
        carGo = new FourWayCrossingCommand(carLightEW, carLightNS);
        return new Crossing(carGo);
    }

    public Crossing createFourWayCrossingWithTurns(CarLight carLightEW, CarLight carLightNS, CarLight turningLightNS){
        carGo = new CrossingWithTurnsCommand(carLightEW, carLightNS, turningLightNS);
        return new Crossing(carGo);
    }


    public  Crossing createCarLightCrossing(CarLight carL){
        carGo = new SimpleCarLightCommand(carL);
        return new Crossing(carGo);
    }

}
