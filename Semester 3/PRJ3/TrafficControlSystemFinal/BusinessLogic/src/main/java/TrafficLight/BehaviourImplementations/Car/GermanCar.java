package TrafficLight.BehaviourImplementations.Car;

import TrafficLight.Entities.CarLight;
import TrafficLight.Entities.ICarLight;
import TrafficLight.Enum.Color;
import TrafficLight.Enum.Mode;

public class GermanCar implements CarLightBehaviour {

    CarLight light;

    public GermanCar() {
    }

    @Override
    public void start(ICarLight light) {
        this.light = (CarLight) light;
            light.prepareToGo();
            wait(1);
            light.goToGreen();
    }

    @Override
    public void stop(ICarLight light) {
        light.prepareToStop();
        wait(1);
        light.goToRed();
    }


    @Override
    public void setLight(CarLight light) {
        this.light = light;
    }

    @Override
    public void greenToRed(ICarLight light) {
            light.prepareToStop();
            wait(1);
            light.goToRed();
    }

    @Override
    public void redToGreen(ICarLight light) {
        light.prepareToGo();
        wait(1);
        light.goToGreen();
    }

    @Override
    public void nightMode(CarLight light) {
        //go to Night_Mode ( German )
        light.setMode(Mode.NIGHT_MODE);
        System.out.println("Night Mode Mode of german car light");
        light.prepareToStop();

    }

    @Override
    public void emergency(CarLight light) {
        //go to Emergency_Mode ( German )
        light.setMode(Mode.EMERGENCY_MODE);
        System.out.println("Emergency Mode of german car light");
        light.prepareToStop();
    }
}
