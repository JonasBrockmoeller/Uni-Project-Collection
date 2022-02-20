package TrafficLight.BehaviourImplementations;

        import TrafficLight.BehaviourImplementations.Pedestrian.DutchPedestrian;
        import TrafficLight.BehaviourImplementations.Pedestrian.GermanPedestrian;
        import TrafficLight.BehaviourImplementations.Pedestrian.PedestrianLightBehaviour;
        import TrafficLight.Entities.IPedestrianLight;
        import org.junit.jupiter.api.BeforeEach;
        import org.junit.jupiter.params.ParameterizedTest;
        import org.junit.jupiter.params.provider.Arguments;
        import org.junit.jupiter.params.provider.MethodSource;
        import org.mockito.Mock;

        import java.util.stream.Stream;

        import static org.assertj.core.api.Assertions.assertThat;
        import static org.mockito.Mockito.*;

class PedestrainBehaviourTest {

    private static DutchPedestrian dutch = new DutchPedestrian();
    private static GermanPedestrian german = new GermanPedestrian();

    @Mock
    private IPedestrianLight light;

    public PedestrainBehaviourTest(){
        this.init();
    }

    @BeforeEach
    public void init(){
        light = mock(IPedestrianLight.class);
        dutch = new DutchPedestrian();
        german = new GermanPedestrian();
    }

    private static Stream<Arguments> ObjectProvider() {
        return Stream.of(
                Arguments.of(dutch),
                Arguments.of(german)
        );
    }

    @ParameterizedTest
    @MethodSource("ObjectProvider")
    void tstop(PedestrianLightBehaviour behaviour){
        behaviour.stop(light);
        verify(light).goToRed();
    }

    @ParameterizedTest
    @MethodSource("ObjectProvider")
    void trequest(PedestrianLightBehaviour behaviour){
        behaviour.request(light);
        verify(light, times(2)).goToRed();
        verify(light, times(1)).goToGreen();
    }

    @ParameterizedTest
    @MethodSource("ObjectProvider")
    void temergency(PedestrianLightBehaviour behaviour) {
        behaviour.emergency(light);
        verify(light).goToRed();
    }
}