package TrafficLight.BehaviourImplementations.Car;

import TrafficLight.Entities.CarLight;
import TrafficLight.Entities.ICarLight;
import TrafficLight.Enum.Mode;


//Car light Adapter for Right turn traffic lights
public class ArrowLight extends GermanCar{

    //change light color to green
    @Override
    public void redToGreen(ICarLight light) {
        wait(1);
        light.goToGreen();
    }

    //change light color to red
    @Override
    public void greenToRed(ICarLight light) {
        wait(1);
        light.goToRed();
    }

    @Override
    public void emergency(CarLight light){
        light.setMode(Mode.EMERGENCY_MODE);
        System.out.println("Emergency Mode of german car light");
        light.goToRed();
    }

}
