package TrafficLight.UIOberserver;

import TrafficLight.Enum.Color;

public interface UISubject {
    void registerUIObserver(UIObserver obeserver);
    void removeUIObserver();
    void notifyUIObserver(Color color);
}
