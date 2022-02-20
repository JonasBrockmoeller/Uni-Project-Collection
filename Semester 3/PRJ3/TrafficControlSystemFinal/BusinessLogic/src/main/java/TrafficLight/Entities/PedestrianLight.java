package TrafficLight.Entities;

import TrafficLight.UIOberserver.UIObserver;
import TrafficLight.UIOberserver.UISubject;
import TrafficLight.BehaviourImplementations.Pedestrian.PedestrianLightBehaviour;
import TrafficLight.Enum.Color;
import TrafficLight.Enum.Direction;
import TrafficLight.Enum.Mode;
import TrafficLight.Enum.Phase;
import TrafficLight.IObserver.Observer;
import TrafficLight.IObserver.Subject;

import java.util.ArrayList;

public class PedestrianLight implements Subject, IPedestrianLight, UISubject {
    public Phase phase;
    public Mode mode;
    private Direction direction;
    public PedestrianLightBehaviour lightBehaviour;
    private ArrayList<Observer> observer;
    private UIObserver uiobserver;


    public PedestrianLight(Phase phase, Mode mode, PedestrianLightBehaviour lightBehaviour, Direction direction) {
        this.phase = phase;
        this.mode = mode;
        this.lightBehaviour = lightBehaviour;
        this.observer = new ArrayList<Observer>();
        this.direction = direction;
    }

    @Override
    public Color button(){
        notifyObserver();
        return lightBehaviour.green(this);
    }

    @Override
    public void setLightBehaviour(PedestrianLightBehaviour b) {
        this.lightBehaviour = b;
    }

    @Override
    public Color goToGreen(){
        phase = Phase.GO;
        this.notifyUIObserver(Color.GREEN);
        System.out.println("The pedestrian light "+ direction +" is now: GREEN");
        return Color.GREEN;
    }
    @Override
    public Color goToRed(){
        phase = Phase.STOP;
        this.notifyUIObserver(Color.RED);
        System.out.println("The pedestrian light "+ direction +" is now: RED");
        return Color.RED;
    }
    @Override
    public Color prepareToStop() {
        phase = Phase.PREPARE_TO_STOP;
        this.notifyUIObserver(Color.YELLOW);
        System.out.println("The pedestrian light "+ direction +" is now: OFF");
        return Color.OFF;
    }


    @Override
    public PedestrianLightBehaviour getLightBehaviour() {
        return lightBehaviour;
    }
    @Override
    public Phase getPhase(){
        return this.phase;
    }

    public void setMode(Mode mode){
        this.mode = mode;
    }
    @Override
    public void registerObserver(Observer observer) {
        this.observer.add(observer);
    }

    @Override
    public void removeObserver() {
        this.observer.remove(observer);
    }

    @Override
    public void notifyObserver() {
        observer.forEach( o -> o.update());
    }

    @Override
    public void registerUIObserver(UIObserver obeserver) {
        this.uiobserver = obeserver;
    }

    @Override
    public void removeUIObserver() {
        this.uiobserver = null;
    }

    @Override
    public void notifyUIObserver(Color toShow) {
        if(this.uiobserver != null) {
            this.uiobserver.update(this, toShow);
        }
    }
}
