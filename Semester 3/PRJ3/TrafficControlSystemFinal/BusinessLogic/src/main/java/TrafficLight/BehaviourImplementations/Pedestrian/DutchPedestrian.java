package TrafficLight.BehaviourImplementations.Pedestrian;

import TrafficLight.Entities.IPedestrianLight;
import TrafficLight.Entities.PedestrianLight;
import TrafficLight.Enum.Color;
import TrafficLight.Enum.Mode;

public class DutchPedestrian implements PedestrianLightBehaviour {
    @Override
    public void request(IPedestrianLight light) {
        light.goToGreen();
        wait(10);
        light.goToRed();
    }

    @Override
    public Color stop(IPedestrianLight light) {
        return light.goToRed();
    }

    @Override
    public Color green(IPedestrianLight light) {
        return light.goToGreen();

    }

    @Override
    public Color emergency(IPedestrianLight light) {
        light.setMode(Mode.EMERGENCY_MODE);
        System.out.println("Emergency Mode of dutch pedestrian light");
            return light.goToRed();
    }

    @Override
    public Color nightMode(PedestrianLight light) {
        light.setMode(Mode.NIGHT_MODE);
        System.out.println("Night Mode of dutch pedestrian light");
        return light.goToRed();
    }
}