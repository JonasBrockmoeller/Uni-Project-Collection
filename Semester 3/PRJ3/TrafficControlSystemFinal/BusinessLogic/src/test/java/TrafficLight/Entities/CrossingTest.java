package TrafficLight.Entities;

import TrafficLight.Command.ICommand;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.mockito.Mock;

import static org.assertj.core.api.Assertions.assertThat;
import static org.mockito.Mockito.mock;
import static org.mockito.Mockito.verify;

public class CrossingTest {
    Crossing crossing;
    @Mock
    ICommand command = mock(ICommand.class);

    public CrossingTest() {
        crossing = new Crossing(command);
    }

    @BeforeEach
    public void init(){
        command = mock(ICommand.class);
        crossing = new Crossing(command);
    }

    @Test
    public void tstart() {
        crossing.start();

        verify(command).unexecute();
    }

    @Test
    public void tupdate() {
        crossing.update();

        //crossing.update calls crossing.request -> So command.execute is executed in the end
        verify(command).execute();
    }

    @Test
    public void tGetCommand() {
        ICommand returnedCommand = crossing.getCommand();

        assertThat(returnedCommand).isEqualTo(command);
    }
}
