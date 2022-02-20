package TrafficLight.Command;

import TrafficLight.BehaviourImplementations.Car.GermanCar;
import TrafficLight.Entities.CarLight;
import TrafficLight.Entities.PedestrianLight;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.mockito.Mock;

import static org.mockito.Mockito.*;

public class FourWayCrossingCommandTest {
    FourWayCrossingCommand command;
    //2x PedestrianLightMock
    @Mock
    PedestrianLight pLight1 = mock(PedestrianLight.class);
    @Mock
    PedestrianLight pLight2 = mock(PedestrianLight.class);

    //2x CarLightBehaviourMock
    @Mock
    GermanCar behaviour1 = mock(GermanCar.class);
    @Mock
    GermanCar behaviour2 = mock(GermanCar.class);

    //2x CarLightObjects
    @Mock
    CarLight cLight1 = mock(CarLight.class);
    @Mock
    CarLight cLight2 = mock(CarLight.class);

    public FourWayCrossingCommandTest() {
        when(cLight1.getLightBehaviour()).thenReturn(behaviour1);
        when(cLight2.getLightBehaviour()).thenReturn(behaviour2);
        command = new FourWayCrossingCommand(cLight1, pLight1, cLight2, pLight2);
    }

    @BeforeEach
    public void init(){
        pLight1 = mock(PedestrianLight.class);
        pLight2 = mock(PedestrianLight.class);
        behaviour1 = mock(GermanCar.class);
        behaviour2 = mock(GermanCar.class);
        cLight1 = mock(CarLight.class);
        cLight2 = mock(CarLight.class);
        when(cLight1.getLightBehaviour()).thenReturn(behaviour1);
        when(cLight2.getLightBehaviour()).thenReturn(behaviour2);
        command = new FourWayCrossingCommand(cLight1, pLight1, cLight2, pLight2);
    }

    @Test
    public void texecute(){
        this.init();
        command.execute();

        verify(cLight1).getLightBehaviour();
        verify(behaviour1).redToGreen(cLight1);
        verify(pLight2).goToGreen();

        verify(cLight2).getLightBehaviour();
        verify(behaviour2).greenToRed(cLight2);
        verify(pLight1).goToGreen();
    }

    @Test
    public void tunexecute(){
        this.init();
        command.unexecute();

        verify(cLight1, times(2)).getLightBehaviour();
        verify(behaviour1).greenToRed(cLight1);
        verify(pLight2, times(2)).goToGreen();

        verify(cLight2, times(2)).getLightBehaviour();
        verify(behaviour2).redToGreen(cLight2);
        verify(pLight2, times(2)).goToRed();

        //GetLightBehaviour is called 2 times, because the unexecute methode
        //in the class FourWayCrossing calls the execute method...
    }
}
