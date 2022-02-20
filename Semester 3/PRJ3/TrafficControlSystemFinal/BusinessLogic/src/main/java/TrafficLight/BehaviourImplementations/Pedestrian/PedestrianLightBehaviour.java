package TrafficLight.BehaviourImplementations.Pedestrian;

import TrafficLight.BehaviourImplementations.LightBehaviourMain;
import TrafficLight.Entities.CarLight;
import TrafficLight.Entities.IPedestrianLight;
import TrafficLight.Entities.PedestrianLight;
import TrafficLight.Enum.Color;

public interface PedestrianLightBehaviour extends LightBehaviourMain {
    void request(IPedestrianLight light);
    Color stop(IPedestrianLight light);
    Color green(IPedestrianLight light);
    Color emergency(IPedestrianLight light);
    Color nightMode(PedestrianLight light);

    default void wait(int seconds){
        try {
            Thread.sleep(seconds * 1000);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
    }
}
