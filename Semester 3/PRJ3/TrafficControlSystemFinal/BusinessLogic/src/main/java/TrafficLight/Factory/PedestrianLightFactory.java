package TrafficLight.Factory;

import TrafficLight.BehaviourImplementations.Pedestrian.DutchPedestrian;
import TrafficLight.BehaviourImplementations.Pedestrian.GermanPedestrian;
import TrafficLight.Entities.PedestrianLight;
import TrafficLight.Enum.Direction;
import TrafficLight.Enum.Mode;
import TrafficLight.Enum.Phase;

public class PedestrianLightFactory implements AbstractLightFactory{

    public PedestrianLight createGerman(Direction direction) {
        return new PedestrianLight(Phase.STOP, Mode.DAY_MODE, new GermanPedestrian(), direction);
    }

    public PedestrianLight createDutch(Direction direction) {
        return new PedestrianLight(Phase.STOP, Mode.DAY_MODE, new DutchPedestrian(), direction);
    }

}
