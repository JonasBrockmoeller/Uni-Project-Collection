package TrafficLight.BehaviourImplementations;

import TrafficLight.BehaviourImplementations.Car.CarLightBehaviour;
import TrafficLight.BehaviourImplementations.Car.DutchCar;
import TrafficLight.BehaviourImplementations.Car.GermanCar;
import TrafficLight.Entities.CarLight;
import TrafficLight.Entities.ICarLight;
import TrafficLight.Enum.Direction;
import TrafficLight.Enum.Mode;
import TrafficLight.Enum.Phase;
import org.assertj.core.api.ThrowableAssert;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Disabled;
import org.junit.jupiter.api.Test;
import org.junit.jupiter.params.ParameterizedTest;
import org.junit.jupiter.params.provider.Arguments;
import org.junit.jupiter.params.provider.MethodSource;
import org.mockito.Mock;

import java.io.ByteArrayInputStream;
import java.io.InputStream;

import java.util.stream.Stream;

import static org.assertj.core.api.Assertions.assertThat;
import static org.assertj.core.api.Assertions.assertThatCode;
import static org.mockito.Mockito.*;

class CarBehaviourTest {

    private static DutchCar dutch = new DutchCar();;
    private static GermanCar german = new GermanCar();;

    @Mock
    private ICarLight light;

    public CarBehaviourTest(){
        this.init();
    }

    @BeforeEach
    public void init(){
        light = mock(ICarLight.class);
        dutch = new DutchCar();
        german = new GermanCar();
    }

    private static Stream<Arguments> ObjectProvider() {
        return Stream.of(
                Arguments.of(dutch),
                Arguments.of(german)
        );
    }

    @ParameterizedTest
    @MethodSource("ObjectProvider")
    void tstop(CarLightBehaviour behaviour){
        behaviour.stop(light);
        verify(light).goToRed();
    }

    @Disabled
    @ParameterizedTest
    @MethodSource("ObjectProvider")
    void temergency(CarLightBehaviour behaviour) {
        CarLight cLight = new CarLight(Phase.STOP, Mode.DAY_MODE, behaviour, Direction.STRAIGHT);

        ThrowableAssert.ThrowingCallable code = () -> {
                InputStream sysInBackup = System.in; // backup System.in to restore it later
                ByteArrayInputStream in = new ByteArrayInputStream("GO".getBytes());
                System.setIn(in);

                // do your thing
                //Color color = behaviour.emergency(cLight, Color.YELLOW);

                // optionally, reset System.in to its original
                System.setIn(sysInBackup);
                //assertThat(color).isEqualTo(Color.YELLOW);
        };

        assertThatCode( code)
                .as( "The emergency mode shall not throw an exception and exit the mode gracefullly")
                .doesNotThrowAnyException();
    }

    @Test
    void tGermanRedToGreen() {
        german.redToGreen(light);
        verify(light).prepareToGo();
        verify(light).goToGreen();
    }

    @Test
    void tDutchRedToGreen() {
        dutch.redToGreen(light);
        verify(light).goToGreen();
    }

    @ParameterizedTest
    @MethodSource("ObjectProvider")
    void tgreenToRed(CarLightBehaviour behaviour) {
        behaviour.greenToRed(light);
        verify(light).prepareToStop();
        verify(light).goToRed();
    }
}