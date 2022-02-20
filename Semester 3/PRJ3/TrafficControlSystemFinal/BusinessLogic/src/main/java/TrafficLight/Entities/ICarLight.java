package TrafficLight.Entities;

import TrafficLight.BehaviourImplementations.Car.CarLightBehaviour;
import TrafficLight.Enum.Color;
import TrafficLight.Enum.Mode;
import TrafficLight.Enum.Phase;

public interface ICarLight extends ILight {
    void start();

    void prepareToGo();

    Color turnOff();

    void setLightBehaviour(CarLightBehaviour b);

    void setMode(Mode mode);

    Color getLightColor();

    Mode getMode();
}
