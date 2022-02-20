package TrafficLight.Command;

import TrafficLight.BehaviourImplementations.Car.GermanCar;
import TrafficLight.BehaviourImplementations.Pedestrian.DutchPedestrian;
import TrafficLight.Entities.CarLight;
import TrafficLight.Entities.PedestrianLight;
import TrafficLight.Enum.Direction;
import TrafficLight.Enum.Mode;
import TrafficLight.Enum.Phase;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.mockito.Mock;

import static org.assertj.core.api.Assertions.assertThat;
import static org.mockito.Mockito.*;

public class SimpleCrossingCommandTest {
    SimpleCrossingCommand command;
    @Mock
    PedestrianLight pLight1 = mock(PedestrianLight.class);
    @Mock
    GermanCar behaviour1 = mock(GermanCar.class);
    @Mock
    CarLight cLight1 = mock(CarLight.class);

    public SimpleCrossingCommandTest() {
        when(cLight1.getLightBehaviour()).thenReturn(behaviour1);
        command = new SimpleCrossingCommand(cLight1, pLight1);
    }

    @BeforeEach
    public void init(){
        pLight1 = mock(PedestrianLight.class);
        behaviour1 = mock(GermanCar.class);
        cLight1 = mock(CarLight.class);
        when(cLight1.getLightBehaviour()).thenReturn(behaviour1);
        command = new SimpleCrossingCommand(cLight1, pLight1);
    }

    @Test
    public void tExecute(){
        command.execute();

        verify(behaviour1).greenToRed(cLight1);
        verify(pLight1).goToGreen();
    }

    @Test
    public void tUnexecute(){
        command.unexecute();

        verify(pLight1).goToRed();
        verify(behaviour1).redToGreen(cLight1);
    }

    @Test
    public void tgetPlight(){
        PedestrianLight pl = new PedestrianLight(Phase.GO, Mode.DAY_MODE, new DutchPedestrian(), Direction.STRAIGHT);
        command = new SimpleCrossingCommand(cLight1, pl);
        PedestrianLight pedestrianLight = command.getpLight();

        assertThat(pedestrianLight).isEqualTo(pl);
    }
}
