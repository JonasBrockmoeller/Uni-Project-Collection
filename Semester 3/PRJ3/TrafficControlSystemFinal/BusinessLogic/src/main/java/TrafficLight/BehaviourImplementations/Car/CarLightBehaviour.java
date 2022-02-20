package TrafficLight.BehaviourImplementations.Car;

import TrafficLight.BehaviourImplementations.LightBehaviourMain;
import TrafficLight.Entities.CarLight;
import TrafficLight.Entities.ICarLight;
import TrafficLight.Enum.Color;
import TrafficLight.IObserver.Observer;

public interface CarLightBehaviour extends LightBehaviourMain {

    void start(ICarLight light);
    void stop(ICarLight light);
    void emergency(CarLight light);

    default void wait(int seconds){
        try {
            Thread.sleep(seconds * 1000);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
    }

    void setLight(CarLight light);
    void redToGreen(ICarLight light);
    void greenToRed(ICarLight light);

    void nightMode(CarLight light);
}
