package TrafficLight.Entities;

import TrafficLight.BehaviourImplementations.Car.GermanCar;
import TrafficLight.Enum.Color;
import TrafficLight.Enum.Direction;
import TrafficLight.Enum.Mode;
import TrafficLight.Enum.Phase;
import org.junit.jupiter.api.Test;

import static org.assertj.core.api.Assertions.assertThat;

public class CarLightTest {

    private CarLight light(){
        final CarLight carLight = new CarLight(Phase.GO, Mode.DAY_MODE, new GermanCar(), Direction.STRAIGHT);
        return carLight;
    }

    @Test
    void goToGreenTest(){
        assertThat(light().goToGreen()).isEqualTo(Color.GREEN);
    }

    @Test
    void prepareToStopTest(){
        assertThat(light().prepareToStop()).isEqualTo(Color.YELLOW);
    }

    @Test
    void goToRedTest(){
        assertThat(light().goToRed()).isEqualTo(Color.RED);
    }

    @Test
    void turnOffTest(){
        assertThat(light().turnOff()).isEqualTo(Color.OFF);
    }

    /*@Test
    void prepareToGo(){
        assertThat(light().prepareToGo()).isEqualTo(Color.YELLOW, Color.RED);
    }
     */

    @Test
    void getLightColorTest(){
        CarLight test = light();

        test.goToGreen();
        assertThat(test.getLightColor()).isEqualTo(Color.GREEN);

        test.prepareToStop();
        assertThat(test.getLightColor()).isEqualTo(Color.YELLOW);

        test.goToRed();
        assertThat(test.getLightColor()).isEqualTo(Color.RED);

    }

    @Test
    void getLightBehaviourTest(){
        assertThat(light().getLightBehaviour()).isInstanceOf(GermanCar.class);
    }

    @Test
    void getPhaseTest(){
        assertThat(light().getPhase()).isInstanceOf(Phase.class);
    }

    /*
    @Test
    void getModeTest(){assertThat(light().getMode()).isInstanceOf(Mode.class);}
     */
}
