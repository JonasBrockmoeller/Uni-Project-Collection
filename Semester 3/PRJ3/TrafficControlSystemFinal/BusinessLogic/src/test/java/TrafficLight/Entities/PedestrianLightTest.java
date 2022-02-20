package TrafficLight.Entities;

import TrafficLight.BehaviourImplementations.Pedestrian.GermanPedestrian;
import TrafficLight.BehaviourImplementations.Pedestrian.PedestrianLightBehaviour;
import TrafficLight.Enum.Color;
import TrafficLight.Enum.Direction;
import TrafficLight.Enum.Mode;
import TrafficLight.Enum.Phase;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;

import static org.assertj.core.api.Assertions.assertThat;

public class PedestrianLightTest {

    PedestrianLight pedLight;
    Phase phase;
    Mode mode;
    PedestrianLightBehaviour pedBehaviour;

    @BeforeEach
    void init(){
        pedBehaviour = new GermanPedestrian();
        pedLight = new PedestrianLight(phase, mode, pedBehaviour, Direction.STRAIGHT);
    }

    @Test
    void tGoToGreen(){
        assertThat(pedLight.goToGreen()).isEqualTo(Color.GREEN);
    }

    @Test
    void tGoToRed(){
        assertThat(pedLight.goToRed()).isEqualTo(Color.RED);
    }

    @Test
    void tPrepareToStop(){
        assertThat(pedLight.prepareToStop()).isEqualTo(Color.OFF);
    }

    @Test
    void tGetLightBehaviour(){
        assertThat(pedLight.getLightBehaviour()).isEqualTo(pedBehaviour);
    }

    @Test
    void tGetPhase(){
        assertThat(pedLight.getPhase()).isEqualTo(phase);
    }
}