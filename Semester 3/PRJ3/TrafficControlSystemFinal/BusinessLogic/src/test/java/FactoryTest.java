import TrafficLight.BehaviourImplementations.Car.DutchCar;
import TrafficLight.BehaviourImplementations.Car.GermanCar;
import TrafficLight.BehaviourImplementations.Pedestrian.DutchPedestrian;
import TrafficLight.BehaviourImplementations.Pedestrian.GermanPedestrian;
import TrafficLight.Command.FourWayCrossingCommand;
import TrafficLight.Command.SimpleCrossingCommand;
import TrafficLight.Entities.CarLight;
import TrafficLight.Entities.Crossing;
import TrafficLight.Entities.PedestrianLight;
import TrafficLight.Enum.Direction;
import TrafficLight.Factory.CarLightFactory;
import TrafficLight.Factory.CrossingFactory;
import TrafficLight.Factory.PedestrianLightFactory;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;

import static org.assertj.core.api.Assertions.assertThat;

public class FactoryTest {

    PedestrianLightFactory plFactory;
    CarLightFactory clFactory;
    CrossingFactory crFactory;

    public FactoryTest() {
        plFactory = new PedestrianLightFactory();
        clFactory = new CarLightFactory();
        crFactory = new CrossingFactory();
    }

    @BeforeEach
    public void init(){
        plFactory = new PedestrianLightFactory();
        clFactory = new CarLightFactory();
        crFactory = new CrossingFactory();
    }

    @Test
    public void testPedestrianFactory(){
        PedestrianLight german = plFactory.createGerman(Direction.STRAIGHT);
        PedestrianLight dutch = plFactory.createDutch(Direction.STRAIGHT);

        assertThat(german).isInstanceOf(PedestrianLight.class);
        assertThat(dutch).isInstanceOf(PedestrianLight.class);

        assertThat(german.getLightBehaviour()).isInstanceOf(GermanPedestrian.class);
        assertThat(dutch.getLightBehaviour()).isInstanceOf(DutchPedestrian.class);
    }

    @Test
    public void testCarFactory(){
        CarLight german = clFactory.createGerman(Direction.STRAIGHT);
        CarLight dutch = clFactory.createDutch(Direction.STRAIGHT);

        assertThat(german).isInstanceOf(CarLight.class);
        assertThat(dutch).isInstanceOf(CarLight.class);

        assertThat(german.getLightBehaviour()).isInstanceOf(GermanCar.class);
        assertThat(dutch.getLightBehaviour()).isInstanceOf(DutchCar.class);
    }

    @Test
    public void testCrossingFactory(){
        Crossing simpleCrossing = crFactory.createSimpleCrossing();
        Crossing fourWayCrossing = crFactory.createFourWayCrossing();

        assertThat(simpleCrossing).isInstanceOf(Crossing.class);
        assertThat(fourWayCrossing).isInstanceOf(Crossing.class);

        assertThat(simpleCrossing.getCommand()).isInstanceOf(SimpleCrossingCommand.class);
        assertThat(fourWayCrossing.getCommand()).isInstanceOf(FourWayCrossingCommand.class);
    }
}