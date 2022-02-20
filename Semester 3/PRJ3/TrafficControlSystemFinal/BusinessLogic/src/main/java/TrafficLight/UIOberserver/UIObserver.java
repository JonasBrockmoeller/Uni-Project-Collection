package TrafficLight.UIOberserver;

import TrafficLight.Entities.ILight;
import TrafficLight.Enum.Color;

public interface UIObserver {
    void update(ILight light, Color toShow);
}
