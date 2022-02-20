package TrafficLight.Factory;

import TrafficLight.Entities.ILight;
import TrafficLight.Enum.Direction;

public interface AbstractLightFactory {
    ILight createDutch(Direction direction);
    ILight createGerman(Direction direction);
}
