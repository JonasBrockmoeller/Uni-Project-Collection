package TrafficLight.Entities;

import TrafficLight.UIOberserver.UIObserver;
import TrafficLight.UIOberserver.UISubject;
import TrafficLight.BehaviourImplementations.Car.CarLightBehaviour;
import TrafficLight.Enum.Color;
import TrafficLight.Enum.Direction;
import TrafficLight.Enum.Mode;
import TrafficLight.Enum.Phase;

public class CarLight implements ICarLight, UISubject {
    public Phase phase;
    public Mode mode;
    public CarLightBehaviour lightBehaviour;
    private Direction direction;
    private UIObserver uiObserver;

    public CarLight(Phase phase, Mode mode, CarLightBehaviour lightBehaviour, Direction direction) {
        this.phase = phase;
        this.mode = mode;
        this.lightBehaviour = lightBehaviour;
        this.lightBehaviour.setLight(this);
        this.direction = direction;
    }

    @Override
    public void start(){
        lightBehaviour.start( this);
    }

    @Override
    public Color goToGreen() {
        phase = Phase.GO;
        this.notifyUIObserver(Color.GREEN);
        System.out.println("The car light "+ direction +" is now: "+Color.GREEN);
        return Color.GREEN;
    }

    @Override
    public Color goToRed() {
        phase = Phase.STOP;
        this.notifyUIObserver(Color.RED);
        System.out.println("The car light "+ direction +" is now: RED");
        return Color.RED;
    }

    @Override
    public Color prepareToStop(){
        phase = Phase.PREPARE_TO_STOP;
        this.notifyUIObserver(Color.YELLOW);
        System.out.println("The car light "+ direction +" is now: YELLOW");
        return Color.YELLOW;
    }

    @Override
    public void prepareToGo(){
        phase = Phase.PREPARE_TO_STOP;
        this.notifyUIObserver(Color.RED_YELLOW);
        System.out.println("The car light "+ direction +" is now: RED & YELLOW");
    }

    @Override
    public Color turnOff() {
        phase = Phase.STOP;
        notifyUIObserver(Color.OFF);
        System.out.println("The car light "+ direction +" is now: OFF");
        return Color.OFF;
    }
    

    @Override
    public Color getLightColor() {
        switch(phase){
            case GO -> {
                return goToGreen();
            }
            case STOP -> {
                return goToRed();
            }
            case PREPARE_TO_STOP ->  {
                return prepareToStop();
            }
            default -> {
                return null;
            }
        }
    }
    @Override
    public CarLightBehaviour getLightBehaviour() {
        return lightBehaviour;
    }

    @Override
    public void setLightBehaviour(CarLightBehaviour b){;
        this.lightBehaviour = b;
    }

    @Override
    public Phase getPhase(){
        return this.phase;
    }

    @Override
    public void setMode(Mode mode) {
        this.mode = mode;
    }

    @Override
    public Mode getMode() {
        return null;
    }

    @Override
    public void registerUIObserver(UIObserver obeserver) {
        this.uiObserver = obeserver;
    }

    @Override
    public void removeUIObserver() {
        this.uiObserver = null;
    }

    @Override
    public void notifyUIObserver(Color toShow) {
        if(uiObserver!=null) {
            this.uiObserver.update(this, toShow);
        }
    }
}
