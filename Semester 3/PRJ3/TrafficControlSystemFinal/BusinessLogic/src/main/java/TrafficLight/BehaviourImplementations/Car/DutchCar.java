package TrafficLight.BehaviourImplementations.Car;

import TrafficLight.Entities.CarLight;
import TrafficLight.Entities.ICarLight;
import TrafficLight.Enum.Color;
import TrafficLight.Enum.Mode;


public class DutchCar implements CarLightBehaviour {

    CarLight light;

    public DutchCar(){
    }

    @Override
    public void start(ICarLight light) {
        this.light = (CarLight) light;
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
        wait(1);
        light.goToGreen();
    }

    @Override
    public void nightMode(CarLight light) {
        //go to Nightmode ( Dutch )
        light.setMode(Mode.NIGHT_MODE);
        System.out.println("Night Mode of dutch car light");
        light.prepareToStop();
    }

    @Override
    public void emergency(CarLight light) {
        //go to Emergency_Mode ( DUTCH )
        light.setMode(Mode.EMERGENCY_MODE);
        System.out.println("Emergency Mode of dutch car light");
        light.prepareToStop();
    }
}
