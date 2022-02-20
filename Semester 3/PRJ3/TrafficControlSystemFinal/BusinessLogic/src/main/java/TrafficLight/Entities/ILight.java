package TrafficLight.Entities;

import TrafficLight.BehaviourImplementations.LightBehaviourMain;
import TrafficLight.Enum.Color;
import TrafficLight.Enum.Phase;

public interface ILight {
    Color goToGreen();

    Color goToRed();

    Color prepareToStop();

    LightBehaviourMain getLightBehaviour();

    Phase getPhase();
}
