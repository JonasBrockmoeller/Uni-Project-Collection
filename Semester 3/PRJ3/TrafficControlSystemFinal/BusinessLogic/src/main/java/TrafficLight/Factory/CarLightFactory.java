package TrafficLight.Factory;

import TrafficLight.BehaviourImplementations.Car.DutchCar;
import TrafficLight.BehaviourImplementations.Car.GermanCar;
import TrafficLight.Entities.CarLight;
import TrafficLight.Enum.Direction;
import TrafficLight.Enum.Mode;
import TrafficLight.Enum.Phase;

public class CarLightFactory implements AbstractLightFactory {

    public CarLight createGerman(Direction direction) {
        return new CarLight(Phase.STOP, Mode.DAY_MODE, new GermanCar(), direction);
    }

    public CarLight createDutch(Direction direction) {
        return new CarLight(Phase.STOP, Mode.DAY_MODE, new DutchCar(), direction);
    }
}
