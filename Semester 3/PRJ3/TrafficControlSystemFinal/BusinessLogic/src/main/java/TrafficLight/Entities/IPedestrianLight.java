package TrafficLight.Entities;

import TrafficLight.BehaviourImplementations.Car.CarLightBehaviour;
import TrafficLight.BehaviourImplementations.Pedestrian.PedestrianLightBehaviour;
import TrafficLight.Enum.Color;
import TrafficLight.Enum.Mode;
import TrafficLight.Enum.Phase;
import TrafficLight.IObserver.Subject;

public interface IPedestrianLight extends Subject, ILight {
    Color button();
    void setLightBehaviour(PedestrianLightBehaviour b);

    void setMode(Mode emergencyMode);
}
